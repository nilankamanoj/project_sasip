CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int(4) NOT NULL AUTO_INCREMENT,
  `identity_no` varchar(6) NOT NULL,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(10) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
identity_no
first_name
last_name
phone_number
school_name
added_by`
