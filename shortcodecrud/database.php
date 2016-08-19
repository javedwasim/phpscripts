<?php

/*CREATE USER TABLE FOR THE SAME. */

CREATE TABLE IF NOT EXISTS `bh_user_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` text NOT NULL,
  `active_status` int(1) NOT NULL COMMENT '0:inactive, 1:active',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


?>