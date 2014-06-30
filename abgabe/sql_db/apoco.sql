
--
-- Datenbank: `apoco`
--

-- --------------------------------------------------------

DROP TABLE IF EXISTS `wunschgewicht`;
DROP TABLE IF EXISTS `tageseinheiten`;
DROP TABLE IF EXISTS `bodyweight`;
DROP TABLE IF EXISTS `bloodpressure`;
DROP TABLE IF EXISTS `mealenergy_content`;
DROP TABLE IF EXISTS `mealenergy`;
DROP TABLE IF EXISTS `user`;


--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(50) NOT NULL,
  
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Tabellenstruktur für Tabelle `bodyweight`
--

CREATE TABLE IF NOT EXISTS `bodyweight` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `weight` varchar(11) NOT NULL,
  `unit` varchar(6) NOT NULL,
  
  PRIMARY KEY (`_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Tabellenstruktur für Tabelle `bloodpressure`
--

CREATE TABLE IF NOT EXISTS `bloodpressure` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diastolic` varchar(11) NOT NULL,
  `systolic` varchar(11) NOT NULL,
  `pulse` varchar(11) NOT NULL,
  
  PRIMARY KEY (`_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Tabellenstruktur für Tabelle `mealenergy`
--

CREATE TABLE IF NOT EXISTS `mealenergy` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Tabellenstruktur für Tabelle `mealenergy_content`
--

CREATE TABLE IF NOT EXISTS `mealenergy_content` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `meal_id` int(11) NOT NULL,
  `barcode` varchar(13),
  `energie_kcal` int(11),
  `weight` varchar(11),
  
  PRIMARY KEY (`_id`),
  KEY `meal_id` (`meal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Tabellenstruktur für Tabelle `tageseinheiten`
--

 CREATE TABLE IF NOT EXISTS `tageseinheiten` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `added_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tageseinheiten` int(11) DEFAULT 2200,
 
  PRIMARY KEY (`_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `wunschgewicht` (
	`_id` int(11) NOT NULL AUTO_INCREMENT,
	`u_id` int(11) NOT NULL,
	`added_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,	
	`wunschgewicht` varchar(11) DEFAULT 0,
	`unit` varchar(6) NOT NULL DEFAULT 'kg',
	
	PRIMARY KEY (`_id`),
	KEY `u_id` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Trigger für User
--

DROP TRIGGER IF EXISTS `user_trigger`;
DELIMITER //
CREATE TRIGGER `user_trigger` AFTER INSERT ON `user`
 FOR EACH ROW insert into tageseinheiten
(u_id) values(new._id)
//
DELIMITER ;



ALTER TABLE `bodyweight`
  ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`_id`);
  
ALTER TABLE `bloodpressure`
  ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`_id`);
  
ALTER TABLE `mealenergy`
  ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`_id`);

ALTER TABLE `mealenergy_content`
  ADD FOREIGN KEY (`meal_id`) REFERENCES `mealenergy` (`_id`);
  
ALTER TABLE `tageseinheiten`
  ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`_id`);
  
ALTER TABLE `wunschgewicht`
  ADD FOREIGN KEY (`u_id`) REFERENCES `user` (`_id`);

