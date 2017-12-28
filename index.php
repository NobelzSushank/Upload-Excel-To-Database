<?php 
$servername ="localhost"; 
$username ="root"; 
$password =""; 
$dbname ="student"; 
//Create Connection 
$con = mysqli_connect ($servername, $username, $password, $dbname); 
//Check Connection 
if (!$con) { 
die ( "Connection Failed: " . mysqli_connect_error($con) ); 
}
if ( isset($_POST['submit'])) { 
if ( isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "" ) { 
$allowedExtensions = array("xls","xlsx"); 
// Return the extension of the file 
$ext = pathinfo( $_FILES['uploadFile']['name'] , PATHINFO_EXTENSION ); 
if ( in_array ($ext, $allowedExtensions)){ 
$isUploaded = $_FILES['uploadFile']['tmp_name']; 
if ($isUploaded) { 
include "Classes/PHPExcel/IOFactory.php"; 

try { 
$objPHPExcel = PHPExcel_IOFactory::load($isUploaded); 
} catch (Exception $e) { 
die ( 'Error loading file "' . pathinfo($isUploaded, PATHINFO_BASENAME ) . '": ' . $e->getMessage()); 
} 
// An ecel file may contains many sheets so you have to specify which one you need to read or work with. 
$sheet = $objPHPExcel->getSheet(0); 
// It returns the highest number of rows. 
$total_rows = $sheet->getHighestRow(); 
// It returns the highest number of columns. 
$highest_column = $sheet->getHighestColumn(); 
//Table used to display the contents of the file 
echo '<table class="responsive" cellpadding="5" cellspacing="1" border="1">'; 
// Loop through each row of the worksheet in turn 
for ($row = 2 ; $row <= $total_rows; $row++) { 
// Read a row of data into an array 
$rowData = $sheet-> rangeToArray ('A' . $row . ':' . $highest_column . $row, NULL, TRUE, FALSE); 
$sub_code = $rowData[0][0]; 
$sub_name = $rowData[0][1]; 
$sql = " INSERT INTO subject ( sub_code, sub_name ) VALUES ( '".$sub_code."', '".$sub_name."' ) " ; 
$result = mysqli_query($con,$sql); 
} 
if ( $result) { 
echo "<script type=\"text/javascript\"> 
alert(\"File is uploaded Successfully.\"); 
</script>"; 
}else { 
echo "ERROR: " . mysqli_error($con); 
} 
echo '</table>'; 
} else { 
echo '<span class="msg">File not uploaded!</span>'; 
} 
} else { 
echo '<span class="msg">This type of file not allowed!</span>'; 
} 
} 
else { echo '<span class="msg">Select an excel file first!</span>'; 
} 
} 
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
<!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  -->

</head>
<body>

  <form enctype="multipart/form-data" method="POST" role="form"> 
<label for="upload"> Excel File Upload </label> 
<input type="file" name="uploadFile" value=""> 
<p class="help-block"> Only .xls/.xlxs extension File format. </p>
<input type="submit" name="submit" value="Upload"> 
</form>

</body>
</html>