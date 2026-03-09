insert  into `ambientes`(`ambId`,`ambNom`,`ambCap`) values 
(1,'ADSO 1',32),
(2,'ADSO 2',30),
(6,'ADMIN',30),
(7,'ADSO 4',20);

insert  into `auth`(`autId`,`autNom`,`autDescAccess`) values 
(1,'Administrador','Acceso a todo el sistema'),
(2,'Instructor','Solo acceso al los apartado de solicitudes de ambientes');

insert  into `estados`(`idEst`,`estNom`) values 
(0,'Pendiente'),
(1,'Aprobado'),
(2,'Cancelado');

insert  into `horarios`(`horId`,`horNom`) values 
(1,'07:00 - 13:00'),
(2,'14:00 - 18:00'),
(3,'19:00 - 21:00'),
(4,'22:00 - 05:00');

insert  into `jornadas`(`jorId`,`jorNom`) values 
(1,'DIURNA'),
(2,'MIXTA'),
(3,'NOCTURNA'),
(4,'MADRUGADA');

insert  into `usuarios`(`usuCed`,`usuNoms`,`usuApes`,`usuCorr`,`usuUltMod`,`usuAuth`, `password`) values 
(5454,'JORGE LUIS','DE LA CRUZ','jdelacruz@soy.sena.edu.co',NULL,2, '$2y$10$wbd/44pyDFs7WytTf54UT.mcijc/dh6c7ASfmKVd8Ia3IJ8SXZAfm'),
(798999,'FRANSISCO','HERNANDEZ','papaFrancisco@gmail.com','2026-02-15 20:03:03',1, '$2y$10$15DNymNzG9DmVGbRrsIUsumFQtH6/hZZQ6fM0oz0QOIXXKAy7Mtkq'),
(4666465,'EDWIN','SUAREZ','edwin30@gmail.com','2026-02-17 22:15:30',2, '$2y$10$JpZYPCyql9ItnUZB7X..I.i7deoboE4imlBlWYu84dS65fD6yi7CW'),
(65646645,'MANUEL ANDRES','PIZARRO ARRIETA','mpizzaron@gmail.com','2026-02-18 07:48:05',2, '$2y$10$yWOTlHN5gi5.GKRogeTuFO9BpCNOdEZEQEHNyjg5h/tiqzfmCPkhG');

insert  into `solicitud`(`ambIdFk`,`horIDFk`,`instIdFk`,`fichaCod`,`solId`,`fecha`,`solEst`,`fechCre`,`solUltMod`) values 
(1,1,798999,89665464,'S0063','2026-02-18',1,'2026-02-16 13:18:57',NULL),
(7,2,798999,123456789,'S1104','2026-02-20',0,'2026-02-18 10:23:07',NULL),
(2,4,798999,6465465,'S6450','2026-02-20',2,'2026-02-16 13:18:57',NULL),
(2,2,798999,89665464,'S7366','2026-02-17',2,'2026-02-16 18:54:21',NULL),
(2,4,798999,494645,'S8960','2026-02-17',2,'2026-02-16 13:18:57','2026-02-18 09:40:13'),
(1,4,4666465,2147483647,'S0264','2026-02-25',1,'2026-02-16 13:18:57',NULL),
(1,1,4666465,89665464,'S6444','2026-02-20',1,'2026-02-16 19:02:23',NULL),
(2,1,4666465,56466464,'S7981','2026-02-16',2,'2026-02-16 13:18:57',NULL),
(2,4,4666465,494645,'S9690','2026-02-19',2,'2026-02-16 19:03:01',NULL),
(7,3,65646645,1234567890,'S3687','2026-02-19',0,'2026-02-18 09:50:27',NULL);
