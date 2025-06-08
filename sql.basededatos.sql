-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.28-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para noticias
DROP DATABASE IF EXISTS `noticias`;
CREATE DATABASE IF NOT EXISTS `noticias` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `noticias`;

-- Volcando estructura para tabla noticias.mensajes
DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remitente_id` int(11) NOT NULL,
  `destinatario_id` int(11) NOT NULL,
  `asunto` varchar(255) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `remitente_id` (`remitente_id`),
  KEY `destinatario_id` (`destinatario_id`),
  CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`remitente_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`destinatario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla noticias.mensajes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla noticias.noticias
DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_publico` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla noticias.noticias: ~3 rows (aproximadamente)
INSERT INTO `noticias` (`id`, `titulo`, `descripcion`, `fecha_publico`, `fecha`) VALUES
	(1, '12', 'Donald Trump ha fijado todos sus objetivos en Groenlandia, un país que parecía ser tan solo hielo en mitad de la nada. Sin embargo, Groenlandia cuenta con muchos recursos como petróleo, gas natural, oro, zinc, cobalto, platino y níquel, que son clave para baterías y microchips. Además, Trump quiere aprovechar el calentamiento global y el deshielo para mejorar sus rutas comerciales[_{{{CITATION{{{_1{Donald Trump y sus intenciones con Groenlandia: quiere usar el país para explotar las materias primas y el comercio internacional](https://www.marca.com/tiramillas/television/2025/01/12/6783c59ce2704efe908b458e.html).', '2025-01-12 12:45:00', '2025-01-12 11:40:00'),
	(2, 'Por qué la condena a Donald Trump no tiene castigo ni prisión', 'Donald Trump ha sido condenado simbólicamente por el juez del Tribunal Supremo del estado de Nueva York, Juan Manuel Merchán, a "libertad incondicional" en el juicio por el soborno a la estrella porno Stormy Daniels. Esta condena no implica penas de prisión ni libertad condicional, permitiendo a Trump asumir la presidencia sin restricciones[_{{{CITATION{{{_2{Por qué la condena a Donald Trump no tiene castigo ni prisión: ¿qué significa y qué pasará ahora?](https://okdiario.com/internacional/que-condena-donald-trump-no-tiene-castigo-ni-prision-que-significa-que-pasara-ahora-14098439).', '2025-01-10 18:05:00', '2025-01-10 17:01:00'),
	(3, 'Donald Trump recibe sentencia por caso Stormy Daniels', 'Donald Trump ha sido declarado culpable en el caso de los pagos irregulares a la exactriz Stormy Daniels. Aunque el juez Juan Merchan decidió no imponerle pena de cárcel ni multas económicas, citando las protecciones legales que Trump posee como presidente electo. Esta decisión genera un precedente único: un mandatario electo asumiendo el cargo bajo el estigma de una condena penal[_{{{CITATION{{{_3{Donald Trump recibe sentencia por caso Stormy Daniels: ¿Por qué no va a la cárcel?](https://www.marca.com/mx/actualidad/sociedad/2025/01/10/6781517f22601dd1548b45a2.html).', '2025-01-10 16:00:00', '2025-01-10 14:57:00');

-- Volcando estructura para tabla noticias.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla noticias.usuarios: ~3 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`, `nivel`, `bloqueado`) VALUES
	(1, 'admin', '$2y$10$vi9aCwZc3d5a4d0wBN1Qoutok0VKn8vvWnyNT88c4OfCS4ke5TB16', 66),
	(2, 'usuario1', '$2y$10$TMfd1pIifkmKZhyGshT0yeQB8v6q6c3Kb4yy9ydaDQf5J7zeatnYW', 99),
	(3, 'usuario2', '$2y$10$4LuaM2Gi.5kdTVUBNIBtGeHc1WhmkJPOhFa/n5GvCmMfG65r0UmGS', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
