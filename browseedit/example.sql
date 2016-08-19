

CREATE TABLE `table_1` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50)  NOT NULL,
  `sex` enum('male','female')  NOT NULL,
  `country` int(11) NOT NULL,
  `age` int(3) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM ;



INSERT INTO `table_1` VALUES (1, 'cesar rodas', 'male', 2, 5, 'saddor@foo.com');



CREATE TABLE `table_2` (
  `countryId` int(11) NOT NULL auto_increment,
  `countryName` varchar(50) NOT NULL,
  KEY `countryId` (`countryId`)
) ENGINE=MyISAM  ;



INSERT INTO `table_2` VALUES (1, 'Paraguay');
INSERT INTO `table_2` VALUES (2, 'Brazil');
INSERT INTO `table_2` VALUES (3, 'Argentina');
INSERT INTO `table_2` VALUES (4, 'Chile');
