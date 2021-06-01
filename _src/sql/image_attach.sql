/*
SQLyog Ultimate v12.08 (64 bit)
MySQL - 5.5.25 : Database - tender
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tender` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `tender`;

/*Table structure for table `image_attach` */

DROP TABLE IF EXISTS `image_attach`;

CREATE TABLE `image_attach` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `name_user` varchar(100) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `for_what` int(10) DEFAULT NULL COMMENT 'для чего фото сертификат, тендер, сро',
  `id_object` int(10) unsigned NOT NULL COMMENT 'номер тендера, пользователя и т.д.',
  `displayOrder` int(10) unsigned DEFAULT NULL,
  `visible` tinyint(1) unsigned DEFAULT NULL,
  `datetimes` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=232 DEFAULT CHARSET=utf8;

/*Table structure for table `v_error` */

DROP TABLE IF EXISTS `v_error`;

CREATE TABLE `v_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(200) DEFAULT NULL,
  `error` varchar(200) DEFAULT NULL,
  `date_error` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
