/*
SQLyog Ultimate v12.3.2 (64 bit)
MySQL - 5.5.25 : Database - atsunru_interstroi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `atsunru_interstroi`;

/*Table structure for table `_FIND` */

DROP TABLE IF EXISTS `_FIND`;

CREATE TABLE `_FIND` (
  `USER` varchar(20) NOT NULL DEFAULT '',
  `PARAGRAF` varchar(120) NOT NULL DEFAULT '',
  `LEVEL` int(10) unsigned NOT NULL,
  `FINDER` text,
  `FIELD_DATA` text COMMENT 'field:data...',
  `NAME` text COMMENT 'для вывода',
  `PARENT` tinytext COMMENT 'признак фильтра',
  `DATA` text COMMENT 'данные по name',
  PRIMARY KEY (`USER`,`PARAGRAF`,`LEVEL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `_FORM` */

DROP TABLE IF EXISTS `_FORM`;

CREATE TABLE `_FORM` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PARAGRAF` tinytext NOT NULL,
  `displayOrder` int(11) NOT NULL DEFAULT '0',
  `TABLE_NAME` text,
  `VISIBLE` tinyint(1) NOT NULL DEFAULT '0',
  `NONEDIT` tinyint(1) NOT NULL DEFAULT '0',
  `COLUMN_FIELD` text,
  `COLUMN_SIZE` text NOT NULL COMMENT 'ширина ; высота',
  `COLUMN_NAME` text,
  `COLUMN_DEFAULT` text,
  `TYPE_FIELD` tinytext,
  `kind_FIND` tinytext COMMENT 'Включать в поиск как',
  `kind_bold` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'толщина',
  `SOURCE_FIELD` text COMMENT 'поле из связанной таблицы',
  `SOURCE_TABLE` text COMMENT 'связанная таблица',
  `SOURCE_ID` text COMMENT 'ключевое полесвязанной таблицы',
  `SOURCE_FILTER` text COMMENT 'фильтр для связанных таблиц',
  `FILE_DIR` text COMMENT 'составляющая пути и имени файла',
  `CHILD` tinytext COMMENT 'Параграф формы запуска',
  `MASTER` varchar(10) DEFAULT NULL COMMENT 'Тип зависимости MASTER/SLAVE/FILTER',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6576 DEFAULT CHARSET=utf8;

/*Table structure for table `_RIGHT` */

DROP TABLE IF EXISTS `_RIGHT`;

CREATE TABLE `_RIGHT` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `PARAGRAF` varchar(127) DEFAULT NULL,
  `permissions` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

/*Table structure for table `_ROLE` */

DROP TABLE IF EXISTS `_ROLE`;

CREATE TABLE `_ROLE` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `role` varchar(10) DEFAULT 'user',
  `filter` text,
  `color1` varchar(10) DEFAULT NULL,
  `color2` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Table structure for table `_TREE` */

DROP TABLE IF EXISTS `_TREE`;

CREATE TABLE `_TREE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PARAGRAF` text,
  `PARENT` text NOT NULL,
  `NAME` text COMMENT 'название параграфа',
  `TYPE_FORM` text COMMENT 'Заголовок',
  `kind_ADD` int(11) DEFAULT NULL,
  `kind_EDIT` int(11) DEFAULT NULL,
  `kind_moved` tinyint(1) DEFAULT NULL,
  `kind_delete` tinyint(1) DEFAULT NULL,
  `kind_FIND` int(11) DEFAULT NULL,
  `parent_TABLE` text NOT NULL COMMENT 'Родительская связанная таблица',
  `parent_COLUMN` text NOT NULL COMMENT 'Поле для связи в родительской таблицей',
  `parent_TITLE` text COMMENT 'Поле заголовка изродительской таблицы',
  `ID_TABLE` text COMMENT 'Основная таблица формы',
  `ID_COLUMN` text NOT NULL COMMENT 'Поле для связи c родительской таблицей',
  `ID_ORDER` text CHARACTER SET cp1251 COLLATE cp1251_bin COMMENT 'Наложение сортировки (перезаписываемое)',
  `FILTER` text COMMENT 'дополнительный фильтр типа: type="left"',
  `sys_TEXT` text COMMENT 'sys текст в форме',
  `sys_BUTTON` tinytext COMMENT 'sys название кнопки',
  `sys_URL` text COMMENT 'sys URL',
  `sys_SQL` text COMMENT 'sys SQL',
  `DEBUG` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1094 DEFAULT CHARSET=utf8;

/*Table structure for table `_XML` */

DROP TABLE IF EXISTS `_XML`;

CREATE TABLE `_XML` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc` text NOT NULL,
  `lastmod` date DEFAULT NULL,
  `changefreq` tinytext,
  `priority` tinytext,
  `SOURCE_TABLE` text,
  `SOURCE_TABLE_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Trigger structure for table `c_cash` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `cash_update_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `cash_update_after` AFTER UPDATE ON `c_cash` FOR EACH ROW BEGIN
    if (NEW.status<>OLD.status) then
        CASE NEW.status
      WHEN 0 THEN update i_implementer set summa_paid=summa_paid-new.summa_rco where id=new.id_implementer;
      WHEN 1 THEN update i_implementer set summa_paid=summa_paid+new.summa_rco where id=new.id_implementer;
      
      END CASE;
        
    END IF;
    END */$$


DELIMITER ;

/* Trigger structure for table `i_implementer` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `implementer_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `implementer_update` BEFORE UPDATE ON `i_implementer` FOR EACH ROW BEGIN
        SET NEW.summa_debt = NEW.summa_made-NEW.summa_paid;
    END */$$


DELIMITER ;

/* Trigger structure for table `i_implementer` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `implementer_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `implementer_delete` BEFORE DELETE ON `i_implementer` FOR EACH ROW BEGIN
update i_razdel2 set id_implementer=null WHERE id_implementer=OLD.id;
END */$$


DELIMITER ;

/* Trigger structure for table `i_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `material_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `material_insert` BEFORE INSERT ON `i_material` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price>0) then
SET NEW.subtotal = NEW.count_units*NEW.price;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `i_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `material_insert_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `material_insert_after` AFTER INSERT ON `i_material` FOR EACH ROW 
BEGIN
UPDATE i_razdel2 
SET 
summa_material=summa_material+NEW.subtotal, 
summa_mat_realiz=summa_mat_realiz+NEW.summa_realiz
WHERE id=NEW.id_razdel2;

END */$$


DELIMITER ;

/* Trigger structure for table `i_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `material_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `material_update` BEFORE UPDATE ON `i_material` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price>0) then
SET NEW.subtotal = NEW.count_units*NEW.price;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `i_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `material_update_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `material_update_after` AFTER UPDATE ON `i_material` FOR EACH ROW BEGIN
UPDATE i_razdel2 
set summa_material=summa_material-OLD.subtotal+NEW.subtotal, 
summa_mat_realiz=summa_mat_realiz-OLD.summa_realiz+NEW.summa_realiz
WHERE id=OLD.id_razdel2;
END */$$


DELIMITER ;

/* Trigger structure for table `i_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `material_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `material_delete` BEFORE DELETE ON `i_material` FOR EACH ROW BEGIN

 
if (@from_R2<>1) THEN
    UPDATE i_razdel2 
    set 
    summa_material=summa_material-OLD.subtotal 
    WHERE 
    id=OLD.id_razdel2;

end if;
END */$$


DELIMITER ;

/* Trigger structure for table `i_object` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `object_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `object_delete` BEFORE DELETE ON `i_object` FOR EACH ROW BEGIN
SET @from_R0:=1;    
DELETE FROM i_razdel1 WHERE id_object=OLD.id;
SET @from_R0:=0;
END */$$


DELIMITER ;

/* Trigger structure for table `i_razdel1` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `razdel1_update_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `razdel1_update_after` AFTER UPDATE ON `i_razdel1` FOR EACH ROW BEGIN
        UPDATE i_object 
	SET 
	total_r0=total_r0-OLD.summa_r1+NEW.summa_r1, 
	total_m0=total_m0-OLD.summa_m1+NEW.summa_m1,
	total_r0_realiz=total_r0_realiz-OLD.summa_r1_realiz+NEW.summa_r1_realiz,
	total_m0_realiz=total_m0_realiz-OLD.summa_m1_realiz+NEW.summa_m1_realiz
	WHERE id=OLD.id_object;
END */$$


DELIMITER ;

/* Trigger structure for table `i_razdel1` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `razdel1_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `razdel1_delete` BEFORE DELETE ON `i_razdel1` FOR EACH ROW BEGIN
set @from_R1:=1;    
DELETE FROM i_razdel2 WHERE id_razdel1=OLD.id;
set @from_R1:=0;

IF (@from_R0<>1) THEN
        UPDATE i_object 
	SET 
	total_r0=total_r0-OLD.summa_r1, 
	total_m0=total_m0-OLD.summa_m1,
	total_r0_realiz=total_r0_realiz-OLD.summa_r1_realiz,
	total_m0_realiz=total_m0_realiz-OLD.summa_m1_realiz
	WHERE id=OLD.id_object;
END IF;

END */$$


DELIMITER ;

/* Trigger structure for table `i_razdel2` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `razdel2_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `razdel2_insert` BEFORE INSERT ON `i_razdel2` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price>0) then
SET NEW.subtotal = NEW.count_units*NEW.price;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `i_razdel2` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `razdel2_insert_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `razdel2_insert_after` AFTER INSERT ON `i_razdel2` FOR EACH ROW BEGIN
UPDATE i_razdel1 
SET 
summa_r1=summa_r1+NEW.subtotal, 
summa_m1=summa_m1+NEW.summa_material,
summa_r1_realiz=summa_r1_realiz+NEW.summa_r2_realiz,
summa_m1_realiz=summa_m1_realiz+NEW.summa_mat_realiz
WHERE id=NEW.id_razdel1;
END */$$


DELIMITER ;

/* Trigger structure for table `i_razdel2` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `razdel2_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `razdel2_update` BEFORE UPDATE ON `i_razdel2` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price>0) then
SET NEW.subtotal = NEW.count_units*NEW.price;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `i_razdel2` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `razdel2_update_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `razdel2_update_after` AFTER UPDATE ON `i_razdel2` FOR EACH ROW BEGIN
UPDATE i_razdel1 
set 
summa_r1=summa_r1+NEW.subtotal-OLD.subtotal, 
summa_m1=summa_m1+NEW.summa_material-OLD.summa_material,
summa_r1_realiz=summa_r1_realiz+NEW.summa_r2_realiz-OLD.summa_r2_realiz,
summa_m1_realiz=summa_m1_realiz+NEW.summa_mat_realiz-OLD.summa_mat_realiz
WHERE id=OLD.id_razdel1;
END */$$


DELIMITER ;

/* Trigger structure for table `i_razdel2` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `razdel2_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `razdel2_delete` BEFORE DELETE ON `i_razdel2` FOR EACH ROW BEGIN
set @from_R2:=1;     
DELETE FROM i_material WHERE id_razdel2=OLD.id;
set @from_R2:=0;
 
if (@from_R1<>1) THEN
        UPDATE i_razdel1 
	set 
	summa_r1=summa_r1-OLD.subtotal, 
	summa_m1=summa_m1-OLD.summa_material
	WHERE id=OLD.id_razdel1;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `n_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_material_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_material_insert` BEFORE INSERT ON `n_material` FOR EACH ROW BEGIN
IF (NEW.count_units>0 AND NEW.price>0) THEN
SET NEW.subtotal = NEW.count_units*NEW.price;
ELSE 
SET NEW.subtotal = 0;
END IF;
IF (NEW.price=NEW.price_material) then
SET NEW.status=0;
else
 IF (NEW.price<NEW.price_material) THEN
     SET NEW.status=1;
 ELSE
     SET NEW.status=-1;
 end IF;     
END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `n_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_material_insert_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_material_insert_after` AFTER INSERT ON `n_material` FOR EACH ROW 
BEGIN
UPDATE n_work SET summa_material=summa_material+NEW.subtotal WHERE id=NEW.id_nwork;

END */$$


DELIMITER ;

/* Trigger structure for table `n_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_material_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_material_update` BEFORE UPDATE ON `n_material` FOR EACH ROW BEGIN
IF (NEW.count_units>0 AND NEW.price>0) THEN
SET NEW.subtotal = NEW.count_units*NEW.price;
ELSE 
SET NEW.subtotal = 0;
END IF;

IF (NEW.price=NEW.price_material) then
SET NEW.status=0;
else
 IF (NEW.price<NEW.price_material) THEN
     SET NEW.status=1;
 ELSE
     SET NEW.status=-1;
 end IF;     
END IF;

END */$$


DELIMITER ;

/* Trigger structure for table `n_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_material_update_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_material_update_after` AFTER UPDATE ON `n_material` FOR EACH ROW BEGIN
UPDATE n_work SET summa_material=summa_material-OLD.subtotal+NEW.subtotal WHERE id=OLD.id_nwork;
if (OLD.memorandum is null) then
  set @mem0='';
  else SET @mem0=OLD.memorandum;
end if;
IF (NEW.memorandum IS NULL) THEN
  SET @mem1='';
  ELSE SET @mem1=NEW.memorandum;
END IF;
insert n_log SET id_user=@id_user, name_table='n_material', id_table=NEW.id,
text_update=CONCAT(format(OLD.count_units,2), ';' ,format(OLD.price,2) , ';' ,@mem0),
text_new=CONCAT(format(NEW.count_units,2), ';' , format(NEW.price,2) , ';' , @mem1);

END */$$


DELIMITER ;

/* Trigger structure for table `n_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_material_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_material_delete` BEFORE DELETE ON `n_material` FOR EACH ROW BEGIN

 
IF (@from_work<>1) THEN
    UPDATE n_work 
    SET 
    summa_material=summa_material-OLD.subtotal 
    WHERE 
    id=OLD.id_nwork;

END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `n_nariad` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_nariad_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_nariad_delete` BEFORE DELETE ON `n_nariad` FOR EACH ROW BEGIN
SET @from_nariad:=1;    
DELETE FROM n_work WHERE id_nariad=OLD.id;
SET @from_nariad:=0;


END */$$


DELIMITER ;

/* Trigger structure for table `n_work` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_work_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_work_insert` BEFORE INSERT ON `n_work` FOR EACH ROW BEGIN
IF (NEW.count_units>0 AND NEW.price>0) THEN
SET NEW.subtotal = NEW.count_units*NEW.price;
ELSE 
SET NEW.subtotal = 0;
END IF;
IF (NEW.price=NEW.price_razdel2) then
SET NEW.status=0;
else
 IF (NEW.price<NEW.price_razdel2) THEN
     SET NEW.status=1;
 ELSE
     SET NEW.status=-1;
 end IF;     
END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `n_work` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_work_insert_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_work_insert_after` AFTER INSERT ON `n_work` FOR EACH ROW BEGIN
UPDATE n_nariad 
SET 
summa_work=summa_work+NEW.subtotal, 
summa_material=summa_material+NEW.summa_material
WHERE id=NEW.id_nariad;
END */$$


DELIMITER ;

/* Trigger structure for table `n_work` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_work_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_work_update` BEFORE UPDATE ON `n_work` FOR EACH ROW BEGIN
IF (NEW.count_units>0 AND NEW.price>0) THEN
SET NEW.subtotal = NEW.count_units*NEW.price;
ELSE 
SET NEW.subtotal = 0;
END IF;
IF (NEW.price=NEW.price_razdel2) THEN
SET NEW.status=0;
ELSE
 IF (NEW.price<NEW.price_razdel2) THEN
     SET NEW.status=1;
 ELSE
     SET NEW.status=-1;
 END IF;     
END IF;
END */$$


DELIMITER ;

/* Trigger structure for table `n_work` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_work_update_after` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_work_update_after` AFTER UPDATE ON `n_work` FOR EACH ROW BEGIN
UPDATE n_nariad 
SET 
summa_work=summa_work+NEW.subtotal-OLD.subtotal, 
summa_material=summa_material+NEW.summa_material-OLD.summa_material
WHERE id=OLD.id_nariad;

IF (OLD.memorandum IS NULL) THEN
  SET @mem0='';
  ELSE SET @mem0=OLD.memorandum;
END IF;
IF (NEW.memorandum IS NULL) THEN
  SET @mem1='';
  ELSE SET @mem1=NEW.memorandum;
END IF;
INSERT n_log SET id_user=@id_user, name_table='n_work', id_table=NEW.id,
text_update=CONCAT(format(OLD.count_units,2), ';' ,format(OLD.price,2) , ';' ,@mem0),
text_new=CONCAT(format(NEW.count_units,2), ';' , format(NEW.price,2) , ';' , @mem1);

END */$$


DELIMITER ;

/* Trigger structure for table `n_work` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `n_work_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `n_work_delete` BEFORE DELETE ON `n_work` FOR EACH ROW BEGIN
set @from_work:=1;     
DELETE FROM n_material WHERE id_nwork=OLD.id;
set @from_work:=0;
 
if (@from_nariad<>1) THEN
        UPDATE n_nariad 
	set 
	summa_work=summa_work-OLD.subtotal, 
	summa_material=summa_material-OLD.summa_material
	WHERE id=OLD.id_nariad;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `z_act` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `z_act_delete` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `z_act_delete` BEFORE DELETE ON `z_act` FOR EACH ROW BEGIN
       delete from z_act_material where id_act=OLD.id; 
    END */$$


DELIMITER ;

/* Trigger structure for table `z_act_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `z_act_material_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `z_act_material_insert` BEFORE INSERT ON `z_act_material` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price_nds>0) then
SET NEW.subtotal = NEW.count_units*NEW.price_nds;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `z_act_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `z_act_material_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `z_act_material_update` BEFORE UPDATE ON `z_act_material` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price_nds>0) then
SET NEW.subtotal = NEW.count_units*NEW.price_nds;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `z_stock_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `stock_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `stock_insert` BEFORE INSERT ON `z_stock_material` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price>0) then
SET NEW.subtotal = NEW.count_units*NEW.price;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Trigger structure for table `z_stock_material` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `stock_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `stock_update` BEFORE UPDATE ON `z_stock_material` FOR EACH ROW BEGIN
if (NEW.count_units>0 and NEW.price>0) then
SET NEW.subtotal = NEW.count_units*NEW.price;
else 
SET NEW.subtotal = 0;
end if;
END */$$


DELIMITER ;

/* Procedure structure for procedure `get_numer_doc` */

/*!50003 DROP PROCEDURE IF EXISTS  `get_numer_doc` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `get_numer_doc`(IN vol_data DATE, IN vol_type INT, OUT vol_numer INT)
BEGIN
    	
    	/*DECLARE num INT DEFAULT 1;*/ 
        select numer_doc INTO vol_numer from n_numer where date_doc=vol_data and type_doc=vol_type;
        #001    
        if vol_numer is null then
           #002
           SET vol_numer=1;
           INsert into n_numer value (vol_data,vol_type,vol_numer);
        else
           #003
           SET vol_numer=vol_numer+1;
           update n_numer set numer_doc=vol_numer where date_doc=vol_data and type_doc=vol_type;  
        end IF;
        #004  
	END */$$
DELIMITER ;

/* Procedure structure for procedure `set_user` */

/*!50003 DROP PROCEDURE IF EXISTS  `set_user` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `set_user`(IN id_user INT)
    DETERMINISTIC
BEGIN
          SET @id_user=id_user;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
