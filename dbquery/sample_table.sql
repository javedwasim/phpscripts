CREATE TABLE `Items` (
  `itemID` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` tinytext NOT NULL,
  `catID` int(11) NOT NULL,
  PRIMARY KEY  (`itemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;