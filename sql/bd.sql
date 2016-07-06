/*
SQLyog Community v11.52 (64 bit)
MySQL - 5.6.16 : Database - buenisimo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`buenisimo` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `buenisimo`;

/*Table structure for table `cup_campana` */

DROP TABLE IF EXISTS `cup_campana`;

CREATE TABLE `cup_campana` (
  `id_campana` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(1000) NOT NULL,
  `subtitulo` varchar(1000) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `sobre_campana` varchar(5000) DEFAULT NULL,
  `observaciones` varchar(5000) DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `fecha_final` date NOT NULL,
  `hora_final` time NOT NULL,
  `fecha_validez` date DEFAULT NULL COMMENT 'Fecha de Validez del Cupon',
  `id_empresa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  PRIMARY KEY (`id_campana`),
  KEY `fk_cup_campana_ge_empresa1_idx` (`id_empresa`),
  KEY `fk_cup_campana_acc_usuario1_idx` (`id_user`),
  CONSTRAINT `fk_cup_campana_acc_usuario1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cup_campana_ge_empresa1` FOREIGN KEY (`id_empresa`) REFERENCES `gen_empresa` (`id_empresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `cup_campana` */

insert  into `cup_campana`(`id_campana`,`titulo`,`subtitulo`,`descripcion`,`sobre_campana`,`observaciones`,`fecha_inicio`,`hora_inicio`,`fecha_final`,`hora_final`,`fecha_validez`,`id_empresa`,`id_user`,`fecha_registro`) values (1,'¡Al ataque! S/. 58 en vez de S/. 128 por 48 Cortes de Makis para 2 personas: 12 Tenkatsu + 12 Emperador + 12 Volcanos + 12 Acevichado en ASAKUSA SUSHI BAR – RESTAURANTE','48 Cortes de Makis en Asakusa Sushi Bar - Restaurante','¡Coge los palitos y prepara a tu estómago, porque lo que se viene está buenazo! Come todos estos makis con un extraordinario 55% de descuento. ¡Lleva a tu acompañante y juntos devórenlo todo!','<br/>&bull; 48 piezas de makis:<br /><br /><b>Descripción del servicio:</b><br /><b>- 12 Acevichados:</b> relleno de palta, langostino empanizado y pulpa de cangrejo. Vienen cubiertos en salsa acevichada.<br /><br /><b>- 12 Tenkatsu:</b> relleno de langostino empanizado, palta, queso crema. Cubierto con chispas de tempura, cebollita china en salsa dulce y ajonjolí blanco. <br /> <br /><b>- 12 Emperador:</b> relleno de queso crema, langostino empanizado. Cubierto de láminas de palta en salsa taré. <br /><br /><b>- 12 Volcanos:</b> relleno de langostino empanizado y queso crema. Cubiertos de láminas de palta en salsa picante.<br /><br />',NULL,'2014-12-28','00:00:00','2015-05-31','23:59:00',NULL,1,1,'2014-12-28 10:00:00'),(2,'S/. 299 en vez de S/. 600 por Láminas de Seguridad transparentes de 12 mil. para auto (incluye los 4 vidrios laterales y el posterior) + Instalación + Lavado de PROFILMS','Láminas de Seguridad para tu auto e instalación de Profilms','¡No arriesgues tu vida! Las láminas de seguridad de Profilms reducirán todos los riesgos de sufrir algún corte con el vidrio del auto. Las láminas harán que las esquirlas del vidrio roto por el impacto, no te caigan. ¡Viaja seguro con este 50% de descuento!','<br/>&bull; Láminas de seguridad de 12 micras para auto (incluye los 4 vidrios laterales y la posterior) <br/>&bull; Instalación<br/>&bull; Lavado<br /><br /><b>Características:</b><br/>Se encuentran fabricadas con varias capas de poliéster de alta resistencia y una resina acrílica de alto rendimiento. <br/>Las láminas cuentan con un elevado grado de adherencia al vidrio. <br/>La gruesa capa de adhesiva incrementa la resistencia a fuertes impactos. <br/>Su espesor es de 12 milésimas de pulgada, lo que permite darle mayor protección a las ventanas de tu auto. <br /><br /><b>Beneficios:</b> <br/>La láminas de seguridad Profilms te protegerán de atentados, vandalismos, sismos y accidentes. En caso de un accidente puede salvarte la vida al mantener los fragmentos del vidrio unidos en una sola pieza. Esto te protegerá de las esquirlas voladoras de los vidrios de tu vehículo. Reduce el avance del fuego en caso de incendios. <br/>No distorsionan la visibilidad del vidrio instalado.<br /><br /><b>Instalación:</b> se hará en el mismo establecimiento <br /><br /><b>Lavado:</b> tu vehículo quedará más que limpio con este lavado exterior con shampoo, y siliconeado interior y exterior.<br /><br /><b>Duración:</b> 8 horas aproximadamente.<br /><br />No lo dejes para después... ¡Resguarda tu seguridad dentro del auto!',NULL,'2014-12-28','00:00:00','2015-05-31','23:59:00',NULL,2,1,'2014-12-28 10:00:00'),(3,'Desde S/. 39 Desayuno Buffet para 1 o 2 personas, según elijas, en NOVOTEL LIMA','Desayuno Buffet para 1 o 2 personas, según elijas, en Novotel Lima','No es tu cumpleaños ni Navidad... ¡Pero amamos celebrarte! Come todo lo que quieras y aprovecha este desayuno buffet para empezar tu día con todas las energías. ¡Viene con 26% de descuento!','<br /><b>OPCIÓN 1:</b><br />S/. 39 en vez de S/. 53 por:<br />&bull; Desayuno Buffet para 1 persona.<br /><b>OPCIÓN 2:</b> <br />S/. 69 en vez de S/. 106 por:<br />&bull; Desayuno Buffet para 2 personas. <br />',NULL,'2014-12-28','00:00:00','2015-05-31','23:59:00',NULL,3,1,'2014-12-28 10:00:00'),(4,'¡Siempre liso! S/. 99 en vez de S/. 530 por Alisado brasilero con keratina + Sistema acelerador fotónico Photon Lizze + Post lavado con mascarilla de chocolate + Cambio de esmalte Masglow en NAOMI’S Salón y Spa','Alisado brasilero con keratina + Photon Lizze en Naomi\'s','¿Algún compromiso o simplemente buscas lucir un cabello magnífico? ¡Es hora de hacerlo! Si necesitabas más brillo, sedosidad y cero frizz, aprovecha este alisado con photon lizze con 81% de descuento ;)','<br /><b>&bull; Alisado brasilero con keratina:</b> ideal para cabellos resecos, esponjosos y maltratados; el alisado dejará tu cabello hidratado, suave y sedoso, reduciendo notablemente su volumen. <br /><br /><b>&bull; Sistema acelerador fotónico Photon Lizze:</b> es un revolucionario tratamiento a base de rayos de luz fría que logra un laceado de impacto. Con esto obtendrás un cabello más suave, brillante, manejable y sin rastros de frizz. <br /><br /><b>&bull; Post lavado con mascarilla de chocolate Gold brasilera:</b> fortalece el cabello y sella las puntas. Será realizado a los 2 o 3 días después.<br /><br /><b>• Cambio de esmalte con la reconocida marca Masglow.</b><br /><br /><b>Nota: el largo del cabello debe medir hasta la altura del brasier (si la sobrepasa tendrá que abonar S/. 35 más en el Salón).</b><br />',NULL,'2014-12-28','00:00:00','2015-05-31','23:59:00',NULL,4,1,'2014-12-28 10:00:00'),(5,'¡Cusco te llama! S/. 50 en vez de S/. 85 por City Tour en Mirabus por Cusco + Desayuno + Movilidad turística en el Valle Sagrado + Guía profesional con TU VIAJE PERÚ','City Tour en Mirabus por Cusco + Guía y más con Tu Viaje Perú','Porque sabemos que la ciudad te está estresando, te traemos este OferTOP con 29% de descuento para disfrutes de una aventura turística en el Cusco, ¡así es, en el \"ombligo del mundo\"! No pierdas esta oportunidad y recorre sus calles, ruinas y hermosos paisajes','<br />• City Tour en Mirabus por Cusco<br />• Movilidad turística en el Valle Sagrado<br />• Guía profesional<br /><br /><b>* DIA 1:</b><br />Tour a la ciudad:<br />Punto de encuentro Plaza de Armas de Cusco 1.45 p.m.<br />Luego  visita al Qoricancha  o Templo del Sol – Sacsayhuaman - Puca Pucara - Tambomachay y Qenqo, luego retorno a la ciudad de Cusco 6:30 p.m.<br /><br /><b>Incluye:</b><br />• Bus  turístico para el grupo  <br />• Guía profesional <br /><br /><b>No incluye:</b><br />• Boleto  Turístico  (varían según pasajero nacional ,estudiante o extranjeros, niños menores de 7 años  no pagan ingresos)<br />• Entradas al Qoricancha (S/. 10)<br /><br /><b>* DIA 2:</b><br />Valle sagrado: <br />Punto de encuentro: Plaza de Armas de Cusco a las 8.20 a.m.<br />Este tour se inicia aproximadamente a las 8:20 a.m. y finaliza a las 7 p.m., pasarán por su hotel, para tener una visita guiada al Valle Sagrado de los Incas, sobre el río Vilcanota, para una vista panorámica de la ciudadela Inca de Pisac y visita al típico mercado Indio de Pisac, donde tendrán la oportunidad de conocer de cerca las costumbres de sus pobladores y regatear precios con los vendedores. Luego se dirigirán a la Ciudad de Urubamba, viajando a orillas del rio Vilcanota, llegarán a la ciudad inca de Ollantaytambo y el  camino de  retorno  lo harán visitando  el pintoresco  pueblo de Chinchero. Regresan a la ciudad de Cusco  a las  7 p.m.<br /><br /><b>Incluye:</b><br />• Bus  turístico para el grupo  en el valle sagrado<br />• Guía profesional al valle sagrado<br /><br /><b>No incluye:</b><br />• Boleto  Turístico  (varían según pasajero nacional ,estudiante o extranjeros, niños menores de 7 años  no pagan ingresos)<br />• Almuerzo <br /><br /><b>¡Maravíllate con este video del Valle Sagrado!</b><br />',NULL,'2014-12-28','00:00:00','2015-05-31','23:59:00',NULL,5,1,'2014-12-28 10:00:00'),(6,'¡Somos Trujillo! S/. 192 en vez de S/. 320 por 3D/2N para 2 en HOTEL CONVENCIÓN + Desayunos + Servicio a la habitación','¡Vamos a Trujillo! 3D/2N para 2 en Hotel Convención','Si no has viajado al norte de nuestro querido Perú, te estás perdiendo de lo mejor. ¿Precios altos? ¿Falta de tiempo? ¿El trabajo no te lo permite? Todas esas excusas quedarán de lado con esta oferta con 40% de descuento. ¡Sal de la rutina!','<br />• 3D/2N en habitación doble o matrimonial en HOTEL CONVENCIÓN de Trujillo<br />• Desayunos<br />• Servicio a la habitación sin recargo<br /><br /><b>Descripción:</b><br /><b>- Hotel Convención:</b> se esfuerza por hacer de tu estadía una experiencia satisfactoria. Su estratégica ubicación, excelente servicio personalizado, trato cordial y variedad de comodidades, hará que tu estadía sea inolvidable.<br /><br /><b>- Los desayunos constan de:</b> jugo de frutas naturales, pan, mermelada, mantequilla, café c/s leche y huevos revueltos con jamón.<br /><br /><b>- También incluye:</b> wifi, servicio a la habitación sin recargo, TV con cable, baño privado y agua caliente.',NULL,'2014-12-28','00:00:00','2015-05-31','23:59:00',NULL,6,1,'2014-12-28 10:00:00'),(7,'¡Adrenalina al máximo! S/. 139 en vez de S/. 279 por Skatecycle MONARK® en color blanco o negro, según elijas','Skatecycle Monark® en color blanco o negro, según elijas','Que tu pequeño le dé con todo a su futuro skatecycle Monark® y se vuelva todo un deportista extremo. ¡Mantenlo entretenido con este descuento de hasta 50%!','<br /><b>OPCIÓN 1:</b><br />• Skatecycle MONARK® en color blanco<br /><br /><b>OPCIÓN 2:</b><br />• Skatecycle MONARK® en color negro<br /><br />',NULL,'2014-12-28','00:00:00','2015-05-31','23:59:00',NULL,7,1,'2014-12-28 10:00:00');

/*Table structure for table `cup_campana_categoria` */

DROP TABLE IF EXISTS `cup_campana_categoria`;

CREATE TABLE `cup_campana_categoria` (
  `id_campana` int(11) NOT NULL,
  `id_sub_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_campana`,`id_sub_categoria`),
  KEY `fk_cup_acuerdo_has_gen_categoria_cup_acuerdo_idx` (`id_campana`),
  KEY `fk_cup_campana_categoria_gen_sub_categoria1_idx` (`id_sub_categoria`),
  CONSTRAINT `fk_cup_acuerdo_has_gen_categoria_cup_acuerdo` FOREIGN KEY (`id_campana`) REFERENCES `cup_campana` (`id_campana`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cup_campana_categoria_gen_sub_categoria1` FOREIGN KEY (`id_sub_categoria`) REFERENCES `gen_sub_categoria` (`id_sub_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cup_campana_categoria` */

insert  into `cup_campana_categoria`(`id_campana`,`id_sub_categoria`) values (1,20),(2,23),(3,19),(4,1),(5,21),(6,21),(7,24);

/*Table structure for table `cup_campana_opcion` */

DROP TABLE IF EXISTS `cup_campana_opcion`;

CREATE TABLE `cup_campana_opcion` (
  `id_campana_opcion` int(11) NOT NULL AUTO_INCREMENT,
  `id_campana` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `precio_regular` decimal(12,2) NOT NULL,
  `precio_especial` decimal(12,2) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `vendidos` int(11) DEFAULT NULL,
  `comision` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id_campana_opcion`,`id_campana`),
  KEY `fk_cup_campana_opcion_cup_campana1_idx` (`id_campana`),
  CONSTRAINT `fk_cup_campana_opcion_cup_campana1` FOREIGN KEY (`id_campana`) REFERENCES `cup_campana` (`id_campana`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `cup_campana_opcion` */

insert  into `cup_campana_opcion`(`id_campana_opcion`,`id_campana`,`descripcion`,`precio_regular`,`precio_especial`,`cantidad`,`vendidos`,`comision`) values (1,1,'48 piezas de makis.       ','128.00','58.00',NULL,59,'38.00'),(2,2,'Láminas de seguridad de 12 micras para auto.','600.00','299.00',NULL,35,'0.00'),(3,3,'Desayuno Buffet para 1 persona.','53.00','39.00',NULL,NULL,'0.00'),(4,3,'Desayuno Buffet para 2 personas.','106.00','69.00',NULL,99,'0.00'),(5,4,'Alisado brasilero con keratina.','530.00','99.00',NULL,23,'0.00'),(6,5,'City Tour en Mirabus por Cusco.','85.00','50.00',NULL,1,'0.00'),(7,6,'3D/2N en habitación doble o matrimonial en HOTEL CONVENCIÓN de Trujillo','320.00','192.00',NULL,21,'0.00'),(8,7,'Skatecycle MONARK® en color blanco','279.00','140.00',NULL,NULL,'0.00'),(9,7,'Skatecycle MONARK® en color negro','279.00','140.00',NULL,68,'0.00');

/*Table structure for table `cup_cliente` */

DROP TABLE IF EXISTS `cup_cliente`;

CREATE TABLE `cup_cliente` (
  `email_cliente` varchar(100) NOT NULL,
  `id_tipo_documento` char(3) DEFAULT NULL,
  `numero_documento` varchar(20) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `id_sexo` char(1) DEFAULT NULL,
  `nombres_facebook` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`email_cliente`),
  KEY `fk_cup_cliente_cup_tipo_documento1_idx` (`id_tipo_documento`),
  KEY `fk_cup_cliente_gen_sexo1_idx` (`id_sexo`),
  CONSTRAINT `fk_cup_cliente_cup_tipo_documento1` FOREIGN KEY (`id_tipo_documento`) REFERENCES `gen_tipo_documento` (`id_tipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cup_cliente_gen_sexo1` FOREIGN KEY (`id_sexo`) REFERENCES `gen_sexo` (`id_sexo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cup_cliente` */

insert  into `cup_cliente`(`email_cliente`,`id_tipo_documento`,`numero_documento`,`nombres`,`apellidos`,`telefono`,`celular`,`password`,`id_sexo`,`nombres_facebook`) values ('germancitotapia@hotmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `cup_cupon` */

DROP TABLE IF EXISTS `cup_cupon`;

CREATE TABLE `cup_cupon` (
  `id_cupon` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_cupon` varchar(45) NOT NULL,
  `email_cliente` varchar(100) NOT NULL,
  `id_campana` int(11) NOT NULL,
  `id_campana_opcion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `precio_total` decimal(12,2) NOT NULL,
  `id_tarjeta` char(3) NOT NULL,
  `id_estado_compra` int(11) NOT NULL,
  `fecha_compra` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cupon`),
  KEY `fk_cup_cupon_cup_cliente1_idx` (`email_cliente`),
  KEY `fk_cup_cupon_gen_estado_compra1_idx` (`id_estado_compra`),
  KEY `fk_cup_cupon_gen_tarjeta1_idx` (`id_tarjeta`),
  KEY `fk_cup_cupon_cup_campana_opcion1_idx` (`id_campana_opcion`,`id_campana`),
  CONSTRAINT `fk_cup_cupon_cup_campana_opcion1` FOREIGN KEY (`id_campana_opcion`, `id_campana`) REFERENCES `cup_campana_opcion` (`id_campana_opcion`, `id_campana`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cup_cupon_cup_cliente1` FOREIGN KEY (`email_cliente`) REFERENCES `cup_cliente` (`email_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cup_cupon_gen_estado_compra1` FOREIGN KEY (`id_estado_compra`) REFERENCES `gen_estado_compra` (`id_estado_compra`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cup_cupon_gen_tarjeta1` FOREIGN KEY (`id_tarjeta`) REFERENCES `gen_tarjeta` (`id_tarjeta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `cup_cupon` */

insert  into `cup_cupon`(`id_cupon`,`codigo_cupon`,`email_cliente`,`id_campana`,`id_campana_opcion`,`cantidad`,`precio_unitario`,`precio_total`,`id_tarjeta`,`id_estado_compra`,`fecha_compra`) values (1,'7676767889','germancitotapia@hotmail.com',6,7,2,'192.00','384.00','001',1,NULL),(2,'7676767889','germancitotapia@hotmail.com',1,1,2,'58.00','116.00','001',1,NULL),(3,'7676767889','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',1,NULL),(4,'7676767889','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',1,NULL),(5,'7676767889','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',1,NULL),(6,'7676767889','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',1,NULL),(7,'7676767889','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',1,NULL),(8,'7676767889','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',1,NULL),(9,'7676767889','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',1,NULL),(10,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(11,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(12,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(13,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(14,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(15,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(16,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(17,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(18,'7676767889','germancitotapia@hotmail.com',1,1,2,'58.00','116.00','001',3,NULL),(19,'7676767889','germancitotapia@hotmail.com',2,2,1,'299.00','299.00','001',3,NULL),(20,'7676767889','germancitotapia@hotmail.com',7,9,1,'140.00','140.00','001',1,NULL),(21,'7676767889','germancitotapia@hotmail.com',7,9,1,'140.00','140.00','001',1,NULL),(22,'7676767889','germancitotapia@hotmail.com',7,9,1,'140.00','140.00','001',3,NULL),(23,'7676767889','germancitotapia@hotmail.com',2,2,2,'299.00','598.00','001',3,NULL),(24,'7676767889','germancitotapia@hotmail.com',4,5,1,'99.00','99.00','001',3,'2015-04-19 20:45:44'),(25,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(26,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',3,'2015-04-19 20:51:04'),(27,'7676767889','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',3,'2015-04-19 23:55:14'),(28,'7676767889','germancitotapia@hotmail.com',4,5,1,'99.00','99.00','001',3,'2015-04-20 22:02:04'),(29,'7676767889','germancitotapia@hotmail.com',3,4,1,'69.00','69.00','001',1,NULL),(30,'7676767889','germancitotapia@hotmail.com',3,4,1,'69.00','69.00','001',3,'2015-04-22 09:41:28'),(31,'7676767889','germancitotapia@hotmail.com',6,7,1,'192.00','192.00','001',3,'2015-04-22 12:42:28'),(32,'0OA==','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(33,'0Mw==','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',3,'2015-04-28 04:52:03'),(34,'OPT-045335-20150428-Nw==','germancitotapia@hotmail.com',2,2,1,'299.00','299.00','001',3,'2015-04-28 04:53:41'),(35,'OPT-12200558152804-0','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',3,'2015-04-28 05:13:04'),(36,'ECU-15200500152804-9','germancitotapia@hotmail.com',5,6,1,'50.00','50.00','001',3,'2015-04-28 05:15:05'),(37,'ECU-232005281-52304-3','germancitotapia@hotmail.com',2,2,1,'299.00','299.00','001',5,'2015-04-28 05:23:29'),(38,'ECU-582014031-50005-6','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',1,NULL),(39,'ECU-582014031-54805-0','germancitotapia@hotmail.com',1,1,1,'58.00','58.00','001',5,'2015-05-03 14:59:02');

/*Table structure for table `cup_liquidacion` */

DROP TABLE IF EXISTS `cup_liquidacion`;

CREATE TABLE `cup_liquidacion` (
  `id_liquidacion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_liquidacion` datetime DEFAULT NULL,
  `cantidad_cupones` int(11) DEFAULT NULL,
  `total_importe` decimal(12,2) DEFAULT NULL,
  `comision` decimal(12,2) DEFAULT NULL,
  `impuesto` decimal(12,2) DEFAULT NULL,
  `total_liquidacion` decimal(12,2) DEFAULT NULL,
  `id_campana` int(11) NOT NULL,
  PRIMARY KEY (`id_liquidacion`,`id_campana`),
  KEY `fk_cup_liquidacion_cup_campana1_idx` (`id_campana`),
  CONSTRAINT `fk_cup_liquidacion_cup_campana1` FOREIGN KEY (`id_campana`) REFERENCES `cup_campana` (`id_campana`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cup_liquidacion` */

/*Table structure for table `cup_liquidacion_cupon` */

DROP TABLE IF EXISTS `cup_liquidacion_cupon`;

CREATE TABLE `cup_liquidacion_cupon` (
  `id_liquidacion` int(11) NOT NULL,
  `id_cupon` int(11) NOT NULL,
  PRIMARY KEY (`id_liquidacion`,`id_cupon`),
  KEY `fk_cup_liquidacion_has_cup_cupon_cup_cupon1_idx` (`id_cupon`),
  KEY `fk_cup_liquidacion_has_cup_cupon_cup_liquidacion1_idx` (`id_liquidacion`),
  CONSTRAINT `fk_cup_liquidacion_has_cup_cupon_cup_cupon1` FOREIGN KEY (`id_cupon`) REFERENCES `cup_cupon` (`id_cupon`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cup_liquidacion_has_cup_cupon_cup_liquidacion1` FOREIGN KEY (`id_liquidacion`) REFERENCES `cup_liquidacion` (`id_liquidacion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cup_liquidacion_cupon` */

/*Table structure for table `cup_operador` */

DROP TABLE IF EXISTS `cup_operador`;

CREATE TABLE `cup_operador` (
  `id_operador` int(11) NOT NULL,
  `apellido_paterno` varchar(25) NOT NULL,
  `apellido_materno` varchar(25) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `numero_cuenta` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comision` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_operador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `cup_operador` */

/*Table structure for table `gen_categoria` */

DROP TABLE IF EXISTS `gen_categoria`;

CREATE TABLE `gen_categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `gen_categoria` */

insert  into `gen_categoria`(`id_categoria`,`descripcion`) values (1,'Belleza & Salud'),(2,'Viajes'),(3,'Restaurantes'),(4,'Entretenimiento'),(5,'Productos'),(6,'Servicios');

/*Table structure for table `gen_empresa` */

DROP TABLE IF EXISTS `gen_empresa`;

CREATE TABLE `gen_empresa` (
  `id_empresa` int(11) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `registro_contribuyente` varchar(25) NOT NULL,
  `direccion_facturacion` varchar(150) NOT NULL,
  `direccion_comercial` varchar(150) DEFAULT NULL,
  `telefono` varchar(100) NOT NULL,
  `horario` varchar(150) NOT NULL,
  `web_site` varchar(150) DEFAULT NULL,
  `ubicacion_gps` varchar(500) DEFAULT NULL,
  `numero_cuenta` varchar(100) DEFAULT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `id_operador` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`),
  KEY `fk_ge_empresa_cup_operador1_idx` (`id_operador`),
  CONSTRAINT `fk_ge_empresa_cup_operador1` FOREIGN KEY (`id_operador`) REFERENCES `cup_operador` (`id_operador`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `gen_empresa` */

insert  into `gen_empresa`(`id_empresa`,`razon_social`,`registro_contribuyente`,`direccion_facturacion`,`direccion_comercial`,`telefono`,`horario`,`web_site`,`ubicacion_gps`,`numero_cuenta`,`descripcion`,`id_operador`) values (1,'ASAKUSA','567688888','Av. Javier Prado Este 2994, San Borja',NULL,'3245678','Horario de almuerzo: de lunes a jueves de 12:30 m. a 3:30 p.m. Horario de cena: de lunes a jueves de 7 p.m. a 11 p.m.','http://www.asakusa.pe/','http://maps.google.com/maps/api/staticmap?center=-12.087261,-76.995996&zoom=13&markers=-12.087261,-76.995996&size=200x200&sensor=TRUE_OR_FALSE','345566777','Asakusa Sushibar Restaurante fue creado por cuatro jóvenes peruanos japoneses, con la idea de ofrecer la mejor comida japonesa fusión de Lima. Cuenta con una variada y deliciosa carta, y un espectacular y bien surtido sushibar, además de un local con un bello local de estilo japonés contemporáneo y una atención de primera.',NULL),(2,'PROFILMS','23434343','Av. Javier Prado Este 3475-3477, San Borja',NULL,'3455455','De lunes a viernes de 8 a.m. a 6 p.m. / sábados de 8 a.m. a 2 p.m.','http://www.profilmssac.com','http://maps.google.com/maps/api/staticmap?center=-12.085235,-76.986734&zoom=13&markers=-12.085235,-76.986734&size=200x200&sensor=TRUE_OR_FALSE','434564545','Profilms es una empresa nacional especializada en la instalación de láminas de máxima seguridad y control solar para vidrios de vehículos y edificaciones. Ofrece una gran variedad de productos para la industria del vidrio como películas de diferentes colores, de privacidad y seguridad, de bombardeo iónico, etc.',NULL),(3,'NOVOTEL LIMA','43454545','Av. Victor Andrés Belaunde 198, San Isidro',NULL,'3454555','De lunes a domingos de 6 a.m. a 10 a.m.','http://www.novotel.com/es/hotel-6339-novotel-lima/index.shtml','http://maps.google.com/maps/api/staticmap?center=-12.095977,-77.036604&zoom=13&markers=-12.085235,-76.986734|-12.095977,-77.036604|-12.095977,-77.036604&size=200x200&sensor=TRUE_OR_FALSE','455656656','Novotel es una prestigiosa cadena hotelera con casi 400 hoteles en todo el mundo. Novotel Lima se encuentra estratégicamente ubicado en el distrito de San Isidro y cuenta con 208 habitaciones, 7 salas de reuniones, wi fi en todos sus ambientes, restaurante, bar, gimnasio, piscina y estacionamiento para ofrecer un servicio de calidad a sus huéspedes. Los servicios que ofrece lo convierten en el lugar ideal para viajes de negocios y de placer.',NULL),(4,'NAOMI\'S SALÓN & SPA','34344344','Jr. Canterac 325, Jesús María',NULL,'4566666','De lunes a sábado de 9:30 a.m. a 8 p.m.','http://www.facebook.com/Naomisalon','http://maps.google.com/maps/api/staticmap?center=-12.070663,-77.047053&zoom=13&markers=-12.085235,-76.986734|-12.095977,-77.036604|-12.095977,-77.036604|21.885754,-102.369081|-12.070663,-77.047053&size=200x200&sensor=TRUE_OR_FALSE','767777777','Naomi´s Salón y Spa es un centro de belleza especializado en el cuidado de la mujer. Su staff de profesionales te brindarán los más modernos tratamientos entre faciales, tintes, depilación, manicure y pedicure que harán resaltar tu belleza.',NULL),(5,'TU VIAJE PERÚ','34343434','Urb. Parque Industrial, Av. Las Américas C6, Wanchaq, Cusco',NULL,'6789999','De lunes a domingo de 8 a.m. a 10 p.m.','http://tuviajeperu.com/','http://maps.google.com/maps/api/staticmap?center=-13.534691,-71.949026&zoom=13&markers=-12.085235,-76.986734|-12.095977,-77.036604|-12.095977,-77.036604|21.885754,-102.369081|-12.070663,-77.047053|-13.534691,-71.949026&size=200x200&sensor=TRUE_OR_FALSE','765544444','Tu Viaje Perú es una agencia de turismo con una amplia alternativa de viajes nacionales e internacionales. Encontrarás servicios turísticos de alta calidad, con respeto del medio ambiente y de las condiciones de trabajo de sus colaboradores. Ofrecen alternativas de viajes adaptadas a todo tipo de público: grupos de excursiones, estudiantes, familias, aventureros y personas con deseos de disfrutar del Perú.',NULL),(6,'HOTEL CONVENCIÓN','56678888','Calle Las Orquídeas Mz. F, Lt. 10, Urbanización Las Flores, Trujillo',NULL,'7899999','Reservas: de lunes a sábado de 9 a.m. a 6 p.m.','http://convenciontrujillo.com','http://maps.google.com/maps/api/staticmap?center=-8.087972,-79.047203&zoom=13&markers=-12.085235,-76.986734|-12.095977,-77.036604|-12.095977,-77.036604|21.885754,-102.369081|-12.070663,-77.047053|-13.534691,-71.949026|-8.087972,-79.047203&size=200x200&sensor=TRUE_OR_FALSE','888888888','Hotel Convención es un hotel 3* con servicio personalizado y todas las comodidades que necesitas para disfrutar una estadía placentera. El hotel cuenta con cómodas habitaciones, baños independientes, servicio de lavandería, cafetería, peluquería y servicio de taxi para tu mayor comodidad. Encontrarás toda la elegancia y confort que buscas para unos días fuera de Lima.',NULL),(7,'MONARK','85894894','Calle Libertadores 171, San Isidro / Av. Elmer Calle Libertadores 171, San Isidro / Av. Elmer Faucet 1920 (frente a la base aeronaval), Callao',NULL,'6778888','De lunes a sábado de 10 a.m a 8 p.m. (San Isidro) / de lunes a sábado de 9 a.m. a 5:30 p.m. (Callao)','http://www.monarkperu.com/','http://maps.google.com/maps/api/staticmap?center=-12.100623,-77.037312&zoom=13&markers=-12.100623,-77.037312&size=200x200&sensor=TRUE_OR_FALSE','456777777','Monark es la empresa peruana que nació en 1952 bajo el objetivo de ser una de las más importantes en bicicletas, triciclos, carritos, scooters, repuestos y accesorios, equipos para hacer ejercicios y más. Al poco tiempo lograron gran popularidad y aceptación entre grandes y chicos, vendiéndose en todas las ciudades y provincias del país.',NULL),(8,'MR. GRILL','67788888','Ca. Santa Isabel 615 Urb. Colmenares - Pueblo Libre (ref. cdra 8 de Av. La Marina)',NULL,'567777','Horario de atención: de lunes a domingo de 9 a.m. a 6 p.m.','http://www.facebook.com/pages/Mr-Grill-Peru/109785929079803?fref=ts','http://maps.google.com/maps/api/staticmap?center=-12.079986,-77.070956&zoom=13&markers=-12.100623,-77.037312|36.778261,-119.417932|36.778261,-119.417932|36.778261,-119.417932|-12.079986,-77.070956&size=200x200&sensor=TRUE_OR_FALSE','322333333','Disfruta lo mejor de las carnes preparadas a la Caja china, al Cilindro o a la parrilla, al más puro estilo y sabor de los especialistas de Mr. Grill.',NULL),(9,'LACEADOS HÉCTOR','56565656','Calle Esperanza 135, tda. 207, Miraflores',NULL,'3434334','De lunes a viernes de 10 a.m. a 7 p.m. / sábados de 9 a.m. a 4 p.m.',NULL,'http://maps.google.com/maps/api/staticmap?center=-12.120402,-77.027676&zoom=13&markers=-12.120402,-77.027676&size=200x200&sensor=TRUE_OR_FALSE','656676767','Laceados Héctor es uno de los salones de belleza especializados en topo tipo de laceados. Cuenta con un staff de profesionales de la belleza, quienes están en constante formación y aprendiendo nuevas técnicas para ofrecerte el servicio de calidad que te mereces. Héctor orienta su trabajo a la belleza y cuidado del cabello con el profesionalismo y seriedad requeridos por el mercado actual. Para ello, utiliza los productos y tecnología más eficientes.',NULL),(10,'EQUILIBRIO CONCIENTE PERÚ','45555555','Calle Flora Tristán 598, Of. 4, San Isidro',NULL,'3343433','De lunes a viernes de 10 a.m. a 7 p.m.','http://www.equilibrioconcienteperu.blogspot.com/','http://maps.google.com/maps/api/staticmap?center=-12.095872,-77.057892&zoom=13&markers=-12.120402,-77.027676|-12.095872,-77.057892&size=200x200&sensor=TRUE_OR_FALSE','434343434','Equilibrio Conciente Perú ofrece tratamientos y actividades para el cuerpo, la mente y el espíritu en base a la sabiduría natural que manejan sus especialistas. Dentro de sus instalaciones cuentan con servicios de terapias colónicas, alimentación natural, programación neurolingüística y reiki, entre otros. Las raíces del centro radican en sus encargados: Martín Torres, técnico en dietética y nutrición natural, y Romina Linari, maestra de reiki y poseedora de un diploma internacional de coaching integral del Instituto de Estudios Integrales.',NULL);

/*Table structure for table `gen_estado_compra` */

DROP TABLE IF EXISTS `gen_estado_compra`;

CREATE TABLE `gen_estado_compra` (
  `id_estado_compra` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_estado_compra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `gen_estado_compra` */

insert  into `gen_estado_compra`(`id_estado_compra`,`descripcion`) values (1,'Pendiente'),(2,'En Proceso'),(3,'Pagado'),(4,'Devuelto'),(5,'Validado'),(6,'Vencido'),(7,'Liquidado');

/*Table structure for table `gen_sexo` */

DROP TABLE IF EXISTS `gen_sexo`;

CREATE TABLE `gen_sexo` (
  `id_sexo` char(1) NOT NULL,
  `descripcion_sexo` varchar(45) NOT NULL,
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `gen_sexo` */

insert  into `gen_sexo`(`id_sexo`,`descripcion_sexo`) values ('F','Femenino'),('M','Masculino');

/*Table structure for table `gen_sub_categoria` */

DROP TABLE IF EXISTS `gen_sub_categoria`;

CREATE TABLE `gen_sub_categoria` (
  `id_sub_categoria` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_sub_categoria`),
  KEY `fk_gen_sub_categoria_gen_categoria1_idx` (`id_categoria`),
  CONSTRAINT `fk_gen_sub_categoria_gen_categoria1` FOREIGN KEY (`id_categoria`) REFERENCES `gen_categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `gen_sub_categoria` */

insert  into `gen_sub_categoria`(`id_sub_categoria`,`descripcion`,`id_categoria`) values (1,'Alisados y Laceados',1),(2,'Tratamientos capilares',1),(3,'Tintes y Color',1),(4,'Faciales',1),(5,'Maquillaje Permanente',1),(6,'Peelings',1),(7,'Tratamientos Corporales',1),(8,'Depilación',1),(9,'Masajes',1),(10,'Manicure & Pedicure',1),(11,'Spa',1),(12,'Ecografía 4D',1),(13,'Pérdida de peso',1),(14,'Ginecología',1),(15,'Tratamientos preventivos',1),(16,'Podología',1),(17,'Odontología',1),(18,'Oftalmología',1),(19,'Buffets',3),(20,'Sushi & Makis',3),(21,'Viajes Nacionales',2),(22,'Viajes Internacionales',2),(23,'Automotriz',6),(24,'Deportes & Fitness',5);

/*Table structure for table `gen_tarjeta` */

DROP TABLE IF EXISTS `gen_tarjeta`;

CREATE TABLE `gen_tarjeta` (
  `id_tarjeta` char(3) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tarjeta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `gen_tarjeta` */

insert  into `gen_tarjeta`(`id_tarjeta`,`descripcion`) values ('001','Visa');

/*Table structure for table `gen_tipo_documento` */

DROP TABLE IF EXISTS `gen_tipo_documento`;

CREATE TABLE `gen_tipo_documento` (
  `id_tipo_documento` char(3) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `gen_tipo_documento` */

insert  into `gen_tipo_documento`(`id_tipo_documento`,`descripcion`) values ('CEX','Carnet de Extranjería'),('DNI','DNI'),('PAS','Pasaporte'),('RUC','RUC');

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `label` varchar(150) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acc_menu_acc_menu1_idx` (`parent`),
  CONSTRAINT `fk_acc_menu_acc_menu1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `menu` */

insert  into `menu`(`id`,`module`,`controller`,`action`,`label`,`parent`) values (1,'#','#','#','Mantenimiento',NULL),(2,'dashboard','user','list','Usuario',1),(3,'dashboard','role','list','Roles',1),(4,'dashboard','campana','list','Campaña',1),(5,'dashboard','micampana','index','Mi Campaña',NULL),(6,'dashboard','liquidacion','list','Liquidaciones',1),(7,'dashboard','empresa','list','Empresa',1);

/*Table structure for table `privilege` */

DROP TABLE IF EXISTS `privilege`;

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acc_privilegio_acc_rol1_idx` (`role_id`),
  KEY `fk_acc_privilegio_acc_menu1_idx` (`menu_id`),
  CONSTRAINT `fk_acc_privilegio_acc_menu1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_acc_privilegio_acc_rol1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `privilege` */

insert  into `privilege`(`id`,`role_id`,`menu_id`) values (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6),(7,1,7),(8,2,4),(9,2,7),(10,2,1);

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `role` */

insert  into `role`(`id`,`name`) values (1,'Super Administrador'),(2,'Administrador'),(3,'Establecimiento');

/*Table structure for table `ubi_departamento` */

DROP TABLE IF EXISTS `ubi_departamento`;

CREATE TABLE `ubi_departamento` (
  `id_pais` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_departamento`,`id_pais`),
  KEY `fk_ubi_departamento_ubi_pais1_idx` (`id_pais`),
  CONSTRAINT `fk_ubi_departamento_ubi_pais1` FOREIGN KEY (`id_pais`) REFERENCES `ubi_pais` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ubi_departamento` */

/*Table structure for table `ubi_distrito` */

DROP TABLE IF EXISTS `ubi_distrito`;

CREATE TABLE `ubi_distrito` (
  `id_pais` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_distrito` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_pais`,`id_departamento`,`id_provincia`,`id_distrito`),
  KEY `fk_ubi_distrito_ubi_provincia1_idx` (`id_pais`,`id_departamento`,`id_provincia`),
  CONSTRAINT `fk_ubi_distrito_ubi_provincia1` FOREIGN KEY (`id_pais`, `id_departamento`, `id_provincia`) REFERENCES `ubi_provincia` (`id_pais`, `id_departamento`, `id_provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ubi_distrito` */

/*Table structure for table `ubi_pais` */

DROP TABLE IF EXISTS `ubi_pais`;

CREATE TABLE `ubi_pais` (
  `id_pais` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ubi_pais` */

/*Table structure for table `ubi_provincia` */

DROP TABLE IF EXISTS `ubi_provincia`;

CREATE TABLE `ubi_provincia` (
  `id_pais` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_pais`,`id_departamento`,`id_provincia`),
  KEY `fk_ubi_provincia_ubi_departamento1_idx` (`id_departamento`,`id_pais`),
  CONSTRAINT `fk_ubi_provincia_ubi_departamento1` FOREIGN KEY (`id_departamento`, `id_pais`) REFERENCES `ubi_departamento` (`id_departamento`, `id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ubi_provincia` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `full_name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acc_usuario_acc_rol1_idx` (`role_id`),
  CONSTRAINT `fk_acc_usuario_acc_rol1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`,`full_name`,`email`,`role_id`) values (1,'gtapia','f162710ac5fb3754027223611251571ec5044227','Germán Tapia Rojas','gtapia@gibarcena.com.pe',1),(2,'avilchez','52ae22bb8bcd8f8ebeccb3598318d6ad7cae75dc','Arturo Vilchez','avilchez@gibarcena.com.pe',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
