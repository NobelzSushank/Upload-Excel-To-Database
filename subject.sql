CREATE TABLE IF NOT EXISTS `subject` ( 
`sub_id` INT(11) NOT NULL AUTO_INCREMENT , 
`sub_code` VARCHAR(30) NOT NULL , 
`sub_name` VARCHAR(30) NOT NULL , 
PRIMARY KEY (`sub_id`) 
) ENGINE = InnoDB DEFAULT CHARSET = latin1; 