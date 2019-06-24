/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50726
Source Host           : 127.0.0.1:3306
Source Database       : db_prueba

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-06-04 00:26:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_estado
-- ----------------------------
DROP TABLE IF EXISTS `tbl_estado`;
CREATE TABLE `tbl_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_estado
-- ----------------------------
INSERT INTO `tbl_estado` VALUES ('1', 'Activo');
INSERT INTO `tbl_estado` VALUES ('2', 'Inactivo');

-- ----------------------------
-- Table structure for tbl_pago
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pago`;
CREATE TABLE `tbl_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(100) DEFAULT NULL,
  `total` int(20) DEFAULT NULL,
  `moneda` varchar(5) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `requestId` int(50) DEFAULT NULL,
  `Url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_pago
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_pedido
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pedido`;
CREATE TABLE `tbl_pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `fecha_pedido` datetime DEFAULT NULL,
  `total_pedido` varchar(255) DEFAULT NULL,
  `flete_pedido` varchar(255) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_pedido
-- ----------------------------
INSERT INTO `tbl_pedido` VALUES ('1', null, '2019-06-24 03:08:33', '1045000', '0', 'efed2843ca95e6346586549cc51ae545');
INSERT INTO `tbl_pedido` VALUES ('2', null, '2019-06-24 03:08:53', '1188000', '0', 'b0ee54b04c8dec6b11380b75519c735c');
INSERT INTO `tbl_pedido` VALUES ('3', '5', '2019-06-24 03:43:34', '980000', '0', '31d18e714e47a6ca94a8ce709c6addf8');

-- ----------------------------
-- Table structure for tbl_pedido_detalle
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pedido_detalle`;
CREATE TABLE `tbl_pedido_detalle` (
  `id_pedido_det` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(255) DEFAULT NULL,
  `precio` int(255) DEFAULT NULL,
  PRIMARY KEY (`id_pedido_det`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_pedido_detalle
-- ----------------------------
INSERT INTO `tbl_pedido_detalle` VALUES ('1', '1', '7', '1', '362000');
INSERT INTO `tbl_pedido_detalle` VALUES ('2', '1', '6', '1', '219000');
INSERT INTO `tbl_pedido_detalle` VALUES ('3', '1', '3', '1', '464000');
INSERT INTO `tbl_pedido_detalle` VALUES ('4', '2', '4', '1', '465000');
INSERT INTO `tbl_pedido_detalle` VALUES ('5', '2', '1', '1', '426000');
INSERT INTO `tbl_pedido_detalle` VALUES ('6', '2', '2', '1', '297000');
INSERT INTO `tbl_pedido_detalle` VALUES ('7', '3', '6', '1', '219000');
INSERT INTO `tbl_pedido_detalle` VALUES ('8', '3', '2', '1', '297000');
INSERT INTO `tbl_pedido_detalle` VALUES ('9', '3', '3', '1', '464000');

-- ----------------------------
-- Table structure for tbl_producto
-- ----------------------------
DROP TABLE IF EXISTS `tbl_producto`;
CREATE TABLE `tbl_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` int(10) DEFAULT NULL,
  `img_ppla` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_producto
-- ----------------------------
INSERT INTO `tbl_producto` VALUES ('1', 'HUGO BOSS - THE SCENT', 'Los perfumes más buscados del mercado, en sus versiones originales y con sus marcas respectivas, listos para tu diario vivir o cualquier ocasión. Fragancia original y entrega en empaques originales.', '426000', 'locion-hugo-boss-the-scent.jpg', '1');
INSERT INTO `tbl_producto` VALUES ('2', 'HUGO BOSS - ENERGISE', 'Los perfumes más buscados del mercado, en sus versiones originales y con sus marcas respectivas, listos para tu diario vivir o cualquier ocasión. Fragancia original y entrega en empaques originales.', '297000', 'locion-hugo-boss-energise.jpg', '1');
INSERT INTO `tbl_producto` VALUES ('3', 'LOEWE - AGUA DE LOEWE', 'Los perfumes más buscados del mercado, en sus versiones originales y con sus marcas respectivas, listos para tu diario vivir o cualquier ocasión. Fragancia original y entrega en empaques originales.', '464000', 'locion-loewe-agua-de-loewe.jpg', '1');
INSERT INTO `tbl_producto` VALUES ('4', 'SOLO LOEWE - ESENCIAL', 'Los perfumes más buscados del mercado, en sus versiones originales y con sus marcas respectivas, listos para tu diario vivir o cualquier ocasión. Fragancia original y entrega en empaques originales.', '465000', 'locion-solo-loewe-esencial.jpg', '1');
INSERT INTO `tbl_producto` VALUES ('5', 'CALVIN KLEIN - CK BE', 'Los perfumes más buscados del mercado, en sus versiones originales y con sus marcas respectivas, listos para tu diario vivir o cualquier ocasión. Fragancia original y entrega en empaques originales.', '219000', 'locion-calvin-klein-ck-be.jpg', '2');
INSERT INTO `tbl_producto` VALUES ('6', 'CALVIN KLEIN - ONE WHITE', 'Los perfumes más buscados del mercado, en sus versiones originales y con sus marcas respectivas, listos para tu diario vivir o cualquier ocasión. Fragancia original y entrega en empaques originales.', '219000', 'locion-calvin-klein-one-white.jpg', '1');
INSERT INTO `tbl_producto` VALUES ('7', 'HUGO BOSS - UNLIMITED', 'Los perfumes más buscados del mercado, en sus versiones originales y con sus marcas respectivas, listos para tu diario vivir o cualquier ocasión. Fragancia original y entrega en empaques originales.', '362000', 'locion-hugo-boss-unlimited.jpg', '1');

-- ----------------------------
-- Table structure for tbl_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tbl_usuario`;
CREATE TABLE `tbl_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `perfil_id` int(11) DEFAULT NULL,
  `status` tinyint(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_usuario
-- ----------------------------
INSERT INTO `tbl_usuario` VALUES ('2', 'Jhunnyfer', 'jhumamc', '4d0fb475b242228032cbdf6d53924d2538df037b', 'Calle 104D#45', 'jhumamc@gmail.com', '1234343', '1', '1');
INSERT INTO `tbl_usuario` VALUES ('4', 'jjhunnyfer mena', null, '4d0fb475b242228032cbdf6d53924d2538df037b', 'CALLE 10F 12#89', 'deuno@deuno.com', '3113134943', '1', '1');
INSERT INTO `tbl_usuario` VALUES ('5', 'DeUnoTiendas', null, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'CALLE 10F 12#898', 'inversionession@gmail.com', '3113134943', '1', '1');
SET FOREIGN_KEY_CHECKS=1;
