/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100411
 Source Host           : localhost:3306
 Source Schema         : pos-sederhana

 Target Server Type    : MySQL
 Target Server Version : 100411
 File Encoding         : 65001

 Date: 04/07/2020 14:11:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for detailtransaksi
-- ----------------------------
DROP TABLE IF EXISTS `detailtransaksi`;
CREATE TABLE `detailtransaksi`  (
  `transaksiId` int(11) NOT NULL,
  `produkId` int(11) NULL DEFAULT NULL,
  `namaProduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kategoriProduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kodeProduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` int(11) NULL DEFAULT NULL,
  `jumlah` int(11) NULL DEFAULT NULL,
  `pesan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detailtransaksi
-- ----------------------------
INSERT INTO `detailtransaksi` VALUES (1, 1, 'AIR MINERAL', '5', 'MINUMAN-0001', 50000, 1, '-');
INSERT INTO `detailtransaksi` VALUES (1, 1, 'Kentang Goreng', '5,8', 'SNCK-00001', 9000, 2, '-');
INSERT INTO `detailtransaksi` VALUES (2, 1, 'Kentang Goreng', '5,8', 'SNCK-00001', 9000, 1, '-');
INSERT INTO `detailtransaksi` VALUES (2, 1, 'LALAPAN AYAM', '4', 'AYAM-00001', 9000, 1, '-');

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `idKategori` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idKategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (4, 'Ayam');
INSERT INTO `kategori` VALUES (5, 'Minuman');
INSERT INTO `kategori` VALUES (7, 'Tambahan');
INSERT INTO `kategori` VALUES (8, 'Snack');

-- ----------------------------
-- Table structure for perangkat
-- ----------------------------
DROP TABLE IF EXISTS `perangkat`;
CREATE TABLE `perangkat`  (
  `idPerangkat` int(11) NOT NULL AUTO_INCREMENT,
  `nomorMeja` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `namaPerangkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idPerangkat`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of perangkat
-- ----------------------------
INSERT INTO `perangkat` VALUES (1, '01', 'TA-00021');
INSERT INTO `perangkat` VALUES (2, '02', 'TA-00022');

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `idProduk` int(11) NOT NULL AUTO_INCREMENT,
  `namaProduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `harga` int(11) NULL DEFAULT NULL,
  `status` enum('tersedia','kosong') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'kosong',
  `kodeProduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gambarProduk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `kategoriId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idProduk`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (1, 'Kentang Goreng', 9000, 'kosong', 'SNCK-00001', 'default.jpg', '5,8');
INSERT INTO `produk` VALUES (2, 'AIR MINERAL', 50000, 'kosong', 'MINUMAN-0001', 'default.jpg', '5');

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `idTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `perangkatId` int(11) NULL DEFAULT NULL,
  `namaPemesan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktuPesan` datetime(0) NULL DEFAULT NULL,
  `status` enum('belum-bayar','proses','selesai','batal') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `totalPembelian` int(11) NULL DEFAULT NULL,
  `waktuBayar` datetime(0) NULL DEFAULT NULL,
  `waktuSelesai` datetime(0) NULL DEFAULT NULL,
  `namaPerangkat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomorMeja` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idTransaksi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (1, 2, 'Firdha', '2020-06-22 20:41:29', 'selesai', 68000, '2020-06-22 20:48:53', '2020-06-22 20:55:07', 'TA-00021', '01');
INSERT INTO `transaksi` VALUES (2, 1, 'Donny', '2020-06-18 20:42:32', 'selesai', 18000, '2020-06-18 20:44:49', '2020-06-18 20:55:00', 'TA-00022', '02');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `level` enum('admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idUser`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (2, 'Administrator 2', 'admin', 'admin@admin.com', '', NULL);

SET FOREIGN_KEY_CHECKS = 1;
