/*
SQLyog Ultimate v10.42 
MySQL - 5.6.43-log : Database - blog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`blog` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `blog`;

/*Table structure for table `tbl_comment` */

DROP TABLE IF EXISTS `tbl_comment`;

CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `STATUS` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_post` (`post_id`),
  CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `tbl_post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_comment` */

/*Table structure for table `tbl_lookup` */

DROP TABLE IF EXISTS `tbl_lookup`;

CREATE TABLE `tbl_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `CODE` int(11) NOT NULL,
  `TYPE` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `POSITION` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_lookup` */

insert  into `tbl_lookup`(`id`,`NAME`,`CODE`,`TYPE`,`POSITION`) values (1,'Draft',1,'PostStatus',1),(2,'Published',2,'PostStatus',2),(3,'Archived',3,'PostStatus',3),(4,'Pending Approval',1,'CommentStatus',1),(5,'Approved',2,'CommentStatus',2);

/*Table structure for table `tbl_post` */

DROP TABLE IF EXISTS `tbl_post`;

CREATE TABLE `tbl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci,
  `STATUS` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_author` (`author_id`),
  CONSTRAINT `FK_post_author` FOREIGN KEY (`author_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_post` */

/*Table structure for table `tbl_tag` */

DROP TABLE IF EXISTS `tbl_tag`;

CREATE TABLE `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_tag` */

insert  into `tbl_tag`(`id`,`NAME`,`frequency`) values (1,'yii',1),(2,'blog',1),(3,'test',1);

/*Table structure for table `tbl_user` */

DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `profile` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`id`,`username`,`password_hash`,`email`,`profile`) values (6,'demo18','$2y$13$p0tYns/xBpKUtpteDhvHuub2mCRX/nrnfIvKspbb4u1QKT/Z/yvA.','demo18@gmail.com','nguyen van a214'),(7,'demo47','$2y$13$VO39m6JuNzMmTYmTnTOKHef43v69ulhl14QfiOE1etMYn99t9zFrW','demo47@gmail.com','nguyen van a6 update'),(10,'demo6','$2y$13$32ETU0GcdkIOCPqJdynmduHgx47.x.0kEqHrNVGpTIr25H1ZgA3Y.','demo6@gmail.com','nguyen van a62'),(12,'demo17','$2y$13$jXokR/Y4VrY496s39W383OM8DOzYVkgLKGiHjkZCUwZJQeB9xOVCO','demo17@gmail.com','nguyen van a487 update'),(13,'demo9','$2y$13$kOPTW3rwtPlXq0sHpxS/uORDdsCBS9LBUDQgBfmDT/lNXVn/fXud6','demo9@gmail.com','nguyen van a542'),(16,'demo3','$2y$13$b3ELyGv9pkT580iVR/pyh.V5GKsjkfphOSS1U0THhH5qWTMy3mzPq','demo3@gmail.com','nguyen van a13'),(17,'demo30','$2y$13$6xX5BCc28V5kbCMKbpZ2De5yUIPVHEhn.ANSLpOwe1UiemAuVfajK','demo30@gmail.com','nguyen van a14'),(19,'demo34','$2y$13$I5t7crD9UC/6ZdjsgY1Rp.BWN/AVxjEztkmyv5Tr5ilazY2i.shpK','demo34@gmail.com','nguyen van a62'),(20,'demo27','$2y$13$FFSH4INezOJV9eiHWai58OTttvHnA.0tJqWy9nF3IBX6qZ/7pV9v6','demo27@gmail.com','nguyen van a818'),(22,'demo13','$2y$13$SCRLa/jMYd8OCx8C3bkCuO2gv/iHVRb.1msyeBZuMVPFwtzUsw.Qu','demo13@gmail.com','nguyen van a728'),(23,'demo49','$2y$13$EAx69yLd4QXKQdfpZva3yODRs7Kqovfx.b28cF5u3LBhbpO.lzoQa','demo49@gmail.com','nguyen van a355'),(24,'admin','$2y$13$RUEO7gIwTBPXJ0nvpOhQKe33ZC./WeoA5ROedEl76RARfhe4hUur6','manhnv04778@gmail.com','Nghiêm Văn Mạnh');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
