------------------------------------------------------------------------------
--- To test the mysqlForm class, just execute the sql queries below ----------
------------------------------------------------------------------------------

CREATE DATABASE FormTest;
use FormTest;		

CREATE TABLE `user` (
  `id` int(11) unsigned zerofill NOT NULL auto_increment,
  `user` varchar(10) NOT NULL default '',
  `password` varchar(10) NOT NULL default '',
  `name` varchar(50) default NULL,
  `Sex` enum('Male','Female') NOT NULL default 'Male',
  `email` varchar(50) NOT NULL default '',
  `phone` varchar(20) default NULL,
  `address` varchar(150) default NULL,
  `profession` varchar(30) default NULL,
  `org` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table for user data' AUTO_INCREMENT=8 ;

INSERT INTO `user` VALUES (00000000001, 'anis', '123456', 'Anis uddin Ahmad', 'Male', 'anisniit@gmail.com', '01718133849', 'Monsha, Patiya, Chittagong.', 'Student', 'Chittagong College');
INSERT INTO `user` VALUES (00000000002, 'ashraf', '123e', 'Ashraf Ali', 'Male', 'ashraf@gmail.com', '3241234123', 'Uzirpur, Patiya, Chittagong.', 'Student', 'CUET');
INSERT INTO `user` VALUES (00000000006, 'alam', '09876', 'Sheak Shahidul Alam', 'Male', 'skalam@yahoo.com', '09325793218', '3rd planet from the SUN', 'Student', 'Patiya College');
INSERT INTO `user` VALUES (00000000005, 'anis2', 'asdfg', 'Anis uddin Ahmad', 'Male', 'anis_niit@yahoo.com', '2135432145', 'sadAS', '', '');
INSERT INTO `user` VALUES (00000000007, 'test', 'qwerf', 'dfgvdfg', 'Male', 'sadfd@rt.hh', 'asdfasd', '', '', '');
