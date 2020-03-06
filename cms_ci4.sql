-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for cms_ci4
DROP DATABASE IF EXISTS `cms_ci4`;
CREATE DATABASE IF NOT EXISTS `cms_ci4` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cms_ci4`;

-- Dumping structure for procedure cms_ci4.getmoduleIdPath
DROP PROCEDURE IF EXISTS `getmoduleIdPath`;
DELIMITER //
CREATE PROCEDURE `getmoduleIdPath`(
	IN `module_id` BIGINT,
	OUT `path` TEXT,
	IN `separator_path` VARCHAR(50)
)
BEGIN


DECLARE modId BIGINT;
DECLARE tempPath TEXT;
DECLARE tempParent BIGINT;

SET max_sp_recursion_depth=258;
SELECT id, parent_module_id FROM tbl_modules WHERE id=module_id INTO modId, tempParent;

if tempParent IS NULL
then
	SET path=modId;
ELSE
	CALL getModuleIdPath(tempParent, tempPath, separator_path);
	SET path = CONCAT(tempPath,separator_path,modId);	
END if;

END//
DELIMITER ;

-- Dumping structure for function cms_ci4.getModuleIdPath
DROP FUNCTION IF EXISTS `getModuleIdPath`;
DELIMITER //
CREATE FUNCTION `getModuleIdPath`(
	`module_id` BIGINT,
	`separator_path` VARCHAR(50)
) RETURNS text CHARSET latin1
    DETERMINISTIC
BEGIN

SET @res='';
CALL getmoduleIdPath(module_id, @res, separator_path);
RETURN @res;

END//
DELIMITER ;

-- Dumping structure for procedure cms_ci4.getmoduleName
DROP PROCEDURE IF EXISTS `getmoduleName`;
DELIMITER //
CREATE PROCEDURE `getmoduleName`(
	IN `module_id` INT,
	OUT `path` TEXT,
	IN `separator_path` TEXT
)
BEGIN


DECLARE modName TEXT;
DECLARE tempPath TEXT;
DECLARE tempParent BIGINT;

SET max_sp_recursion_depth=258;
SELECT module_name, parent_module_id FROM tbl_modules WHERE id=module_id INTO modName, tempParent;

if tempParent IS NULL
then
	SET path=modName;
ELSE
	CALL getModuleName(tempParent, tempPath, separator_path);
	SET path = CONCAT(tempPath,separator_path,modName);	
END if;

END//
DELIMITER ;

-- Dumping structure for function cms_ci4.getModuleName
DROP FUNCTION IF EXISTS `getModuleName`;
DELIMITER //
CREATE FUNCTION `getModuleName`(
	`module_id` INT,
	`separator_path` VARCHAR(50)
) RETURNS text CHARSET latin1
BEGIN

SET @res='';
CALL getmoduleName(module_id, @res, separator_path);
RETURN @res;

END//
DELIMITER ;

-- Dumping structure for table cms_ci4.tbl_modules
DROP TABLE IF EXISTS `tbl_modules`;
CREATE TABLE IF NOT EXISTS `tbl_modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  `module_description` varchar(255) DEFAULT NULL,
  `module_url` varchar(255) DEFAULT NULL,
  `module_type` tinyint(4) DEFAULT '1' COMMENT '1 untuk module admin',
  `parent_module_id` bigint(20) DEFAULT NULL,
  `module_order` tinyint(4) DEFAULT NULL,
  `module_icon` varchar(200) DEFAULT 'far fa-circle',
  `need_privilege` tinyint(4) DEFAULT '1',
  `super_admin` tinyint(4) NOT NULL DEFAULT '1',
  `is_active` tinyint(4) DEFAULT '1',
  `show_on_privilege` tinyint(4) DEFAULT '1',
  `need_view` tinyint(4) DEFAULT '1',
  `need_add` tinyint(4) DEFAULT '1',
  `need_delete` tinyint(4) DEFAULT '1',
  `need_edit` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cms_ci4.tbl_modules: ~22 rows (approximately)
DELETE FROM `tbl_modules`;
/*!40000 ALTER TABLE `tbl_modules` DISABLE KEYS */;
INSERT INTO `tbl_modules` (`id`, `module_name`, `module_description`, `module_url`, `module_type`, `parent_module_id`, `module_order`, `module_icon`, `need_privilege`, `super_admin`, `is_active`, `show_on_privilege`, `need_view`, `need_add`, `need_delete`, `need_edit`) VALUES
	(1, 'Pengguna', 'Halaman Pengguna', '#', 1, NULL, 6, 'fa fa-users-cog', 1, 1, 1, 0, 0, 0, 0, 0),
	(2, 'Administrator', 'Halmaan Administrator', 'admin/user/user', 1, 1, 1, 'fa fa-sign-out-alt', 1, 1, 1, 1, 1, 1, 1, 1),
	(3, 'Grup Pengguna', 'Halaman Grup Pengguna', 'admin/user/usergroup', 1, 1, 2, 'fa fa-sign-out-alt', 1, 1, 1, 1, 1, 1, 1, 1),
	(4, 'Dashboard', 'Halaman Dashboard', 'admin/dashboard', 1, NULL, 1, 'fas fa-tachometer-alt', 0, 1, 0, 1, 0, 0, 0, 0),
	(5, 'Profil', 'Halaman Profil Pengguna', 'admin/user/profile', 1, 1, 3, 'fa fa-sign-out-alt', 1, 0, 1, 1, 1, 1, 1, 1),
	(6, 'Blogs', 'Blogs', '#', 1, NULL, 2, 'fa fa-edit', 1, 1, 0, 1, 1, 1, 1, 1),
	(7, 'Produk', 'Produk', '#', 1, NULL, 3, 'fa fa-cart-plus', 1, 1, 0, 1, 1, 1, 1, 1),
	(8, 'Media', 'Media', '#', 1, NULL, 4, 'fa fa-upload', 1, 1, 0, 1, 1, 1, 1, 1),
	(9, 'Tampilan', 'Tampilan', '#', 1, NULL, 5, 'fa fa-paint-brush', 1, 1, 0, 1, 1, 1, 1, 1),
	(10, 'Semua', 'Semua', 'admin/blog/post', 1, 6, 1, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(11, 'Kategori', 'Kategori', 'admin/blog/category', 1, 6, 2, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(12, 'Tags', 'Tags', 'admin/blog/tag', 1, 6, 3, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(13, 'Halaman', 'Halaman', 'admin/blog/page', 1, 6, 4, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(14, 'Komentar', 'Komentar', 'admin/blog/comment', 1, 6, 5, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(16, 'Semua', 'Semua', 'admin/product', 1, 7, 1, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(17, 'Kategori', 'Kategori', 'admin/product/category', 1, 7, 2, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(18, 'Merek', 'Merek', 'admin/product/merk', 1, 7, 3, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(19, 'Menu', 'Menu', 'admin/tampilan/menu', 1, 9, 1, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(20, 'File', 'File', 'admin/media/file', 1, 8, 1, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(21, 'Kategori File', 'Kategori File', 'admin/media/filecategory', 1, 8, 2, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(22, 'Album Photo', 'Album Photo', 'admin/media/photoalbum', 1, 8, 3, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1),
	(23, 'Video', 'Video', 'admin/media/video', 1, 8, 4, 'fa fa-sign-out-alt', 1, 1, 0, 1, 1, 1, 1, 1);
/*!40000 ALTER TABLE `tbl_modules` ENABLE KEYS */;

-- Dumping structure for table cms_ci4.tbl_users
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` text NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `user_group_id` bigint(20) DEFAULT '1',
  `type` tinyint(4) DEFAULT '1' COMMENT '-1 (super), 1 (admin)',
  `biography` text,
  `forgot_password_key` varchar(100) DEFAULT NULL,
  `forgot_password_request_date` timestamp NULL DEFAULT NULL,
  `last_logged_in` timestamp NULL DEFAULT NULL,
  `last_logged_out` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `home_module_id` bigint(20) unsigned DEFAULT '4',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `restored_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) DEFAULT '1',
  `updated_by` bigint(20) DEFAULT '0',
  `deleted_by` bigint(20) DEFAULT '0',
  `restored_by` bigint(20) DEFAULT '0',
  `is_deleted` tinyint(4) DEFAULT '0',
  `is_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `users_user_group_id__idx` (`user_group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cms_ci4.tbl_users: ~3 rows (approximately)
DELETE FROM `tbl_users`;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` (`id`, `username`, `password`, `fullname`, `email`, `url`, `user_group_id`, `type`, `biography`, `forgot_password_key`, `forgot_password_request_date`, `last_logged_in`, `last_logged_out`, `ip_address`, `home_module_id`, `created_at`, `updated_at`, `deleted_at`, `restored_at`, `created_by`, `updated_by`, `deleted_by`, `restored_by`, `is_deleted`, `is_active`) VALUES
	(1, 'root', 'JpbIwzCddCxTGUgvacTo2cxCA/EjteOnUS8g5Px+cJ2gVPXyL0Mx1cOT3NKuylmLgc3xZ4jRCLWysX+U7PpbQwWfquXEmmnnJOn2URFAAvOJDN7B', 'Super Admin', 'admin@gmail.com', NULL, -1, -1, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2020-01-29 23:46:58', '2020-03-06 23:04:29', NULL, NULL, 0, 0, 0, 0, 0, 1),
	(2, 'zahid', '3vnp2+QPXmYOKrfjOTwX0CZzvoQVYlyn7+bhBn+aRrKTCZnGUSQfAvB+agugDi3P/VIxsiBCgUjt4Q6PNo1mVFXLQSTSQdtvl0LAqd/9xvExqcsOFA==', 'Zahid Al Haris', 'zahid@gmail.com', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2020-01-29 23:51:08', '2020-03-06 23:04:58', NULL, NULL, 0, 1, 1, 0, 0, 1),
	(3, 'rika', 'AnCEY7xjUyP10zpj0J6b/h0qYbhRFk2pjKIMzzUnVNWrCZwrhaX8vh67j8jAKsEYFqAq1yosEdA3N0SXF8H/yxXUoXOs4Up/gvlDCUbSM9HtPPPM', 'Rika', 'rika@gmail.com', NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, 5, '2020-02-05 01:41:08', '2020-03-06 23:04:50', NULL, NULL, 0, 1, 1, 0, 0, 1);
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;

-- Dumping structure for table cms_ci4.tbl_user_groups
DROP TABLE IF EXISTS `tbl_user_groups`;
CREATE TABLE IF NOT EXISTS `tbl_user_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `restored_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT '1',
  `updated_by` bigint(20) unsigned DEFAULT '1',
  `deleted_by` bigint(20) unsigned DEFAULT '1',
  `restored_by` bigint(20) unsigned DEFAULT '1',
  `is_deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_group` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cms_ci4.tbl_user_groups: ~2 rows (approximately)
DELETE FROM `tbl_user_groups`;
/*!40000 ALTER TABLE `tbl_user_groups` DISABLE KEYS */;
INSERT INTO `tbl_user_groups` (`id`, `group_name`, `created_at`, `updated_at`, `deleted_at`, `restored_at`, `created_by`, `updated_by`, `deleted_by`, `restored_by`, `is_deleted`) VALUES
	(1, 'Administrator', '2020-02-13 08:32:29', '2020-02-20 00:58:20', NULL, NULL, 0, 0, 1, 0, 0),
	(2, 'Operator', '2020-02-05 01:30:53', '2020-03-04 11:42:44', NULL, NULL, 0, 0, 4, 0, 0);
/*!40000 ALTER TABLE `tbl_user_groups` ENABLE KEYS */;

-- Dumping structure for table cms_ci4.tbl_user_privileges
DROP TABLE IF EXISTS `tbl_user_privileges`;
CREATE TABLE IF NOT EXISTS `tbl_user_privileges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_group_id` bigint(20) DEFAULT '1',
  `module_id` bigint(20) DEFAULT '4',
  `can_add` tinyint(4) DEFAULT '1',
  `can_edit` tinyint(4) DEFAULT '1',
  `can_delete` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `restored_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT '0',
  `updated_by` bigint(20) unsigned DEFAULT '0',
  `deleted_by` bigint(20) unsigned DEFAULT '0',
  `restored_by` bigint(20) unsigned DEFAULT '0',
  `is_deleted` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_field` (`user_group_id`,`module_id`),
  KEY `user_privileges_user_group_id__idx` (`user_group_id`) USING BTREE,
  KEY `user_privileges_module_id__idx` (`module_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cms_ci4.tbl_user_privileges: ~5 rows (approximately)
DELETE FROM `tbl_user_privileges`;
/*!40000 ALTER TABLE `tbl_user_privileges` DISABLE KEYS */;
INSERT INTO `tbl_user_privileges` (`id`, `user_group_id`, `module_id`, `can_add`, `can_edit`, `can_delete`, `created_at`, `updated_at`, `deleted_at`, `restored_at`, `created_by`, `updated_by`, `deleted_by`, `restored_by`, `is_deleted`) VALUES
	(1, 2, 2, 0, 0, 0, '2020-03-04 11:42:56', '2020-03-04 11:42:56', NULL, NULL, 0, 0, 0, 0, NULL),
	(2, 2, 3, 0, 0, 0, '2020-03-04 11:42:56', '2020-03-04 11:42:56', NULL, NULL, 0, 0, 0, 0, NULL),
	(3, 2, 5, 0, 0, 0, '2020-03-04 11:42:56', '2020-03-04 11:42:56', NULL, NULL, 0, 0, 0, 0, NULL),
	(4, 1, 2, 0, 0, 0, '2020-03-04 11:43:40', '2020-03-04 11:43:40', NULL, NULL, 0, 0, 0, 0, NULL),
	(5, 1, 3, 0, 0, 0, '2020-03-04 11:43:40', '2020-03-04 11:43:40', NULL, NULL, 0, 0, 0, 0, NULL),
	(6, 1, 5, 0, 0, 0, '2020-03-04 11:43:40', '2020-03-04 11:43:40', NULL, NULL, 0, 0, 0, 0, NULL);
/*!40000 ALTER TABLE `tbl_user_privileges` ENABLE KEYS */;

-- Dumping structure for view cms_ci4.v_administrators
DROP VIEW IF EXISTS `v_administrators`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_administrators` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`username` VARCHAR(60) NOT NULL COLLATE 'utf8_general_ci',
	`password` TEXT NOT NULL COLLATE 'utf8_general_ci',
	`fullname` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`email` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`url` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`user_group_id` BIGINT(20) NULL,
	`type` TINYINT(4) NULL COMMENT '-1 (super), 1 (admin)',
	`biography` TEXT NULL COLLATE 'utf8_general_ci',
	`forgot_password_key` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`forgot_password_request_date` TIMESTAMP NULL,
	`last_logged_in` TIMESTAMP NULL,
	`last_logged_out` TIMESTAMP NULL,
	`ip_address` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`home_module_id` BIGINT(20) UNSIGNED NULL,
	`created_at` TIMESTAMP NULL,
	`updated_at` TIMESTAMP NULL,
	`deleted_at` TIMESTAMP NULL,
	`restored_at` TIMESTAMP NULL,
	`created_by` BIGINT(20) NULL,
	`updated_by` BIGINT(20) NULL,
	`deleted_by` BIGINT(20) NULL,
	`restored_by` BIGINT(20) NULL,
	`is_deleted` TINYINT(4) NULL,
	`is_active` TINYINT(4) NULL
) ENGINE=MyISAM;

-- Dumping structure for view cms_ci4.v_modules
DROP VIEW IF EXISTS `v_modules`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_modules` (
	`module_id_path` TEXT NULL COLLATE 'latin1_swedish_ci',
	`module_name_path` TEXT NULL COLLATE 'latin1_swedish_ci',
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`module_name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`module_description` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`module_url` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`module_type` TINYINT(4) NULL COMMENT '1 untuk module admin',
	`parent_module_id` BIGINT(20) NULL,
	`module_order` TINYINT(4) NULL,
	`module_icon` VARCHAR(200) NULL COLLATE 'utf8_general_ci',
	`need_privilege` TINYINT(4) NULL,
	`super_admin` TINYINT(4) NOT NULL,
	`is_active` TINYINT(4) NULL,
	`show_on_privilege` TINYINT(4) NULL,
	`need_view` TINYINT(4) NULL,
	`need_add` TINYINT(4) NULL,
	`need_delete` TINYINT(4) NULL,
	`need_edit` TINYINT(4) NULL
) ENGINE=MyISAM;

-- Dumping structure for view cms_ci4.v_users
DROP VIEW IF EXISTS `v_users`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_users` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`username` VARCHAR(60) NOT NULL COLLATE 'utf8_general_ci',
	`password` MEDIUMTEXT NOT NULL COLLATE 'utf8_general_ci',
	`fullname` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`email` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`url` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`user_group_id` BIGINT(20) NULL,
	`type` TINYINT(4) NULL,
	`biography` MEDIUMTEXT NULL COLLATE 'utf8_general_ci',
	`forgot_password_key` VARCHAR(100) NULL COLLATE 'utf8_general_ci',
	`forgot_password_request_date` TIMESTAMP NULL,
	`last_logged_in` TIMESTAMP NULL,
	`last_logged_out` TIMESTAMP NULL,
	`ip_address` VARCHAR(45) NULL COLLATE 'utf8_general_ci',
	`home_module_id` BIGINT(20) UNSIGNED NULL,
	`created_at` TIMESTAMP NULL,
	`updated_at` TIMESTAMP NULL,
	`deleted_at` TIMESTAMP NULL,
	`restored_at` TIMESTAMP NULL,
	`created_by` BIGINT(20) NULL,
	`updated_by` BIGINT(20) NULL,
	`deleted_by` BIGINT(20) NULL,
	`restored_by` BIGINT(20) NULL,
	`is_deleted` TINYINT(4) NULL,
	`is_active` TINYINT(4) NULL,
	`home_module_url` VARCHAR(255) NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view cms_ci4.v_user_groups
DROP VIEW IF EXISTS `v_user_groups`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_user_groups` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`group_name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`created_at` TIMESTAMP NULL,
	`updated_at` TIMESTAMP NULL,
	`deleted_at` TIMESTAMP NULL,
	`restored_at` TIMESTAMP NULL,
	`created_by` BIGINT(20) UNSIGNED NULL,
	`updated_by` BIGINT(20) UNSIGNED NULL,
	`deleted_by` BIGINT(20) UNSIGNED NULL,
	`restored_by` BIGINT(20) UNSIGNED NULL,
	`is_deleted` TINYINT(4) NULL
) ENGINE=MyISAM;

-- Dumping structure for view cms_ci4.v_user_privileges
DROP VIEW IF EXISTS `v_user_privileges`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_user_privileges` (
	`module_id_path` TEXT NULL COLLATE 'latin1_swedish_ci',
	`module_name` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`module_url` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`user_group_id` BIGINT(20) NULL,
	`module_id` BIGINT(20) NULL,
	`can_add` TINYINT(4) NULL,
	`can_edit` TINYINT(4) NULL,
	`can_delete` TINYINT(4) NULL,
	`created_at` TIMESTAMP NULL,
	`updated_at` TIMESTAMP NULL,
	`deleted_at` TIMESTAMP NULL,
	`restored_at` TIMESTAMP NULL,
	`created_by` BIGINT(20) UNSIGNED NULL,
	`updated_by` BIGINT(20) UNSIGNED NULL,
	`deleted_by` BIGINT(20) UNSIGNED NULL,
	`restored_by` BIGINT(20) UNSIGNED NULL,
	`is_deleted` TINYINT(4) NULL
) ENGINE=MyISAM;

-- Dumping structure for table cms_ci4._sessions
DROP TABLE IF EXISTS `_sessions`;
CREATE TABLE IF NOT EXISTS `_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table cms_ci4._sessions: ~2 rows (approximately)
DELETE FROM `_sessions`;
/*!40000 ALTER TABLE `_sessions` DISABLE KEYS */;
INSERT INTO `_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('53fqkrj0d2mndgd19d2c22ejodo7ffka', '127.0.0.1', 1583510777, _binary 0x5F63695F70726576696F75735F75726C7C733A33303A22687474703A2F2F636F646569676E69746572342E746573742F6C6F67696E223B7374617475737C733A393A22227375636365737322223B5F5F63695F766172737C613A323A7B733A363A22737461747573223B733A333A226F6C64223B733A373A226D657373616765223B733A333A226F6C64223B7D6D6573736167657C733A31393A22224C6F676F757420626572686173696C202122223B),
	('k7qaku80g2t93skc1o3av2lal8re0art', '127.0.0.1', 1583308291, _binary 0x5F63695F70726576696F75735F75726C7C733A34353A22687474703A2F2F636F646569676E69746572342E746573742F61646D696E2F757365722F7573657267726F7570223B61646D696E7C613A343A7B733A383A226861734C6F67696E223B623A313B733A343A2275736572223B613A373A7B733A323A226964223B733A313A2231223B733A383A22757365726E616D65223B733A343A22726F6F74223B733A383A2266756C6C6E616D65223B733A31313A2253757065722041646D696E223B733A353A22656D61696C223B733A31353A2261646D696E40676D61696C2E636F6D223B733A31333A22757365725F67726F75705F6964223B733A323A222D31223B733A31353A22686F6D655F6D6F64756C655F75726C223B733A32303A2261646D696E2F757365722F7573657267726F7570223B733A343A2274797065223B733A323A222D31223B7D733A31303A2270726976696C65676573223B613A343A7B693A343B613A373A7B733A393A226D6F64756C655F6964223B733A313A2234223B733A31313A226D6F64756C655F6E616D65223B733A393A2244617368626F617264223B733A31343A226D6F64756C655F69645F70617468223B733A313A2234223B733A31303A226D6F64756C655F75726C223B733A31353A2261646D696E2F64617368626F617264223B733A373A2263616E5F616464223B733A313A2231223B733A31303A2263616E5F64656C657465223B733A313A2231223B733A383A2263616E5F65646974223B733A313A2231223B7D693A313B613A373A7B733A393A226D6F64756C655F6964223B733A313A2231223B733A31313A226D6F64756C655F6E616D65223B733A383A2250656E6767756E61223B733A31343A226D6F64756C655F69645F70617468223B733A313A2231223B733A31303A226D6F64756C655F75726C223B733A313A2223223B733A373A2263616E5F616464223B733A313A2231223B733A31303A2263616E5F64656C657465223B733A313A2231223B733A383A2263616E5F65646974223B733A313A2231223B7D693A323B613A373A7B733A393A226D6F64756C655F6964223B733A313A2232223B733A31313A226D6F64756C655F6E616D65223B733A31333A2241646D696E6973747261746F72223B733A31343A226D6F64756C655F69645F70617468223B733A333A22312C32223B733A31303A226D6F64756C655F75726C223B733A31353A2261646D696E2F757365722F75736572223B733A373A2263616E5F616464223B733A313A2231223B733A31303A2263616E5F64656C657465223B733A313A2231223B733A383A2263616E5F65646974223B733A313A2231223B7D693A333B613A373A7B733A393A226D6F64756C655F6964223B733A313A2233223B733A31313A226D6F64756C655F6E616D65223B733A31333A22477275702050656E6767756E61223B733A31343A226D6F64756C655F69645F70617468223B733A333A22312C33223B733A31303A226D6F64756C655F75726C223B733A32303A2261646D696E2F757365722F7573657267726F7570223B733A373A2263616E5F616464223B733A313A2231223B733A31303A2263616E5F64656C657465223B733A313A2231223B733A383A2263616E5F65646974223B733A313A2231223B7D7D733A373A226D6F64756C6573223B613A323A7B693A303B613A323A7B733A343A226974656D223B613A31383A7B733A31343A226D6F64756C655F69645F70617468223B733A313A2234223B733A31363A226D6F64756C655F6E616D655F70617468223B733A393A2244617368626F617264223B733A323A226964223B733A313A2234223B733A31313A226D6F64756C655F6E616D65223B733A393A2244617368626F617264223B733A31383A226D6F64756C655F6465736372697074696F6E223B733A31373A2248616C616D616E2044617368626F617264223B733A31303A226D6F64756C655F75726C223B733A31353A2261646D696E2F64617368626F617264223B733A31313A226D6F64756C655F74797065223B733A313A2231223B733A31363A22706172656E745F6D6F64756C655F6964223B4E3B733A31323A226D6F64756C655F6F72646572223B733A313A2231223B733A31313A226D6F64756C655F69636F6E223B733A32313A226661732066612D746163686F6D657465722D616C74223B733A31343A226E6565645F70726976696C656765223B733A313A2230223B733A31313A2273757065725F61646D696E223B733A313A2231223B733A393A2269735F616374697665223B733A313A2230223B733A31373A2273686F775F6F6E5F70726976696C656765223B733A313A2231223B733A393A226E6565645F76696577223B733A313A2230223B733A383A226E6565645F616464223B733A313A2230223B733A31313A226E6565645F64656C657465223B733A313A2230223B733A393A226E6565645F65646974223B733A313A2230223B7D733A383A226368696C6472656E223B613A303A7B7D7D693A313B613A323A7B733A343A226974656D223B613A31383A7B733A31343A226D6F64756C655F69645F70617468223B733A313A2231223B733A31363A226D6F64756C655F6E616D655F70617468223B733A383A2250656E6767756E61223B733A323A226964223B733A313A2231223B733A31313A226D6F64756C655F6E616D65223B733A383A2250656E6767756E61223B733A31383A226D6F64756C655F6465736372697074696F6E223B733A31363A2248616C616D616E2050656E6767756E61223B733A31303A226D6F64756C655F75726C223B733A313A2223223B733A31313A226D6F64756C655F74797065223B733A313A2231223B733A31363A22706172656E745F6D6F64756C655F6964223B4E3B733A31323A226D6F64756C655F6F72646572223B733A313A2236223B733A31313A226D6F64756C655F69636F6E223B733A31353A2266612066612D75736572732D636F67223B733A31343A226E6565645F70726976696C656765223B733A313A2231223B733A31313A2273757065725F61646D696E223B733A313A2231223B733A393A2269735F616374697665223B733A313A2231223B733A31373A2273686F775F6F6E5F70726976696C656765223B733A313A2230223B733A393A226E6565645F76696577223B733A313A2230223B733A383A226E6565645F616464223B733A313A2230223B733A31313A226E6565645F64656C657465223B733A313A2230223B733A393A226E6565645F65646974223B733A313A2230223B7D733A383A226368696C6472656E223B613A323A7B693A303B613A323A7B733A343A226974656D223B613A31383A7B733A31343A226D6F64756C655F69645F70617468223B733A333A22312C32223B733A31363A226D6F64756C655F6E616D655F70617468223B733A32343A2250656E6767756E61203E2041646D696E6973747261746F72223B733A323A226964223B733A313A2232223B733A31313A226D6F64756C655F6E616D65223B733A31333A2241646D696E6973747261746F72223B733A31383A226D6F64756C655F6465736372697074696F6E223B733A32313A2248616C6D61616E2041646D696E6973747261746F72223B733A31303A226D6F64756C655F75726C223B733A31353A2261646D696E2F757365722F75736572223B733A31313A226D6F64756C655F74797065223B733A313A2231223B733A31363A22706172656E745F6D6F64756C655F6964223B733A313A2231223B733A31323A226D6F64756C655F6F72646572223B733A313A2231223B733A31313A226D6F64756C655F69636F6E223B733A31383A2266612066612D7369676E2D6F75742D616C74223B733A31343A226E6565645F70726976696C656765223B733A313A2231223B733A31313A2273757065725F61646D696E223B733A313A2231223B733A393A2269735F616374697665223B733A313A2231223B733A31373A2273686F775F6F6E5F70726976696C656765223B733A313A2231223B733A393A226E6565645F76696577223B733A313A2231223B733A383A226E6565645F616464223B733A313A2231223B733A31313A226E6565645F64656C657465223B733A313A2231223B733A393A226E6565645F65646974223B733A313A2231223B7D733A383A226368696C6472656E223B613A303A7B7D7D693A313B613A323A7B733A343A226974656D223B613A31383A7B733A31343A226D6F64756C655F69645F70617468223B733A333A22312C33223B733A31363A226D6F64756C655F6E616D655F70617468223B733A32343A2250656E6767756E61203E20477275702050656E6767756E61223B733A323A226964223B733A313A2233223B733A31313A226D6F64756C655F6E616D65223B733A31333A22477275702050656E6767756E61223B733A31383A226D6F64756C655F6465736372697074696F6E223B733A32313A2248616C616D616E20477275702050656E6767756E61223B733A31303A226D6F64756C655F75726C223B733A32303A2261646D696E2F757365722F7573657267726F7570223B733A31313A226D6F64756C655F74797065223B733A313A2231223B733A31363A22706172656E745F6D6F64756C655F6964223B733A313A2231223B733A31323A226D6F64756C655F6F72646572223B733A313A2232223B733A31313A226D6F64756C655F69636F6E223B733A31383A2266612066612D7369676E2D6F75742D616C74223B733A31343A226E6565645F70726976696C656765223B733A313A2231223B733A31313A2273757065725F61646D696E223B733A313A2231223B733A393A2269735F616374697665223B733A313A2231223B733A31373A2273686F775F6F6E5F70726976696C656765223B733A313A2231223B733A393A226E6565645F76696577223B733A313A2231223B733A383A226E6565645F616464223B733A313A2231223B733A31313A226E6565645F64656C657465223B733A313A2231223B733A393A226E6565645F65646974223B733A313A2231223B7D733A383A226368696C6472656E223B613A303A7B7D7D7D7D7D7D);
/*!40000 ALTER TABLE `_sessions` ENABLE KEYS */;

-- Dumping structure for view cms_ci4.v_administrators
DROP VIEW IF EXISTS `v_administrators`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_administrators`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_administrators` AS SELECT 
	users.*
FROM 
	tbl_users users
WHERE 
	users.type=1
	AND users.is_active=1
	AND users.is_deleted=0 ;

-- Dumping structure for view cms_ci4.v_modules
DROP VIEW IF EXISTS `v_modules`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_modules`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_modules` AS SELECT 
	getModuleIdPath(modules.id, ',') AS module_id_path,
	getModuleName(modules.id, ' > ') AS module_name_path,
	modules.*	
FROM 
	tbl_modules modules
WHERE 
	modules.is_active=1
	OR modules.need_privilege=0
ORDER BY 
	modules.parent_module_id, 
	modules.module_order ;

-- Dumping structure for view cms_ci4.v_users
DROP VIEW IF EXISTS `v_users`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_users`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_users` AS SELECT 
	users.*, 
	modules.module_url AS home_module_url
FROM 
	tbl_users users 
LEFT JOIN 
	tbl_modules modules
ON 
	users.home_module_id=modules.id
WHERE TYPE=-1
UNION
SELECT 
	users.*, 
	modules.module_url AS home_module_url 
FROM 
	tbl_users users 
LEFT JOIN 
	tbl_modules modules
ON 
	users.home_module_id=modules.id
WHERE 
	users.is_deleted=0 
	AND users.is_active=1 ;

-- Dumping structure for view cms_ci4.v_user_groups
DROP VIEW IF EXISTS `v_user_groups`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_user_groups`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_user_groups` AS SELECT 
	* 
FROM 
	tbl_user_groups 
WHERE 
	is_deleted=0 ;

-- Dumping structure for view cms_ci4.v_user_privileges
DROP VIEW IF EXISTS `v_user_privileges`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_user_privileges`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_user_privileges` AS SELECT 
	getModuleIdPath(priv.module_id, ',') AS module_id_path,
	modules.module_name,
	modules.module_url,
	priv.* 
FROM 
	tbl_user_privileges priv
LEFT JOIN 
	tbl_modules modules
ON
	priv.module_id=modules.id
WHERE	
	modules.is_active=1
	OR modules.need_privilege=0
ORDER BY 
	modules.parent_module_id, 
	modules.module_order ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
