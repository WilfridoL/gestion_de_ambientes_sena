CREATE TABLE `ambientes` (
  `ambId` int(11) NOT NULL AUTO_INCREMENT,
  `ambNom` varchar(50) NOT NULL,
  `ambCap` int(11) DEFAULT NULL,
  PRIMARY KEY (`ambId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 ;

CREATE TABLE `auth` (
  `autId` int(11) NOT NULL AUTO_INCREMENT,
  `autNom` varchar(20) NOT NULL,
  `autDescAccess` varchar(255) NOT NULL,
  PRIMARY KEY (`autId`)
) ENGINE=InnoDB AUTO_INCREMENT=3;

CREATE TABLE `estados` (
  `idEst` int(11) NOT NULL,
  `estNom` varchar(20) NOT NULL,
  PRIMARY KEY (`idEst`)
) ENGINE=InnoDB;

CREATE TABLE `horarios` (
  `horId` int(11) NOT NULL AUTO_INCREMENT,
  `horNom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`horId`)
) ENGINE=InnoDB AUTO_INCREMENT=5;

CREATE TABLE `jornadas` (
  `jorId` int(11) NOT NULL AUTO_INCREMENT,
  `jorNom` varchar(50) NOT NULL,
  PRIMARY KEY (`jorId`)
) ENGINE=InnoDB AUTO_INCREMENT=5;

CREATE TABLE `usuarios` (
  `usuCed` int(11) NOT NULL,
  `usuNoms` varchar(100) NOT NULL,
  `usuApes` varchar(100) NOT NULL,
  `usuCorr` varchar(250) DEFAULT NULL,
  `usuUltMod` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `usuAuth` int(1) NOT NULL DEFAULT 2,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`usuCed`),
  KEY `usuAuth` (`usuAuth`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`usuAuth`) REFERENCES `auth` (`autId`)
) ENGINE=InnoDB;

CREATE TABLE `solicitud` (
  `ambIdFk` int(11) NOT NULL,
  `horIDFk` int(11) NOT NULL,
  `instIdFk` int(11) NOT NULL,
  `fichaCod` int(11) NOT NULL,
  `solId` varchar(5) NOT NULL,
  `fecha` date NOT NULL,
  `solEst` int(1) NOT NULL DEFAULT 0,
  `fechCre` timestamp NOT NULL DEFAULT current_timestamp(),
  `solUltMod` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`instIdFk`,`solId`),
  KEY `ambIdFk` (`ambIdFk`),
  KEY `horIDFk` (`horIDFk`),
  KEY `solEst` (`solEst`),
  CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`ambIdFk`) REFERENCES `ambientes` (`ambId`),
  CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`horIDFk`) REFERENCES `horarios` (`horId`),
  CONSTRAINT `solicitud_ibfk_4` FOREIGN KEY (`instIdFk`) REFERENCES `usuarios` (`usuCed`),
  CONSTRAINT `solicitud_ibfk_5` FOREIGN KEY (`solEst`) REFERENCES `estados` (`idEst`)
) ENGINE=InnoDB;