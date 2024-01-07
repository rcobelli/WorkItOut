# ************************************************************
# Sequel Ace SQL dump
# Version 20056
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 8.1.0)
# Database: work_it_out
# Generation Time: 2024-01-07 04:55:56 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table race_trainings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `race_trainings`;

CREATE TABLE `race_trainings` (
  `training_id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `race_id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` blob,
  PRIMARY KEY (`training_id`),
  UNIQUE KEY `date` (`date`,`race_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table races
# ------------------------------------------------------------

DROP TABLE IF EXISTS `races`;

CREATE TABLE `races` (
  `race_id` int unsigned NOT NULL AUTO_INCREMENT,
  `race_name` varchar(25) NOT NULL,
  `race_date` date NOT NULL,
  `race_sport` int NOT NULL,
  PRIMARY KEY (`race_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table recurring_trainings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `recurring_trainings`;

CREATE TABLE `recurring_trainings` (
  `training_id` int unsigned NOT NULL AUTO_INCREMENT,
  `day` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `training_sport` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` blob,
  PRIMARY KEY (`training_id`),
  UNIQUE KEY `day` (`day`,`training_sport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table sports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sports`;

CREATE TABLE `sports` (
  `sport_id` int unsigned NOT NULL AUTO_INCREMENT,
  `sport_name` varchar(25) NOT NULL,
  PRIMARY KEY (`sport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
