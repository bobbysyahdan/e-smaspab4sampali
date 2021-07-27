/*
 Navicat Premium Data Transfer

 Source Server         : mariadb_project1
 Source Server Type    : MariaDB
 Source Server Version : 100413
 Source Schema         : bidlit

 Target Server Type    : MariaDB
 Target Server Version : 100413
 File Encoding         : 65001

 Date: 13/01/2021 13:05:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for book_identities
-- ----------------------------
DROP TABLE IF EXISTS `book_identities`;
CREATE TABLE `book_identities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `isbn` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_year` year(4) NOT NULL,
  `amount_subscribe` int(11) NOT NULL,
  `pages` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_package_edition` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_uploaded` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of book_identities
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for book_stocks
-- ----------------------------
DROP TABLE IF EXISTS `book_stocks`;
CREATE TABLE `book_stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_book` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `amount_digital_buyer` int(11) NOT NULL,
  `book_type` tinyint(4) NOT NULL,
  `is_available` tinyint(4) NOT NULL,
  `price` bigint(20) NOT NULL,
  `weight` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount_printed_buyer` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of book_stocks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for carts
-- ----------------------------
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_book_stock` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of carts
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for email_readers
-- ----------------------------
DROP TABLE IF EXISTS `email_readers`;
CREATE TABLE `email_readers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_transaction` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of email_readers
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for purchases
-- ----------------------------
DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_book_stock` int(11) NOT NULL,
  `id_transaction` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `book_type` tinyint(4) NOT NULL,
  `price` bigint(20) NOT NULL,
  `purchase_date` date NOT NULL,
  `id_status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of purchases
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for ref_book_categories
-- ----------------------------
DROP TABLE IF EXISTS `ref_book_categories`;
CREATE TABLE `ref_book_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of ref_book_categories
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_order` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `book_type` int(11) NOT NULL,
  `total_price` bigint(20) NOT NULL,
  `mid_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of transactions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for user_identities
-- ----------------------------
DROP TABLE IF EXISTS `user_identities`;
CREATE TABLE `user_identities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `no_handphone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_identities
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `lastlogin` timestamp NULL DEFAULT NULL,
  `device_model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_version` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_login` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'admin', 'admin.smapab4sampali@gmail.com', NULL, '$2y$10$m6zPP8TCwZYuDicvnmlqNupr2yRmES0lbP8qotLg3tgwgYajxvyLS', 1, 1, '2021-01-13 00:49:07', NULL, NULL, NULL, NULL, '2020-12-24 17:29:38', '2021-01-11 00:56:38', 1);
COMMIT;

-- ----------------------------
-- Table structure for verified_books
-- ----------------------------
DROP TABLE IF EXISTS `verified_books`;
CREATE TABLE `verified_books` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_book` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `book_type` tinyint(4) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_number` int(11) NOT NULL,
  `is_verified` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of verified_books
-- ----------------------------
BEGIN;
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;