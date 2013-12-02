CREATE TABLE IF NOT EXISTS `messages` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(140) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `used` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`messageID`)
);

CREATE TABLE IF NOT EXISTS `terms` (
  `termID` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `searched` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `votes_pro` int(11) NOT NULL,
  `votes_con` int(11) NOT NULL,
  PRIMARY KEY (`termID`),
  UNIQUE KEY `term` (`term`)
);

CREATE TABLE IF NOT EXISTS `tweets` (
  `tweetID` bigint(20) NOT NULL AUTO_INCREMENT,
  `termID` int(11) NOT NULL,
  `statusID` text NOT NULL,
  `replyID` text NOT NULL,
  `userID` text NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`tweetID`),
  KEY `tweets_terms_termid` (`termID`)
);

ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_terms_termid` FOREIGN KEY (`termID`) REFERENCES `terms` (`termID`);
