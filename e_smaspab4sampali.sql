/*
 Navicat Premium Data Transfer

 Source Server         : myprojects
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3306
 Source Schema         : e_smaspab4sampali

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 27/07/2021 22:21:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for guru
-- ----------------------------
DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nip` bigint NULL DEFAULT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `jenis_kelamin` tinyint NULL DEFAULT NULL,
  `no_handphone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of guru
-- ----------------------------
INSERT INTO `guru` VALUES (1, 127171717, 'Ahmad Haris Lubis', 'Jl. Pukat IV No. 47 Medan ', 'Medan', '1966-01-17', 1, '081289435583', NULL, '2021-07-27 20:07:18', '2021-07-27 20:09:46');
INSERT INTO `guru` VALUES (2, 120001, 'Winda ', 'Saentis', 'Medan', '1989-10-01', 2, '085635871465', NULL, '2021-07-27 22:19:54', '2021-07-27 22:19:54');
INSERT INTO `guru` VALUES (3, 120002, 'Astri', 'Saentis', 'Medan', '1990-01-11', 2, '081384562380', NULL, '2021-07-27 22:22:41', '2021-07-27 22:22:41');

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `wali_kelas` bigint NULL DEFAULT NULL,
  `nama_kelas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` year NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kelas
-- ----------------------------
INSERT INTO `kelas` VALUES (1, 1, 'X', 2021, NULL, '2021-07-27 20:22:37', '2021-07-27 20:22:37');
INSERT INTO `kelas` VALUES (3, 2, 'X', 2020, NULL, '2021-07-27 22:24:05', '2021-07-27 22:24:05');
INSERT INTO `kelas` VALUES (4, 3, 'XI', 2020, NULL, '2021-07-27 22:24:26', '2021-07-27 22:24:26');

-- ----------------------------
-- Table structure for siswa
-- ----------------------------
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nis` bigint NOT NULL,
  `kelas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varbinary(255) NULL DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tanggal_lahir` date NULL DEFAULT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `jenis_kelamin` int NULL DEFAULT NULL,
  `nama_orangtua` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_handphone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of siswa
-- ----------------------------
INSERT INTO `siswa` VALUES (1, 10001, '1', 0x53697469204D6169205361726168, 'Jl. Sampali', '2000-10-10', 'Medan', 2, 'Budi', '081231231121', NULL, '2021-07-27 20:35:58', '2021-07-27 20:40:47');
INSERT INTO `siswa` VALUES (2, 1, '3', 0x4D696120416D656C6961, 'Sampali', '2001-09-17', 'Medan', 2, 'Hermanto', '083158734001', NULL, '2021-07-27 22:27:43', '2021-07-27 22:27:43');
INSERT INTO `siswa` VALUES (3, 2, '3', 0x4C696120416E697461, 'Saentis', '2003-10-03', 'Medan', 2, 'Andi', '085612007658', NULL, '2021-07-27 22:29:16', '2021-07-27 22:29:16');

-- ----------------------------
-- Table structure for transaksi_pembayaran_spp
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_pembayaran_spp`;
CREATE TABLE `transaksi_pembayaran_spp`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `siswa` bigint NULL DEFAULT NULL,
  `kode_pembayaran` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pembayaran` bigint NULL DEFAULT NULL,
  `tanggal_pembayaran` date NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of transaksi_pembayaran_spp
-- ----------------------------
INSERT INTO `transaksi_pembayaran_spp` VALUES (1, 1, 'A00001', 25000, '2021-01-01', NULL, '2021-07-27 21:20:33', '2021-07-27 21:22:12');
INSERT INTO `transaksi_pembayaran_spp` VALUES (2, 2, '10', 160000, '2021-10-01', NULL, '2021-07-27 22:30:11', '2021-07-27 22:30:11');
INSERT INTO `transaksi_pembayaran_spp` VALUES (3, 3, '10', 160000, '2021-10-05', NULL, '2021-07-27 22:31:04', '2021-07-27 22:31:04');

-- ----------------------------
-- Table structure for user_identities
-- ----------------------------
DROP TABLE IF EXISTS `user_identities`;
CREATE TABLE `user_identities`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `no_handphone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_identities
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL,
  `role` tinyint NOT NULL,
  `lastlogin` timestamp(0) NULL DEFAULT NULL,
  `device_model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `device_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `device_version` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `is_login` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'admin.smaspab4sampali@gmail.com', NULL, '$2y$10$m6zPP8TCwZYuDicvnmlqNupr2yRmES0lbP8qotLg3tgwgYajxvyLS', 1, 1, '2021-07-27 20:00:20', NULL, NULL, NULL, NULL, '2020-12-24 17:29:38', '2021-01-11 00:56:38', 1);

SET FOREIGN_KEY_CHECKS = 1;
