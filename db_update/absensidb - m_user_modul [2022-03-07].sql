/*
 Navicat Premium Data Transfer

 Source Server         : LOCAL
 Source Server Type    : MySQL
 Source Server Version : 100132
 Source Host           : localhost:3306
 Source Schema         : absensidb

 Target Server Type    : MySQL
 Target Server Version : 100132
 File Encoding         : 65001

 Date: 07/03/2022 16:45:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_user_modul
-- ----------------------------
DROP TABLE IF EXISTS `m_user_modul`;
CREATE TABLE `m_user_modul`  (
  `module_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `nama_module` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `deskripsi_module` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `module` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url_module` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `icon_module` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `s_aktif` int(2) NULL DEFAULT -1,
  PRIMARY KEY (`module_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci;

-- ----------------------------
-- Records of m_user_modul
-- ----------------------------
BEGIN;
INSERT INTO `m_user_modul` VALUES ('0000hr', 'Menu Separator', 'Menu separator (sebagai pemisah saja)', '-', '-', '-', -1), ('0101', 'Dashboard', 'Dashboard informasi aplikasi sismap', 'dashboard', 'dashboard', 'fas fa-tachometer-alt', -1), ('0201', 'Setting Shift', 'Menu untuk menentukan jenis shift di unit kerja', 'shift/setting', 'shift/setting', 'fas fa-calendar-alt', -1), ('0202', 'Shift Pegawai', 'Menu untuk set shift masing-masing pegawai', 'shift/pegawai', 'shift/pegawai', 'fas fa-user-clock', -1), ('0301', 'Broadcast', 'Menu untuk memberikan pengumuman', 'broadcast', 'broadcast', 'fas fa-bullhorn', -1), ('0501', 'User', 'Menu untuk manajemen user', 'user', 'user', 'fas fa-user', -1), ('0621', 'Verifikasi Absensi', 'Menu untuk verifikasi absensi mobile', 'verif_absen', 'verif_absen', 'fas fa-clipboard-check', -1), ('0622', 'Verifikasi Ijin', 'Menu untuk verifikasi usulan ijin pegawai', 'verif_ijin', 'verif_ijin', 'fas fa-calendar-check', -1), ('9901', 'Logout', 'Menu untuk logout dari aplikasi', 'login', 'login', 'fas fa-sign-out-alt fa-rotate-180', -1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
