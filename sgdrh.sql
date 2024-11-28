-- -------------------------------------------------------------
-- TablePlus 6.1.8(574)
--
-- https://tableplus.com/
--
-- Database: sgdrh
-- Generation Time: 2024-11-28 13:03:51.6200
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `areaadscripcion`;
CREATE TABLE `areaadscripcion` (
  `areaAdscripcion_id` int(11) NOT NULL AUTO_INCREMENT,
  `areaAdscripcion_nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`areaAdscripcion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

DROP TABLE IF EXISTS `documento`;
CREATE TABLE `documento` (
  `documento_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `documento_tipo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `documento_file` longblob,
  `documento_fechaCreacion` date DEFAULT NULL,
  `documento_estatus` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`documento_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

DROP TABLE IF EXISTS `jefeinmediato`;
CREATE TABLE `jefeinmediato` (
  `jefeInmediato_id` int(11) NOT NULL AUTO_INCREMENT,
  `jefeInmediato_nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `areaAdscripcion_id` int(11) NOT NULL,
  PRIMARY KEY (`jefeInmediato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

DROP TABLE IF EXISTS `puesto`;
CREATE TABLE `puesto` (
  `puesto_id` int(11) NOT NULL AUTO_INCREMENT,
  `puesto_nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`puesto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `rol_id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

DROP TABLE IF EXISTS `sindicato`;
CREATE TABLE `sindicato` (
  `sindicato_id` int(11) NOT NULL AUTO_INCREMENT,
  `sindicato_nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `sindicato_jefe` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`sindicato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nomina` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_curp` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_rfc` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_email` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_password` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_foto` longblob,
  `usuario_genero` varchar(1) COLLATE utf8mb4_spanish_ci NOT NULL,
  `usuario_fechaIngreso` date DEFAULT NULL,
  `usuario_fechaCumpleaños` date DEFAULT NULL,
  `puesto_id` int(11) NOT NULL,
  `areaAdscripcion_id` int(11) NOT NULL,
  `jefeInmediato_id` int(11) NOT NULL,
  `sindicato_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `usuario_estatus` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`usuario_id`),
  KEY `puesto_id` (`puesto_id`),
  KEY `areaAdscripcion_id` (`areaAdscripcion_id`),
  KEY `jefeInmediato_id` (`jefeInmediato_id`,`sindicato_id`,`rol_id`),
  KEY `rol_id` (`rol_id`),
  KEY `sindicato_id` (`sindicato_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`puesto_id`) REFERENCES `puesto` (`puesto_id`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`areaAdscripcion_id`) REFERENCES `areaadscripcion` (`areaAdscripcion_id`),
  CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`),
  CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`sindicato_id`) REFERENCES `sindicato` (`sindicato_id`),
  CONSTRAINT `usuario_ibfk_5` FOREIGN KEY (`jefeInmediato_id`) REFERENCES `jefeinmediato` (`jefeInmediato_id`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT INTO `areaadscripcion` (`areaAdscripcion_id`, `areaAdscripcion_nombre`) VALUES
(1, 'Administración y Finanzas'),
(2, 'Área Médica'),
(3, 'Biblioteca'),
(4, 'CIRSE'),
(5, 'Control Escolar'),
(6, 'DG'),
(7, 'Desarrollo Académico'),
(8, 'Gastronomía'),
(9, 'Ing. Civil'),
(10, 'Ing. Electrónica'),
(11, 'Ing. Electromecánica'),
(12, 'Ing. en Gestión Empresarial'),
(13, 'Ing. en Sistemas Computacionales'),
(14, 'Ing. Industrial'),
(15, 'Planeación'),
(16, 'Redes y Mantenimiento'),
(17, 'Servicio Social'),
(18, 'Servicios Generales'),
(19, 'Sindacato'),
(20, 'Vinculación'),
(21, 'Dirección de Campus');

INSERT INTO `documento` (`documento_id`, `usuario_id`, `documento_tipo`, `documento_file`, `documento_fechaCreacion`, `documento_estatus`) VALUES
(1, 1, 'Dia economico', '/Applications/MAMP/htdocs/uni/pdf/docs/Álvarez Arévalo Santiago Hommar Dia Economico 2024-11-22 1732320847.pdf', '2024-11-22', '2024-11-22'),
(2, 1, 'Dia De Cumpleaños', '/Applications/MAMP/htdocs/uni/pdf/docs/ÁlvarezArévaloSantiagoHommar_dia_de_cumpleaños_2024-11-27 1732321808.pdf', '2024-11-27', 'Pendiente'),
(3, 219, 'Dia de cumpleaños', '/Applications/MAMP/htdocs/uni/pdf/docs/Captura de pantalla 2024-11-22 a la(s) 5.17.59 p.m..png', '2024-11-22', 'Pendiente'),
(4, 1, 'Reporte de incidencia', '/Applications/MAMP/htdocs/uni/pdf/docs/Álvarez Arévalo Santiago Hommar Reporte De Incidencia 2024-11-22 1732323420.pdf', '2024-11-22', 'Pendiente');

INSERT INTO `jefeinmediato` (`jefeInmediato_id`, `jefeInmediato_nombre`, `areaAdscripcion_id`) VALUES
(1, 'González Pérez Martha Alicia', 1),
(2, 'Chávez Godoy Elia Yoselin', 5),
(3, 'Ruiz Monroy Nancy', 13),
(4, 'Betancourt Álvarez Denisse ', 8),
(5, 'Guerrero Arcos Elías', 9),
(6, 'Escobar Hernández Luis', 10),
(7, 'Iñiguez Velázquez Fernando', 11),
(8, 'García Domínguez Elizabeth', 12),
(9, 'Ruiz Becerra Edgar Rodolfo', 18),
(10, 'Casillas Salazar Francisco Enrique', 14),
(11, 'Ruiz Reyes J. Jesús', 7),
(12, 'Villa Dávalos Erika Giovana', 20),
(13, 'Ramos Osuna Cinthia Lizzeth', 21);

INSERT INTO `puesto` (`puesto_id`, `puesto_nombre`) VALUES
(1, 'Analista Especializado'),
(2, 'Analista Técnico'),
(3, 'Auxiliar Administrativo'),
(4, 'Bibliotecario'),
(5, 'Chofer'),
(6, 'Chofer de Director'),
(7, 'Coordinador de Promociones'),
(8, 'Director de UA'),
(9, 'Ingeniero en Sistemas'),
(10, 'Intendente'),
(11, 'Jefe de Departamento'),
(12, 'Jefe de División'),
(13, 'Jefe de Oficina'),
(14, 'Laboratorista'),
(15, 'Medico General'),
(16, 'Profesor Asignatura A'),
(17, 'Profesor Asignatura B'),
(18, 'Profesor Asociado A'),
(19, 'Profesor Asociado B'),
(20, 'Profesor Asociado C'),
(21, 'Profesor Titular A'),
(22, 'Psicóloga'),
(23, 'Secretaria del Dir. General'),
(24, 'Secretaria de Jefe de Departamento'),
(25, 'Secretaria de Subdirector'),
(26, 'Taquimecanógrafa'),
(27, 'Técnico en Mantenimiento'),
(28, 'Vigilante');

INSERT INTO `rol` (`rol_id`, `rol_nombre`) VALUES
(1, 'Administrador'),
(2, 'Director UA'),
(3, 'Empleado'),
(4, 'Jefe de Area'),
(5, 'Lider Sindical');

INSERT INTO `sindicato` (`sindicato_id`, `sindicato_nombre`, `sindicato_jefe`) VALUES
(1, 'No Sindicalizado', ''),
(2, 'STITJMMPH', 'Chávez Velázquez Adalberto'),
(3, 'SUFAATECMM', 'González Gómez Luis Cesar');

INSERT INTO `usuario` (`usuario_id`, `usuario_nomina`, `usuario_nombre`, `usuario_curp`, `usuario_rfc`, `usuario_email`, `usuario_password`, `usuario_foto`, `usuario_genero`, `usuario_fechaIngreso`, `usuario_fechaCumpleaños`, `puesto_id`, `areaAdscripcion_id`, `jefeInmediato_id`, `sindicato_id`, `rol_id`, `usuario_estatus`) VALUES
(1, 'ZAA0256', 'Álvarez Arévalo Santiago Hommar', 'AAAS830425HJCLRN16', 'AAAS8304251N9', 'hommar.alvarez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2005-10-03', '1983-04-25', 9, 16, 1, 3, 3, 'Vigente'),
(2, 'ZAD0674', 'Ambriz Olloqui Jorge', 'AIOJ620830HMNMLR05', 'AIOJ620830V64', 'jorge.ambriz@zapopan.tecmm.edu.mx', '$2y$10$ocglbFseZzDIAY08l92suerXwNcDzA/SzGqIhHleiJjilLsEp8q9m', NULL, 'H', '2015-10-01', '1996-03-26', 16, 10, 6, 3, 4, 'Vigente'),
(3, 'ZAD0550', 'Apolinar Sandoval Manuel', 'AOSM610709HMNPNN15', 'AOSM610709I46', 'manuel.apolinar@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-02-16', '1961-07-09', 16, 9, 5, 3, 3, 'Vigente'),
(4, 'ZAD0097', 'Arechiga Guzmán Jesús Arturo', 'AEGJ660312HJCRZS06', 'AEGJ660312227', 'arturo.arechiga@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2002-07-16', '1966-03-12', 19, 10, 6, 3, 3, 'Vigente'),
(5, 'ZAA0801', 'Arellano Godoy Cesar Delfino', 'AEGC940824HJCRDS04', 'AEGC940824E96', 'cesar.arellano@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2018-07-16', '1994-08-24', 28, 18, 9, 2, 3, 'Vigente'),
(6, 'ZAD0823', 'Arias Zambrano Federico Armando', 'AIZF800923HNTRMD01', 'AIZF800923P47', 'federico.arias@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2006-08-21', '1980-09-23', 19, 13, 3, 2, 3, 'Vigente'),
(7, 'ZAD0486', 'Arredondo Rivera Víctor Manuel', 'AERV810310HJCRVC01', 'AERV810310K43', 'victor.arredondo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-08-19', '1981-03-10', 19, 14, 10, 2, 3, 'Vigente'),
(8, 'ZAD0588', 'Ávila De La Paz Karla Bibiana', 'AIPK830610MJCVZR02', 'AIPK8306106P6', 'karla.avila@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2014-09-01', '1983-06-10', 19, 8, 4, 2, 3, 'Vigente'),
(9, 'ZAD0221', 'Aviña Méndez José Antonio', 'AIMA721217HJCVNN09', 'AIMA721217MKA', 'jose.avina@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', '', 'H', '2004-09-01', '1972-12-17', 20, 13, 3, 1, 3, 'Vigente'),
(10, 'ZAA0304', 'Badillo Gutiérrez Luis Salvador', 'BAGL790228HJCDTS09', 'BAGL790228IBA', 'salvador.badillo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2007-04-23', '1979-02-28', 9, 13, 3, 3, 3, 'Vigente'),
(11, 'ZAA0849', 'Baltazar Hernández Laura Fernanda', 'BAHL930915MJCLRR04', 'BAHL9309153Y1', 'laura.baltazar@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2022-12-01', '1993-09-15', 7, 20, 12, 2, 3, 'Vigente'),
(12, 'ZAD0844', 'Bernabe Madrueño Jorge Heriberto', 'BEMJ910427HJCRDR04', 'BEMJ910427FX5', 'jorge.bernabe@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-01-23', '1991-04-27', 16, 14, 10, 2, 3, 'Vigente'),
(13, 'ZAD0290', 'Bernal Marín Miguel', 'BEMM801006HJCRRG03', 'BEMM8010064N1', 'miguel.bernal@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-02-23', '1980-10-06', 18, 13, 3, 3, 3, 'Vigente'),
(14, 'ZAD0555', 'Betancourt Álvarez Denisse', 'BEAD780403MJCTLN02', 'BEAD780403GH7', 'denisse.betancourt@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2014-02-16', '1978-04-03', 12, 8, 13, 1, 4, 'Vigente'),
(15, 'ZAD0834', 'Bojórquez Guereña María Guadalupe', 'BOGG720227MSLJRD01', 'BOGG720227SF9', 'maria.bojorquez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2021-08-23', '1972-02-27', 16, 9, 5, 2, 3, 'Vigente'),
(16, 'ZAD0381', 'Cabral Martínez María Elena', 'CAME630327MJCBRL02', 'CAME6303271S5', 'maria.cabral@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2009-08-24', '1963-03-27', 19, 14, 10, 2, 3, 'Vigente'),
(17, 'ZAD0592', 'Camacho Pérez María De Los Ángeles', 'CAPA821205MJCMRN09', 'CAPA821205KY5', 'angeles.camacho@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2014-09-01', '1982-12-05', 16, 12, 8, 3, 3, 'Vigente'),
(18, 'ZAA0021', 'Camarero Jiménez Demetrio Rafael', 'CAJD691024HNTMMM05', 'CAJD691024BI4', 'rafa_its_becas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '1999-08-23', '1969-10-24', 13, 3, 13, 3, 3, 'Vigente'),
(19, 'ZAD0851', 'Campos Macías Leobardo Emmanuel', 'CAML910604HJCMCB04', 'CAML910604450', 'leobardo.campos@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-01-23', '1991-06-04', 16, 13, 3, 1, 3, 'Vigente'),
(20, 'ZAD0546', 'Cárdenas Larios Rigoberto', 'CALR810127HJCRRG08', 'CALR810127EJA', 'rigoberto.cardenas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-02-16', '1981-01-27', 17, 13, 3, 3, 3, 'Vigente'),
(21, 'ZAD0789', 'Carreón Gutiérrez Omar Bonifacio', 'CXGO781022HJCRTM06', 'CAGX781022A3A', 'omar.carreon@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2018-02-01', '1978-10-22', 18, 14, 10, 2, 3, 'Vigente'),
(22, 'ZAD0367', 'Carrillo Díaz Raúl', 'CADR710507HJCRZL09', 'CADR710507512', 'raul.carrillo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-02-23', '1971-05-07', 17, 10, 6, 3, 3, 'Vigente'),
(23, 'ZAD0083', 'Carrillo Sánchez Javier', 'CASJ561231HSLRNV19', 'CASJ561231UV5', 'javier.carrillo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2001-09-03', '1956-12-31', 18, 11, 7, 2, 3, 'Vigente'),
(24, 'ZAD0276', 'Casillas Salazar Francisco Enrique', 'CASF590715HJCSLR02', 'CASF590715D78', 'francisco.casillas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2006-08-21', '1959-07-15', 12, 14, 13, 1, 4, 'Vigente'),
(25, 'ZAD0682', 'Castañeda Campos Iván Refugio', 'CACI800925HJCSMV06', 'CACI8009258W2', 'ivan.castaneda@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2015-11-01', '1980-09-25', 18, 9, 5, 2, 3, 'Vigente'),
(26, 'ZAD0744', 'Castillo Castillo Cesar', 'CACC890619HJCSSS07', 'CACC890619190', 'cesar.castillo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-03-01', '1989-06-19', 16, 9, 5, 3, 3, 'Vigente'),
(27, 'ZAD0495', 'Castillo Peña Jorge', 'CAPJ810401HMNSXR02', 'CAPJ810401KU8', 'jorge.castillo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-08-19', '1981-04-01', 18, 14, 10, 2, 3, 'Vigente'),
(28, 'ZAD0445', 'Castro Valencia Alberto Merced', 'CAVA720105HJCSLL09', 'CAVA7201057R3', 'alberto.castro@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-02-18', '1972-01-05', 19, 12, 8, 2, 3, 'Vigente'),
(29, 'ZAA0872', 'Chávez Godoy Elia Yoselin', 'CAGE820625MJCHDL08', 'CAGE8020625K16', 'yoselin.chavez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2020-10-16', '1982-06-25', 11, 5, 13, 1, 4, 'Vigente'),
(30, 'ZAD0284', 'Chávez Medina Edgar', 'CAME750428HBCHDD02', 'CAME750428NR5', 'edgar.chavez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-09-25', '1975-04-28', 21, 11, 7, 2, 3, 'Vigente'),
(31, 'ZAD0346', 'Chávez Velázquez Adalberto', 'CAVA780811HJCHLD04', 'CAVA780811QE2', 'adalberto.chavez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', '', 'H', '2008-08-25', '1978-08-11', 17, 13, 3, 3, 5, 'Vigente'),
(32, 'ZAD0869', 'Cholico González Diana Fabiola', 'COGD811227MGTHNN02', 'COGD811227Q85', 'diana.cholico@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2023-09-06', '1981-12-27', 16, 14, 10, 2, 3, 'Vigente'),
(33, 'ZAD0855', 'Cinco Izquierdo Oscar Jair', 'CIIO911210HMNNZS08', 'CIIO9112102S4', 'oscar@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-03-06', '1991-12-10', 16, 10, 6, 3, 3, 'Vigente'),
(34, 'ZAD0630', 'Colina Carrillo Raquel', 'COCR720802MJCLRQ08', 'COCR720802VA3', 'raquel.colina@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2015-02-16', '1972-08-02', 18, 8, 4, 2, 3, 'Vigente'),
(35, 'ZAA0450', 'Cornejo Lomelí Neftalí', 'COLN740107HJCRMF18', 'COLN740107D98', 'neftali.cornejo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-03-07', '1974-01-07', 14, 18, 9, 3, 3, 'Vigente'),
(36, 'ZAA0413', 'Coronado Valencia Mayra Berenice', 'COVM710326MMNRLY02', 'COVM7103261Y8', 'mayra.coronado@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2011-08-16', '1971-03-26', 23, 9, 5, 1, 3, 'Vigente'),
(37, 'ZAD0287', 'Cortes Aguilar Teth Azrael', 'COAT800105HJCRGT06', 'COAT800105FL5', 'teth.cortes@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2007-02-12', '1980-01-05', 21, 10, 6, 3, 3, 'Vigente'),
(38, 'ZAA0431', 'Covarrubias Ramírez Ana Bertha', 'CORA830629MJCVMN05', 'CORA830629ER4', 'ana.covarrubias@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2012-09-17', '1983-06-29', 14, 16, 1, 2, 3, 'Vigente'),
(39, 'ZAD0086', 'Cruz Arriaga Mauro', 'CUAM760930HDFRRR17', 'CUAM760930ID4', 'mauro.cruz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2001-11-01', '1976-09-30', 12, 6, 13, 1, 3, 'Vigente'),
(40, 'ZAA0810', 'Cruz Tobilla Jonathan Mauricio', 'CUTJ991003HDFRBN00', 'CUTJ991003UI4', 'jonathan.cruz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2019-01-16', '1999-10-03', 5, 10, 6, 3, 3, 'Vigente'),
(41, 'ZAD0239', 'Damián Rodríguez Eduardo', 'DARE661013HJCMDD05', 'DARE661013CB3', 'eduardo.damian@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2005-02-14', '1966-10-13', 16, 14, 10, 3, 3, 'Vigente'),
(42, 'ZAD0140', 'Dávila Galaviz José Enrique', 'DAGE720319HJCVLN08', 'DAGE720319JS0', 'jose.davila@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2003-03-01', '1972-03-19', 16, 20, 12, 2, 3, 'Vigente'),
(43, 'ZAD0324', 'De La Peña Rodríguez Manuel Alfredo', 'PERM731021HCLXDN01', 'PERM731021CH9', 'manuel.delapena@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-02-23', '1973-10-21', 17, 11, 7, 3, 3, 'Vigente'),
(44, 'ZAD0796', 'De La Torre Morales Erik', 'TOME791027HJCRRR06', 'TOME791027PB1', 'erik.delatorre@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2018-03-01', '1979-10-27', 16, 13, 3, 1, 3, 'Vigente'),
(45, 'ZAD0814', 'Delgadillo López Francisco', 'DELF700213HJCLPR06', 'DELF700213BZ9', 'francisco.delgadillo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2019-02-16', '1970-02-13', 16, 11, 7, 2, 3, 'Vigente'),
(46, 'ZAD0828', 'Delgado Becerra Andrés', 'DEBA830120HJCLCN07', 'DEBA8301204F3', 'andres.delgado@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-08-16', '1983-01-20', 18, 12, 8, 1, 3, 'Vigente'),
(47, 'ZAD0437', 'Díaz Rodríguez Miriam', 'DIRM860524MJCZDR04', 'DIRM860524GD3', 'miriam.diaz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2012-09-21', '1986-05-24', 21, 13, 3, 3, 3, 'Vigente'),
(48, 'ZAD0843', 'Doroteo Pureco José De Jesús', 'DOPJ880119HJCRRS02', 'DOPJ880119FU8', 'jesus.doreteo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-01-23', '1988-01-19', 16, 14, 10, 2, 3, 'Vigente'),
(49, 'ZAD0080', 'Escobar Hernández Luis', 'EOHL670306HDFSRS03', 'EOHL670306NG1', 'escobar@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2001-09-03', '1967-03-06', 13, 10, 13, 1, 4, 'Vigente'),
(50, 'ZAD0773', 'Esparza López Aarón', 'EALA750701HZSSPR08', 'EALA750701PK2', 'aaron.esparza@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-09-01', '1975-07-01', 16, 8, 4, 2, 3, 'Vigente'),
(51, 'ZAD0482', 'Espinosa Martínez Celso Adán', 'EIMC861114HJCSRL00', 'EIMC861114H97', 'celso.espinosa@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-08-19', '1986-11-14', 17, 13, 3, 2, 3, 'Vigente'),
(52, 'ZAD0676', 'Espitia Aragón Araceli Susana', 'EIAA931208MMNSRR02', 'EIAA931208693', 'araceli.espitia@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2015-10-01', '1993-12-08', 16, 12, 8, 3, 3, 'Vigente'),
(53, 'ZAA0252', 'Felipe Arellano Humberto Benjamín', 'FEAH770325HJCLRM06', 'FEAH770325AE1', 'humberto.arellano@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2005-08-15', '1977-03-25', 15, 16, 1, 1, 3, 'Vigente'),
(54, 'ZAD0692', 'Flores Miranda Mario Federico', 'FOMM501123HNELRR01', 'FOMM501123T65', 'mario.flores@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2016-02-08', '1950-11-23', 28, 9, 5, 2, 3, 'Vigente'),
(55, 'ZAA0464', 'Flores Robles Susana', 'FORS650607MMNLBS00', 'FORS6506074U6', 'susana.flores@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2013-04-16', '1965-06-07', 10, 18, 9, 3, 3, 'Vigente'),
(56, 'ZAD0263', 'Franco Lara Ernesto Carlos', 'FALE780814HJCRRR01', 'FALE7808144P0', 'ernesto.franco@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2006-02-13', '1978-08-14', 18, 11, 7, 2, 3, 'Vigente'),
(57, 'ZAD0731', 'Fregoso Amezquita Antonio De Padua', 'FEAA560921HJCRMN08', 'FEAA560921232', 'antonio.fregoso@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-02-01', '1956-09-21', 17, 11, 7, 2, 3, 'Vigente'),
(58, 'ZAA0179', 'García Aldas Laura Ivon', 'GAAL751210MJCRLR01', 'GAAL751210553', 'lauraivon@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2003-11-01', '1975-12-10', 13, 20, 12, 2, 3, 'Vigente'),
(59, 'ZAD0632', 'García Arriazas Víctor Silvestre', 'GAAV780916HPLRRC05', 'GAAV780916NE2', 'victor.arriazas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2015-02-16', '1978-09-16', 16, 14, 10, 2, 3, 'Vigente'),
(60, 'ZAD0772', 'García Ayala María Guadalupe', 'GAAG811116MJCRYD00', 'GAAG811116LI6', 'maria.ayala@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2017-08-16', '1981-11-16', 16, 9, 5, 2, 3, 'Vigente'),
(61, 'ZAD0106', 'García Cerpas José Luis', 'GACL681110HMNRRS07', 'GACL681110CZA', 'jose.cerpas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2002-08-16', '1968-11-10', 17, 13, 3, 3, 3, 'Vigente'),
(62, 'ZAD0792', 'García Domínguez Elizabeth', 'GADE711111MGTRML02', 'GADE711111R8A', 'elizabeth.garcia@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2018-02-01', '1971-11-11', 12, 12, 13, 1, 4, 'Vigente'),
(63, 'ZAA0465', 'García Rodríguez María Lucia', 'GARL710405MJCRDC00', 'GARL710405TH4', 'maria.garcia@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2013-04-16', '1971-04-05', 28, 5, 2, 1, 3, 'Vigente'),
(64, 'ZAD0176', 'Garibaldi Hernández Ismael', 'GAHI680512HJCRRS09', 'GAHI680512649', 'ismael.garibaldi@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2003-09-16', '1968-05-12', 16, 13, 3, 2, 3, 'Vigente'),
(65, 'ZAD0216', 'Garza Cotta Carlos Javier', 'GACC590218HNLRTR02', 'GACC5902184D8', 'carlos.garza@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2004-08-23', '1959-02-18', 17, 14, 10, 2, 3, 'Vigente'),
(66, 'ZAD0396', 'Gleason Jiménez Lina Ruth', 'GEJL610425MJCLMN06', 'GEJL6104258D7', 'lina.gleason@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2013-03-05', '1961-04-25', 17, 11, 7, 2, 3, 'Vigente'),
(67, 'ZAD0727', 'Godínez Ruiz Ángel De Jesús', 'GORA930628HJCDZN07', 'GORA930628NP1', 'angel.godinez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-02-16', '1993-06-28', 18, 9, 5, 2, 3, 'Vigente'),
(68, 'ZAA0433', 'Godoy Villegas Sara', 'GOVS630902MJCDLR06', 'GOVS6309021G6', 'sara.villegas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2012-09-25', '1963-09-02', 16, 18, 9, 2, 3, 'Vigente'),
(69, 'ZAD0694', 'Gómez Gleason José Manuel', 'GOGM890526HJCMLN09', 'GOGM890526NB7', 'manuel.gleason@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2016-02-08', '1989-05-26', 10, 11, 7, 2, 3, 'Vigente'),
(70, 'ZAD0837', 'Gómez Gutiérrez David', 'GOGD831022HJCMTV08', 'GOGD831022G66', 'david.gomez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2022-02-25', '1983-10-22', 16, 13, 3, 1, 3, 'Vigente'),
(71, 'ZAA0776', 'Gómez Pimentel Gonzalo', 'GOPG710109HJCMMN00', 'GOPG710109EG3', 'gonzalo.gomez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-09-01', '1971-01-09', 17, 11, 7, 3, 3, 'Vigente'),
(72, 'ZAA0861', 'Gómez Pimentel Raúl', 'GOPR790822HJCMML08', 'GOPR790822HF8', 'rg011900@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-07-20', '1979-08-22', 28, 18, 9, 1, 3, 'Vigente'),
(73, 'ZAD0341', 'Gómez Ramírez Rodolfo Alejandro', 'GORR460701HDFMMD05', 'GORR460701TV6', 'rodolfo.gomez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-08-25', '1946-07-01', 27, 14, 10, 2, 3, 'Vigente'),
(74, 'ZAA0033', 'Gómez Rodríguez Rosa María', 'GORR580912MJCMDS08', 'GORR580912F2A', 'mvzrosamaria@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2000-02-16', '1958-09-12', 18, 7, 13, 3, 4, 'Vigente'),
(75, 'ZAA0685', 'González Ávila Luis Cesar', 'GOAL840830HGRNVS04', 'GOAL8408309B1', 'luiscesar.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2016-01-16', '1984-08-30', 2, 20, 12, 2, 3, 'Vigente'),
(76, 'ZAD0141', 'González De La Torre Jesús Francisco', 'GOTJ691020HJCNRS04', 'GOTJ691020UW1', 'jesus.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2003-03-16', '1969-10-20', 21, 20, 12, 2, 3, 'Vigente'),
(77, 'ZAD0288', 'González Gómez Luis Cesar', 'GOGL590827HGRNMS02', 'GOGL590827PP5', 'luis.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2007-02-12', '1959-08-27', 16, 11, 7, 2, 5, 'Vigente'),
(78, 'ZAD0234', 'González Isita Rosalía Virginia', 'GOIR650703MDFNSS01', 'GOIR650703B18', 'rosalia.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2005-01-10', '1965-07-03', 19, 11, 7, 3, 3, 'Vigente'),
(79, 'ZAD0722', 'González Montes Hugo Miguel', 'GOMH741002HJCNNG04', 'GOMH741002AH6', 'hugo.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-08-16', '1974-10-02', 17, 13, 3, 3, 3, 'Vigente'),
(80, 'ZAD0224', 'González Pérez José Gerardo', 'GOPG580316HDFNRR02', 'GOPG580316AP7', 'jose.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2004-08-26', '1958-03-16', 18, 14, 10, 2, 3, 'Vigente'),
(81, 'ZAD0825', 'González Pérez Martha Alicia', 'GOPM650106MJCNRR05', 'GOPM6501066P2', 'alicia.perez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2020-03-09', '1965-01-06', 12, 1, 13, 1, 4, 'Vigente'),
(82, 'ZAA0430', 'González Plascencia Daria Gabina', 'GOPD770729MJCNLR05', 'GOPD770729S54', 'gabi.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2012-09-17', '1977-07-29', 24, 20, 12, 2, 3, 'Vigente'),
(83, 'ZAA0527', 'González Plascencia Gilberto Damián', 'GOPG760203HJCNLL03', 'GOPG760203N40', 'gilberto.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-11-01', '1976-02-03', 27, 18, 9, 2, 3, 'Vigente'),
(84, 'ZAD0423', 'González Rodríguez Guillermo Isaac', 'GORG840610HJCNDL08', 'GORG8406106P8', 'guillermo.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2012-08-23', '1984-06-10', 16, 8, 4, 2, 3, 'Vigente'),
(85, 'ZAA0443', 'González Rubio Felipe Guillermo', 'GORF721017HJCNBL02', 'GORF721017EH5', 'felipe.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-01-16', '1972-10-17', 18, 18, 9, 2, 3, 'Vigente'),
(86, 'ZAA0014', 'González Sánchez Martha', 'GOSM690924MJCNNR05', 'GOSM6909248K3', 'martha.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '1999-08-23', '1969-09-24', 5, 12, 8, 3, 3, 'Vigente'),
(87, 'ZAD0497', 'González Soto Gerardo', 'GOSG690619HJCNTR05', 'GOSG69061967A', 'gerardo.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-08-19', '1969-06-19', 16, 11, 7, 3, 3, 'Vigente'),
(88, 'ZAD0831', 'González Torres Fabián', 'GOTF870309HJCNRB04', 'GUAE731120QD9', 'fabian.gonzalez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2021-03-16', '1987-03-09', 16, 13, 3, 1, 3, 'Vigente'),
(89, 'ZAD0604', 'Guerrero Arcos Elías', 'GUAE731120HPLRRL06', 'GUAE731120QD9', 'elias.guerrero@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2011-08-22', '1973-11-20', 16, 9, 13, 1, 4, 'Vigente'),
(90, 'ZAD0854', 'Guillen Fernández Omar', 'GUFO920615HVZLRM08', 'GUFO920615UQ9', 'omar.guillen@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-03-06', '1992-06-15', 12, 10, 6, 3, 3, 'Vigente'),
(91, 'ZAD0251', 'Guinzberg Belmont Jacobo', 'GUBJ630604HDFNLC07', 'GUBJ6306043TA', 'jacobo.guinzberg@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2016-02-08', '1963-06-04', 16, 9, 5, 2, 3, 'Vigente'),
(92, 'ZAD0862', 'Gutiérrez Sandoval Jesús', 'GUSJ931018HJCTNS07', 'GUSJ931018D26', 'jesus.gutierrez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-08-14', '1993-10-18', 18, 13, 3, 1, 3, 'Vigente'),
(93, 'ZAD0570', 'Guzmán Arias Cesar Rafael', 'GUAC700111HJCZRS07', 'GUAC700111LC4', 'cesar.guzman@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-04-01', '1970-01-11', 16, 9, 5, 2, 3, 'Vigente'),
(94, 'ZAD0335', 'Guzmán Ávila Juan Manuel', 'GUAJ551015HJCZVN00', 'GUAJ551015EP9', 'juan.guzman@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-04-14', '1955-10-15', 19, 14, 10, 3, 3, 'Vigente'),
(95, 'ZAA0462', 'Guzmán Eusebio María Concepción', 'GUEC610307MJCZSN02', 'GUEC610307CV5', 'maria.guzman@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2013-04-16', '1961-03-07', 17, 5, 2, 3, 3, 'Vigente'),
(96, 'ZAD0308', 'Guzmán Miramontes Eva', 'GUME690923MJCZRV07', 'GUME690923UC6', 'eva.guzman@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2007-08-20', '1969-09-23', 3, 12, 8, 3, 3, 'Vigente'),
(97, 'ZAD0643', 'Guzmán Ulloa Ma. Angélica', 'GUUA760803MJCZLN04', 'GUUA760803AV1', 'angelica.guzman@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2015-04-16', '1976-08-03', 18, 20, 11, 1, 3, 'Vigente'),
(98, 'ZAD0824', 'Hernández Avalos Alberto', 'HEAA800122HJCRVL03', 'HEAA800122V79', 'aavalos@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2006-02-13', '1980-01-22', 22, 11, 7, 2, 3, 'Vigente'),
(99, 'ZAD0390', 'Hernández Borbón Ricardo', 'HEBR800324HJCRRC00', 'HEBR800324EN7', 'ricardo.hernandez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-08-24', '1980-03-24', 19, 11, 7, 2, 3, 'Vigente'),
(100, 'ZAD0743', 'Hernández Casas Elizabeth', 'HECE880827MJCRSL07', 'HECE880827V19', 'elizabeth.hernandez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2017-02-16', '1988-08-27', 19, 9, 5, 3, 3, 'Vigente'),
(101, 'ZAD0397', 'Hernández López Conrado', 'HELC840420HJCRPN08', 'HELC840420EN2', 'conrado.hernandez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2010-04-26', '1984-04-20', 16, 13, 3, 2, 3, 'Vigente'),
(102, 'ZAA0478', 'Hernández López Gabriela Guadalupe', 'HELG670303MJCRPB07', 'HELG670303NCA', 'gabriela.hernandez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2018-12-06', '1967-03-03', 19, 17, 13, 1, 3, 'Vigente'),
(103, 'ZAD0551', 'Herrera Castañeda Andrea Carolina', 'HECA900908MJCRSN01', 'HECA900908MW4', 'andrea.herrera@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2014-02-16', '1990-09-08', 11, 8, 4, 2, 3, 'Vigente'),
(104, 'ZAD0850', 'Higareda Arce Alan Eduardo', 'HIAA900619HJCGRL09', 'HIAA9006199U8', 'alan.higareda@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-01-23', '1990-06-19', 18, 8, 4, 2, 3, 'Vigente'),
(105, 'ZAD0487', 'Hopkins Zatarain Lara Elayne', 'HOZL800725MJCPTR09', 'HOZL800725NE7', 'lara.hopkins@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2013-08-19', '1980-07-25', 16, 14, 10, 2, 3, 'Vigente'),
(106, 'ZAD0560', 'Huerta González Christopher', 'HUGC901121HJCRNH09', 'HUGC90112142A', 'christopher.huerta@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-03-01', '1990-11-21', 16, 12, 8, 3, 3, 'Vigente'),
(107, 'ZAD0628', 'Hurtado Leal Fidel Alonso', 'HULF880302HJCRLD05', 'HULF880302LJ6', 'fidel.hurtado@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2015-02-16', '1988-03-02', 16, 12, 8, 2, 3, 'Vigente'),
(108, 'ZAD0153', 'Ibáñez De La Torre Sonia Erika', 'IATS760708MJCBRN09', 'IATS760708AX8', 'sonia.ibanez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2003-08-18', '1976-07-08', 16, 13, 3, 2, 3, 'Vigente'),
(109, 'ZAD0389', 'Ibarra Montalvo José De Jesús', 'IAMJ770314HJCBNS06', 'IAMJ7703144Q2', 'jose.ibarra@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-08-24', '1977-03-14', 17, 11, 7, 3, 3, 'Vigente'),
(110, 'ZAD0584', 'Iñiguez Velázquez Fernando', 'IIVF600530HMSXLR02', 'IIVF600530LW8', 'fernando.iniguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2018-12-06', '1960-05-30', 19, 11, 13, 1, 4, 'Vigente'),
(111, 'ZAD0586', 'Jáuregui Núñez José Francisco', 'JANF670212HJCRXR09', 'JANF670212R95', 'jose.jauregui@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-09-01', '1967-02-12', 12, 12, 8, 1, 3, 'Vigente'),
(112, 'ZAD0384', 'Jazo Hernández María Lizbeth', 'JAHL840830MJCZRZ08', 'JAHL8408302D5', 'lizbeth.jazo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2009-08-24', '1984-08-30', 16, 13, 3, 2, 3, 'Vigente'),
(113, 'ZAD0673', 'Jiménez Amezcua Rosa María', 'JIAR610307MJCMMS03', 'JIAR610307AU3', 'rosa.jimenez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2015-09-16', '1961-03-07', 17, 14, 10, 2, 3, 'Vigente'),
(114, 'ZAD0804', 'Lema Pasantes Wenceslao Salvador', 'LEPW580315HDFMSN17', 'LEPW5803155C6', 'wenceslao.lema@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2011-09-01', '1958-03-15', 18, 8, 4, 2, 3, 'Vigente'),
(115, 'ZAD0594', 'Lemus Rolon Juan Carlos', 'LERJ621127HJCMLN01', 'LERJ621127ILA', 'juan.lemus@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-09-01', '1962-11-27', 16, 12, 8, 2, 3, 'Vigente'),
(116, 'ZAD0600', 'Lomelí Mayoral Hiram', 'LOMH850130HBSMYR01', 'LOMH850130EM6', 'hiram.lomeli@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-09-01', '1985-01-30', 16, 12, 8, 2, 3, 'Vigente'),
(117, 'ZAD0236', 'López Cuenca Susana', 'LOCS780307MJCPNS02', 'LOCS780307MF1', 'susana.lopez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2005-02-14', '1978-03-07', 19, 9, 5, 2, 3, 'Vigente'),
(118, 'ZAA0808', 'López González Alicia Euridice', 'LOGA600218MJCPNL07', 'LOGA600218HN7', 'alicia.lopez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2019-01-16', '1960-02-18', 21, 18, 9, 2, 3, 'Vigente'),
(119, 'ZAD0307', 'López Huezo Ana Fabiola', 'LOHA780725MJCPZN07', 'LOHA780725U11', 'fabiola.lopez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2007-06-18', '1978-07-25', 16, 13, 3, 3, 3, 'Vigente'),
(120, 'ZAD0867', 'López Meyer Paulo', 'LOMP781216HSLPIL09', 'LOMP7812169E0', 'paulo.lopez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-09-06', '1978-12-16', 16, 13, 3, 1, 3, 'Vigente'),
(121, 'ZAD0759', 'López Morales Luis Enrique', 'LOML591031HJCPRS02', 'LOML5910317C8', 'luis.lopez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-08-16', '1959-10-31', 16, 9, 5, 2, 3, 'Vigente'),
(122, 'ZAD0244', 'López Ureta Luz Cecilia', 'LOUL710802MJCPRZ16', 'LOUL710802127', 'luzcecilia@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2005-02-24', '1971-08-02', 18, 11, 7, 3, 3, 'Vigente'),
(123, 'ZAD0474', 'Macías Becerra José Ricardo', 'MABR700607HJCCCC06', 'MABR700607NGA', 'ricardo.macias@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-07-04', '1970-06-07', 21, 4, 13, 1, 3, 'Vigente'),
(124, 'ZAD0379', 'Macías Galindo Luis Roberto', 'MAGL661116HCLCLS07', 'MAGL661116C15', 'luis.macias@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-08-24', '1966-11-16', 19, 14, 10, 2, 3, 'Vigente'),
(125, 'ZAA0558', 'Maldonado Anceno Christian', 'MAAC880506HJCLNH00', 'MAAC880506SJ6', 'christian.maldonado@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-03-01', '1988-05-06', 19, 16, 1, 2, 3, 'Vigente'),
(126, 'ZAD0573', 'Mares Sánchez José De Jesús', 'MASJ640707HJCRNS09', 'MASJ640707EU2', 'jose.mares@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-04-16', '1964-07-07', 2, 11, 7, 3, 3, 'Vigente'),
(127, 'ZAD0677', 'Martínez Esparza José Ramón', 'MAER770630HJCRSM02', 'MAER7706304M1', 'jose.martinez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2015-10-01', '1977-06-30', 16, 9, 5, 2, 3, 'Vigente'),
(128, 'ZAD0721', 'Martínez Jurado Nicolás', 'MAJN650823HGTRRC05', 'MAJN650823UG1', 'nicolas.martinez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-01-01', '1965-08-23', 16, 14, 10, 2, 3, 'Vigente'),
(129, 'ZAA0563', 'Martínez Naranjo Rafael', 'MANR880926HJCRRF09', 'MANR880926PIA', 'rafael.martinez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-03-01', '1988-09-26', 18, 20, 12, 3, 3, 'Vigente'),
(130, 'ZAD0793', 'Martínez Padilla José Guadalupe', 'MAPG610512HJCRDD06', 'MAPG610512S87', 'jose.padilla@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2018-02-01', '1961-05-12', 7, 14, 10, 2, 3, 'Vigente'),
(131, 'ZAD0868', 'Maya Ordoñez Felipe Missael', 'MAOF810525HDFIRL07', 'MAOF810525HP4', 'felipe.maya@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-09-06', '1981-05-25', 14, 18, 3, 1, 3, 'Vigente'),
(132, 'ZAA0827', 'Medina Galaviz Ramón', 'MEGR620828HJCDLM04', 'MEGR6208289E8', 'ramon.medina@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-05-02', '1962-08-28', 16, 18, 9, 2, 3, 'Vigente'),
(133, 'ZAA0053', 'Megia Delgadillo Evelia', 'MEDE700420MJCGLV05', 'MEDE700420738', 'evelia.megia@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2001-01-16', '1970-04-20', 28, 10, 9, 2, 3, 'Vigente'),
(134, 'ZAD0027', 'Mendoza Ruiz Oscar', 'MERO721223HDFNZS05', 'MERO721223N92', 'oscar.mendoza@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '1999-08-23', '1972-12-23', 10, 12, 6, 3, 3, 'Vigente'),
(135, 'ZAD0544', 'Meza Camarena Ruth', 'MECR630514MJCZMT01', 'MECR630514SPA', 'ruth.meza@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2014-02-16', '1963-05-14', 17, 11, 8, 3, 3, 'Vigente'),
(136, 'ZAD0281', 'Meza Morales María Isabel', 'MEMI621220MVZZRS05', 'MEMI621220MG5', 'maria.meza@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2006-08-21', '1962-12-20', 16, 18, 7, 3, 3, 'Vigente'),
(137, 'ZAA0456', 'Meza Velasco Jaime Humberto', 'MEVJ610213HJCZLM02', 'MEVJ6102136R5', 'jaime.meza@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-04-16', '1961-02-13', 17, 12, 9, 3, 3, 'Vigente'),
(138, 'ZAD0794', 'Montañez Uribe Ángeles Del Rocío', 'MOUA831225MJCNRN06', 'MOUA8312252Y6', 'angeles.rocio@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2018-02-01', '1983-12-25', 10, 12, 8, 3, 3, 'Vigente'),
(139, 'ZAD0863', 'Moya Sánchez Eduardo Ulises', 'MOSE820128HJCYND07', 'MOSE820128E33', 'eduardo.moya@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-08-14', '1982-01-28', 16, 13, 3, 1, 3, 'Vigente');
INSERT INTO `usuario` (`usuario_id`, `usuario_nomina`, `usuario_nombre`, `usuario_curp`, `usuario_rfc`, `usuario_email`, `usuario_password`, `usuario_foto`, `usuario_genero`, `usuario_fechaIngreso`, `usuario_fechaCumpleaños`, `puesto_id`, `areaAdscripcion_id`, `jefeInmediato_id`, `sindicato_id`, `rol_id`, `usuario_estatus`) VALUES
INSERT INTO `usuario` (`usuario_id`, `usuario_nomina`, `usuario_nombre`, `usuario_curp`, `usuario_rfc`, `usuario_email`, `usuario_password`, `usuario_foto`, `usuario_genero`, `usuario_fechaIngreso`, `usuario_fechaCumpleaños`, `puesto_id`, `areaAdscripcion_id`, `jefeInmediato_id`, `sindicato_id`, `rol_id`, `usuario_estatus`) VALUES
(141, 'ZAA0738', 'Muñoz Velazco Mayra Guadalupe', 'MUVM740518MJCXLY08', 'MUVM740518T46', 'mayra.munoz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2017-02-16', '1974-05-18', 11, 14, 1, 3, 1, 'Vigente'),
(142, 'ZAD0769', 'Nájera Martínez Rodolfo', 'NAMR670724HJCJRD09', 'NAMR670724A81', 'rodolfo.najera@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-08-16', '1967-07-24', 24, 12, 10, 2, 3, 'Vigente'),
(143, 'ZAD0011', 'Núñez Vera Gildardo', 'NUVG730904HJCXRL09', 'NUVG730904CG0', 'gildardo@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '1999-06-01', '1973-09-04', 16, 12, 8, 1, 3, 'Vigente'),
(144, 'ZAA0365', 'Ochoa Suarez Rubén', 'OOSR530828HJCCRB06', 'OOSR5308286J2', 'ruben.ochoa@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-02-03', '1953-08-28', 16, 5, 9, 2, 3, 'Vigente'),
(145, 'ZAA0645', 'Ojeda Peña Viridiana', 'OEPV821020MGRJXR05', 'OEPV821020SJ2', 'viridiana.ojeda@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2015-05-01', '1982-10-20', 4, 9, 2, 2, 3, 'Vigente'),
(146, 'ZAD0683', 'Olivares Aguilar Edgar Abduwal', 'OIAE770805HJCLGD03', 'OIAE770805JX8', 'edgar.olivares@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2015-11-01', '1977-08-05', 26, 10, 5, 2, 3, 'Vigente'),
(147, 'ZAD0159', 'Olvera Chávez Oscar Raymundo', 'OECO620315HDFLHS00', 'OECO620315UH7', 'oscar.olvera@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2003-08-18', '1962-03-15', 18, 18, 6, 3, 3, 'Vigente'),
(148, 'ZAA0702', 'Ortega Escobar Antonio', 'OEEA620609HMCRSN04', 'OEEA620609LY1', 'antonio.ortega@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2016-03-01', '1962-06-09', 18, 18, 9, 2, 3, 'Vigente'),
(149, 'ZAA0873', 'Ortega Martínez María Luisa', 'OEML830408MJCRRS08', 'OEML830408TM1', 'maria.ortega@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2023-09-26', '1983-04-08', 6, 8, 9, 2, 3, 'Vigente'),
(150, 'ZAD0557', 'Ortiz Vargas Gilberto', 'OIVG570124HJCRRL08', 'OIVG570124D31', 'gilberto.ortiz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-03-01', '1957-01-24', 10, 12, 4, 3, 3, 'Vigente'),
(151, 'ZAD0087', 'Otero St Hill Rafael', 'OESR590517HDFTTF01', 'OESR5905173L8', 'rafael.otero@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2001-05-01', '1959-05-17', 16, 20, 8, 2, 3, 'Vigente'),
(152, 'ZAA0755', 'Pacheco Medrano Dinora Alejandra', 'PAMD720727MJCCDN09', 'PAMD720727GM8', 'dinora.pacheco@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2017-05-16', '1972-07-27', 20, 14, 11, 3, 3, 'Vigente'),
(153, 'ZAA0816', 'Palomino García Priscilla Estephania', 'PAGP990729MJCLRR03', 'PAGP9907292G4', 'priscilla.palomino@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2019-02-16', '1999-07-29', 15, 18, 10, 2, 3, 'Vigente'),
(154, 'ZAA0817', 'Partida Martínez Cuauhtémoc', 'PAMC711227HJCRRH16', 'PAMC711227297', 'cuahutemoc.partida@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2019-06-01', '1971-12-27', 24, 11, 9, 2, 3, 'Vigente'),
(155, 'ZAD0275', 'Pérez Castillo Guillermo', 'PECG630810HBCRSL07', 'PECG630810IT2', 'guillermo.perez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2006-08-21', '1963-08-10', 14, 9, 7, 2, 3, 'Vigente'),
(156, 'ZAD0541', 'Pérez Lete Gutiérrez Manuel', 'PEGM611215HJCRTN02', 'PEGM611215BR3', 'manuel.perezlete@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-02-16', '1961-12-15', 16, 9, 5, 2, 3, 'Vigente'),
(157, 'ZAD0099', 'Pérez López José Francisco Jafet', 'PELF730528HJCRPR00', 'PELF730528CJ2', 'jafet.perez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2002-08-16', '1973-05-28', 19, 13, 3, 3, 3, 'Vigente'),
(158, 'ZAD0340', 'Plascencia García Arturo Francisco', 'PAGA650920HJCLRR06', 'PAGA650920FU2', 'arturo.plascencia@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-08-25', '1965-09-20', 19, 12, 10, 2, 3, 'Vigente'),
(159, 'ZAD0255', 'Ramírez Cedillo Leonardo', 'RACL670523HDFMDN04', 'RACL670523A80', 'leonardo.ramirez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2005-09-13', '1967-05-23', 19, 12, 8, 2, 3, 'Vigente'),
(160, 'ZAD0297', 'Ramírez García Carlos Alberto', 'RAGC700628HJCMRR07', 'RAGC7006282K1', 'carlos.ramirez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2007-02-19', '1970-06-28', 17, 11, 3, 2, 3, 'Vigente'),
(161, 'ZAD0494', 'Ramírez García Eduardo Javier', 'RAGE640309HDFMRD02', 'RAGE640309TA6', 'eduardo.ramirez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-08-16', '1964-03-09', 17, 12, 7, 2, 3, 'Vigente'),
(162, 'ZAD0056', 'Ramírez Sánchez José De Jesús', 'RASJ660820HMNMNS00', 'RASJ660820EN2', 'jesus.ramirez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2001-02-01', '1966-08-20', 16, 12, 8, 3, 3, 'Vigente'),
(163, 'ZAD0114', 'Ramírez Soto Yunnuen', 'RASY730106MVZMTN00', 'RASY730106C46', 'yunnuen.ramirez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2002-08-16', '1973-01-06', 17, 3, 3, 3, 3, 'Vigente'),
(164, 'ZAD0347', 'Ramos Corchado León Miguel', 'RACL850214HDFMRN06', 'RACL8502146E6', 'leon.ramos@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-08-25', '1985-02-14', 17, 6, 3, 3, 3, 'Vigente'),
(165, 'ZAD0781', 'Ramos Osuna Cinthia Lizzeth', 'RAOC751204MCLMSN02', 'RAOC751204B22', 'cinthia.ramos@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2004-09-01', '1975-12-04', 8, 21, 13, 1, 2, 'Vigente'),
(166, 'ZAD0401', 'Randeles Gómez Alma Luz', 'RAGA730616MDGNML04', 'RAGA730616J18', 'alma.randeles@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2010-08-23', '1973-06-16', 19, 14, 10, 2, 3, 'Vigente'),
(167, 'ZAA0840', 'Rangel Bernave Verónica', 'RABV720804MJCNRR00', 'RABV720804RB3', 'veronica.rangel@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2017-06-01', '1972-08-04', 19, 19, 2, 3, 3, 'Vigente'),
(168, 'ZAA0779', 'Reséndiz González Dayam Guadalupe', 'REGD951009MJCSNY00', 'REGD951009UP8', 'dayam.resendiz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2017-09-01', '1995-10-09', 4, 19, 13, 2, 3, 'Vigente'),
(169, 'ZAD0112', 'Reyes Gómez Quinatzin', 'REGQ730504HDFYMN00', 'REGQ730504SB1', 'quinatzin.reyes@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2002-08-16', '1973-05-04', 4, 8, 3, 1, 3, 'Vigente'),
(170, 'ZAD0366', 'Reyes López Belén María Guadalupe', 'RELB831212MJCYPL01', 'RELB831212BJ6', 'belen.reyes@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2009-02-16', '1983-12-12', 20, 11, 4, 2, 3, 'Vigente'),
(171, 'ZAD0326', 'Reyes Morales Jesús', 'REMJ691225HYNYRS08', 'REMJ6912258H2', 'jesus.reyes@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-02-18', '1969-12-25', 19, 10, 7, 2, 3, 'Vigente'),
(172, 'ZAA0331', 'Rincón Peña Rene Ricardo', 'RIPR860515HJCNXN03', 'RIPR8605154I6', 'rene.rincon@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-03-03', '1986-05-15', 17, 8, 6, 3, 3, 'Vigente'),
(173, 'ZAD0699', 'Ríos Martínez Juan', 'RIMJ681025HJCSRN01', 'RIMJ681025F84', 'juan.rios@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2016-03-01', '1968-10-25', 14, 11, 4, 2, 3, 'Vigente'),
(174, 'ZAA0177', 'Rivera Quintero Gerardo', 'RIQG590911HJCVNR06', 'RIQG5909116D4', 'gerardo.rivera@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2003-10-10', '1959-09-11', 19, 18, 7, 3, 3, 'Vigente'),
(175, 'ZAA0841', 'Robles Rivera José Manuel', 'RORM730625HJCBVN02', 'RORM7306255A6', 'jose.robles@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2022-09-16', '1973-06-25', 14, 15, 9, 3, 3, 'Vigente'),
(176, 'ZAD0113', 'Rodríguez Ávila Héctor', 'ROAH680519HJCDVC02', 'ROAH680519EG3', 'hector.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2002-08-16', '1968-05-19', 28, 10, 13, 1, 3, 'Vigente'),
(177, 'ZAD0161', 'Rodríguez Flores German', 'ROFG781029HJCDLR02', 'ROFG781029SY5', 'german.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2003-08-18', '1978-10-29', 12, 11, 6, 3, 3, 'Vigente'),
(178, 'ZAD0242', 'Rodríguez Llamas Hugo Alejandro', 'ROLH651125HDFDLG09', 'ROLH651125AS8', 'hugo.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2005-02-14', '1965-11-25', 18, 18, 7, 2, 3, 'Vigente'),
(179, 'ZAA0638', 'Rodríguez López María Virginia', 'ROLV720105MJCDPR01', 'ROLV720105GA9', 'maria.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2015-03-16', '1972-01-05', 10, 18, 9, 3, 3, 'Vigente'),
(180, 'ZAD0496', 'Rodríguez Montes Armando', 'ROMA771004HJCDNR00', 'ROMA771004Q62', 'armando.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-08-19', '1977-10-04', 16, 13, 3, 1, 3, 'Vigente'),
(181, 'ZAD0661', 'Rodríguez Palacios Mauricio Alfredo', 'ROPM720227HJCDLR02', 'ROPM720227G22', 'mauricio.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2015-09-01', '1972-02-27', 18, 12, 8, 3, 3, 'Vigente'),
(182, 'ZAD0654', 'Rodríguez Sahagún Raquel', 'ROSR611221MJCDHQ02', 'ROSR611221R69', 'raquel.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2015-07-01', '1961-12-21', 18, 14, 8, 2, 3, 'Vigente'),
(183, 'ZAD0572', 'Rodríguez Téllez Víctor', 'ROTV800626HPLDLC00', 'ROTV800626VA1', 'victor.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-04-01', '1980-06-26', 16, 11, 10, 2, 3, 'Vigente'),
(184, 'ZAD0374', 'Rodríguez Zamora Uriel', 'ROZU660519HVZDMR09', 'ROZU660519T30', 'uriel.rodriguez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-03-02', '1966-05-19', 16, 8, 7, 2, 3, 'Vigente'),
(185, 'ZAD0696', 'Rubio Gutiérrez Ivette', 'RUGI910105MJCBTV06', 'RUGI9101055D6', 'ivette.rubio@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2016-03-01', '1991-01-05', 16, 18, 4, 1, 3, 'Vigente'),
(186, 'ZAA0659', 'Ruiz Becerra Edgar Rodolfo', 'RUBE820119HJCZCD05', 'RUBE8201191P1', 'edgar.ruiz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2018-12-06', '1982-01-19', 11, 17, 1, 1, 3, 'Vigente'),
(187, 'ZAD0399', 'Ruiz Monroy Nancy', 'RUMN860205MJCZNN11', 'RUMN860205578', 'nancy.ruiz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', '', 'M', '2010-04-26', '1986-02-05', 11, 13, 13, 1, 4, 'Vigente'),
(188, 'ZAA0185', 'Ruiz Reyes J. Jesús', 'RURJ660416HJCZYS08', 'RURJ660416H95', 'jesus.ruiz@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2004-02-16', '1966-04-16', 12, 18, 13, 1, 4, 'Vigente'),
(189, 'ZAA0800', 'Sánchez Mejía Sandra Karina', 'SAMS710224MJCNJN01', 'SAMS710224J55', 'sandra.sanchez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2018-07-16', '1971-02-24', 11, 9, 9, 2, 3, 'Vigente'),
(190, 'ZAD0709', 'Sánchez Padilla Rubén Antonio', 'SAPR810813HDFNDB05', 'SAPR810813L80', 'ruben.sanchez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2016-08-16', '1981-08-13', 20, 9, 5, 2, 3, 'Vigente'),
(191, 'ZAD0349', 'Sánchez Rangel Edgar Ignacio', 'SARE700201HDFNND08', 'SARE700201727', 'edgar.sanchez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-08-25', '1970-02-01', 18, 14, 5, 2, 3, 'Vigente'),
(192, 'ZAD0310', 'Sánchez Robles Raúl', 'SARR620701HBCNBL07', 'SARR6207011D2', 'raul.sanchez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2007-08-20', '1962-07-01', 17, 14, 10, 2, 3, 'Vigente'),
(193, 'ZAD0569', 'Sánchez Sánchez Francisco Ariel', 'SASF610106HJCNNR05', 'SASF610106SY6', 'francisco.sanchez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2014-03-16', '1961-01-06', 19, 11, 10, 2, 3, 'Vigente'),
(194, 'ZAD0337', 'Santana Colin Carlos Tomas', 'SACC810427HVZNLR05', 'SACC810427GG8', 'carlos.santana@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-04-16', '1981-04-27', 10, 18, 7, 2, 3, 'Vigente'),
(195, 'ZAA0303', 'Santos Jiménez Antonio', 'SAJA770613HJCNMN09', 'SAJA770613SK6', 'antonio.santos@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-10-01', '1977-06-13', 17, 14, 9, 1, 3, 'Vigente'),
(196, 'ZAD0344', 'Silva Refulio Edgar Javier', 'SIRE631126HNELFD09', 'SIRE631126671', 'edgar.silva@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-08-25', '1963-11-26', 3, 10, 10, 3, 3, 'Vigente'),
(197, 'ZAD0172', 'Sosa Beltrán Jesús Ramón', 'SOBJ770105HSLSLS06', 'SOBJ770105AU7', 'jesus.sosa@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2003-09-01', '1977-01-05', 21, 9, 6, 3, 3, 'Vigente'),
(198, 'ZAD0728', 'Tapia Paredes Martha Gabriela', 'TAPM900502MJCPRR08', 'TAPM9005025B5', 'gabriela.tapia@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2017-02-16', '1990-05-02', 17, 11, 5, 2, 3, 'Vigente'),
(199, 'ZAD0313', 'Tavera Cruz María De Jesús', 'TACR621216MJCVRS05', 'TACJ621216T64', 'maria.tavera@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2011-08-29', '1962-12-16', 16, 12, 7, 3, 3, 'Vigente'),
(200, 'ZAD0100', 'Téllez Pareja Fernando José', 'TEPF570419HMCLRR02', 'TEPF5704191U7', 'fernando.tellez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2002-08-16', '1957-04-19', 16, 12, 8, 2, 3, 'Vigente'),
(201, 'ZAD0827', 'Torres Corona Enrique', 'TOCE730522HJCRRN01', 'TOCE730522L57', 'enrique.torres@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-08-03', '1973-05-22', 17, 12, 8, 2, 3, 'Vigente'),
(202, 'ZAD0215', 'Toscano Barajas Irma', 'TOBI720105MJCSRR07', 'TOBI720105KA1', 'irma.toscano@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2004-08-23', '1972-01-05', 17, 13, 3, 3, 3, 'Vigente'),
(203, 'ZAD0291', 'Tovar Arriaga Adriana', 'TOAA760103MQTVRD05', 'TOAA760103BH4', 'adriana.tovar@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2007-02-12', '1976-01-03', 19, 12, 3, 3, 3, 'Vigente'),
(204, 'ZAD0226', 'Tovar Vergara Myrna', 'TOVM691229MJCVRY09', 'TOVM691229M93', 'myrna.tovar@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2004-09-03', '1969-12-29', 16, 9, 8, 2, 3, 'Vigente'),
(205, 'ZAD0871', 'Vanegas Espinosa Luis Ignacio', 'VAEL900523HJCNSS08', 'VAEL900523KS4', 'luis.vanegas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2023-09-08', '1990-05-23', 16, 3, 5, 1, 3, 'Vigente'),
(206, 'ZAA0446', 'Vargas López Dorian Oswaldo', 'VALD861028HJCRPR00', 'VALD861028HV7', 'dorian.vargas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-03-10', '1986-10-28', 16, 11, 13, 2, 3, 'Vigente'),
(207, 'ZAD0822', 'Vásquez Hernández Gabriel Israel', 'VAHG890529HOCSRB04', 'VAHG890529RM1', 'gabriel.vazquez@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2019-08-19', '1989-05-29', 16, 8, 7, 3, 3, 'Vigente'),
(208, 'ZAD0523', 'Vega Camacho Rebeca', 'VECR791210MSLGMB09', 'VECR7912103T8', 'rebeca.vega@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2013-10-21', '1979-12-10', 24, 11, 4, 2, 3, 'Vigente'),
(209, 'ZAD0323', 'Vega Martínez Felipe', 'VEMF760823HJCGRL02', 'VEMF760823K63', 'felipe.vega@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-02-18', '1976-08-23', 16, 11, 7, 2, 3, 'Vigente'),
(210, 'ZAD0754', 'Vega Quintero Juan Francisco', 'VEQJ810921HJCGNN04', 'VEQJ810921PY8', 'juan.vega@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2017-05-16', '1981-09-21', 16, 13, 3, 2, 3, 'Vigente'),
(211, 'ZAD0332', 'Venegas Sandoval Roberto', 'VESR730617HJCNNB05', 'VESR730617S63', 'roberto.venegas@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2008-03-05', '1973-06-17', 17, 13, 3, 3, 3, 'Vigente'),
(212, 'ZAD0267', 'Vidrio Mora Elisa', 'VIME710222MJCDRL12', 'VIME7102225I0', 'elisa.vidrio@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2006-03-27', '1971-02-22', 16, 12, 7, 2, 3, 'Vigente'),
(213, 'ZAD0485', 'Villa Cázares Zabdiel', 'VICZ781225HJCLZB02', 'VICZ781225FJ3', 'zabdiel.villa@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2013-08-19', '1978-12-25', 17, 20, 8, 3, 3, 'Vigente'),
(214, 'ZAD0248', 'Villa Dávalos Erika Giovana', 'VIDE760809MJCLVR07', 'VIDE7608093K7', 'erika.villa@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2005-06-01', '1976-08-09', 19, 20, 13, 1, 4, 'Vigente'),
(215, 'ZAD0388', 'Villa Miranda Oscar', 'VIMO680510HJCLRS03', 'VIMO680510PK2', 'oscar.villa@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-08-24', '1968-05-10', 12, 12, 7, 1, 3, 'Vigente'),
(216, 'ZAD0598', 'Villafaña Becerra Ana Isabel', 'VIBA850710MJCLCN05', 'VIBA850710CB8', 'ana.villafana@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'M', '2014-09-01', '1985-07-10', 16, 14, 8, 1, 3, 'Vigente'),
(217, 'ZAD0382', 'Villaseñor Pérez Francisco Javier', 'VIPF800305HJCLRR05', 'VIPF800305QL8', 'francisco.villasenor@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2009-08-24', '1980-03-05', 19, 20, 10, 2, 3, 'Vigente'),
(218, 'ZA19011256', 'Gerry Espinoza Sánchez', '1234567891011121314', '1234567891011121314', 'za19011271@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2024-06-25', '2024-06-25', 9, 13, 3, 2, 3, 'Vigente'),
(219, 'ZA19011256', 'Alan Eduardo Vazquez Mora', '1234567891011121314', '1234567891011121314', 'za14011723@zapopan.tecmm.edu.mx', '$2y$10$CK5GS5k4fpIUrdQDi3PuiOBcScb1kY7ivo50g3nXon2Ruy5biRRD6', NULL, 'H', '2024-06-25', '2024-06-25', 9, 13, 3, 2, 4, 'Vigente'),
(220, '12341234', 'empleado de prueba', 'VAMA960325HJCZRL04', 'VAMA960325BB1', 'prueba@mail.com', '$2y$10$kkE8DX2t0h.hDFeEQwyYy.Lf8pH.1asApSn1/gW0FeQ/7uwNWOWMq', NULL, 'H', '2024-11-22', '2024-11-22', 14, 13, 3, 2, 3, 'Vigente');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;