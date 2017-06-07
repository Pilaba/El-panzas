START TRANSACTION;

DROP DATABASE IF EXISTS carwashBD;
CREATE DATABASE carwashBD DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci;

CREATE TABLE TipoVehiculo(
	tv_idTipo TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	tv_nombre VARCHAR (30) NOT NULL,
	PRIMARY KEY (tv_idTipo)
);


INSERT INTO TipoVehiculo VALUES
	('','Compacto'),
	('','Camioneta'),
	('','Taxi'),
	('','Motocicleta'),
	('','Mini Van'),
	('','Camion'),
	('','Furgoneta'),
	('','Tractocamion'),
	('','Otro');

CREATE TABLE Vehiculo (
	vehi_matricula VARCHAR(8) NOT NULL,
	vehi_id_Tipo TINYINT UNSIGNED NOT NULL,
	PRIMARY KEY (vehi_matricula,vehi_id_Tipo),
	FOREIGN KEY (vehi_id_Tipo) REFERENCES TipoVehiculo(tv_idTipo)
);


CREATE TABLE RolSistema(
	rs_idRol SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	rs_nombreRol VARCHAR(20) NOT NULL,
	PRIMARY KEY (rs_idRol)
);

INSERT INTO RolSistema VALUES (NULL,'Administrador'),
	(NULL,'Cliente');


CREATE TABLE Usuario (
	usu_idUsuario INTEGER unsigned NOT NULL AUTO_INCREMENT,
	usu_idRol SMALLINT unsigned NOT NULL,
	usu_nombre VARCHAR(30) NOT NULL UNIQUE,
	usu_correo VARCHAR(30) UNIQUE,
	usu_contrasena VARCHAR(30) NOT NULL,
	usu_telefono VARCHAR(10),
	PRIMARY KEY (usu_idUsuario),
	FOREIGN KEY(usu_idRol)  REFERENCES RolSistema(rs_idRol)
);



INSERT INTO Usuario VALUES
	(NULL, '1', 'admin', 'pilaba@live.com', 'admin', '312154'),
	(NULL, '2', 'Juan Perez', 'JPerez@hotmail.com', '123', '321312'),
	(NULL, '2', 'Jose Lopez', 'JLopes@gmx.com', '321', '312321');



CREATE TABLE Vehiculo_Usuario(
	VU_idUsuario INTEGER UNSIGNED NOT NULL,
	VU_matricula VARCHAR(8) NOT NULL,
	PRIMARY KEY (VU_idUsuario,VU_matricula),
	FOREIGN KEY (VU_idUsuario) REFERENCES Usuario(usu_idUsuario),
	FOREIGN KEY (VU_matricula) REFERENCES Vehiculo(vehi_matricula)
);

#HERE IS OK


CREATE TABLE Turnos(
	turno_idTurno CHAR(1) NOT NULL,
	turno_nombre VARCHAR(10) NOT NULL,
	PRIMARY KEY (turno_idTurno)
);

INSERT INTO TURNOS VALUES ('m','Matutino'),
	('v','Vespertino'),
	('d','Diurno');

CREATE TABLE RolEmpleado(
	re_idRol SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	re_nombre VARCHAR(20) NOT NULL,
	PRIMARY KEY (re_idRol)
);

INSERT INTO RolEmpleado VALUES (NULL, 'Franelero'),
	(NULL, 'Pulidor');

CREATE TABLE Empleado(
	emp_idEmpleado SMALLINT unsigned NOT NULL AUTO_INCREMENT,
	emp_nombre VARCHAR(30) NOT NULL,
	emp_correo VARCHAR(30) NOT NULL UNIQUE,
	emp_genero CHAR(1) NOT NULL,
	emp_telefono VARCHAR(10) NOT NULL,
	emp_turno CHAR(1) NOT NULL,
	emp_direccion VARCHAR(50) NOT NULL,
	emp_salario FLOAT NOT NULL,
	emp_estado TINYINT (1) NOT NULL,
	emp_fechaIngreso DATE NOT NULL,
	PRIMARY KEY (emp_idEmpleado),
	FOREIGN KEY (emp_turno) REFERENCES Turnos(turno_idTurno)
);

CREATE  TABLE Empleado_RolEmpleado(
	ER_idEmpleado SMALLINT unsigned NOT NULL,
	ER_idRol SMALLINT UNSIGNED NOT NULL,
	PRIMARY KEY (ER_idEmpleado,ER_idRol),
	FOREIGN KEY (ER_idEmpleado) REFERENCES Empleado (emp_idEmpleado),
	FOREIGN KEY (ER_idRol) REFERENCES RolEmpleado (re_idRol)
);


CREATE TABLE Servicio(
	serv_idServicio INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	serv_nombre VARCHAR(30) UNIQUE NOT NULL,
	serv_precioBase FLOAT UNSIGNED NOT NULL,
	serv_estado TINYINT(1) NOT NULL,
	serv_imagen LONGBLOB,
	serv_mime varchar(40) NOT NULL,
	PRIMARY KEY (serv_idServicio)
);

CREATE TABLE Servicio_Empleado(
	SE_idServicio INTEGER unsigned  NOT NULL,
	SE_idEmpleado SMALLINT unsigned NOT NULL,
	PRIMARY KEY (SE_idServicio, SE_idEmpleado),
	FOREIGN KEY (SE_idServicio) REFERENCES Servicio (serv_idServicio),
	FOREIGN KEY (SE_idEmpleado) REFERENCES Empleado (emp_idEmpleado)
);
CREATE TABLE TipoPaquete(
	tp_idTipo TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	tp_nombre VARCHAR(50) UNIQUE NOT NULL,
	PRIMARY KEY (tp_idTipo)
);

INSERT INTO TipoPaquete VALUES (NULL,'Paquete');

CREATE TABLE Paquete(
	paq_idPaquete INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	paq_fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	paq_importe INTEGER UNSIGNED NOT NULL,
	paq_descuento INTEGER NOT NULL,
	paq_Total INTEGER UNSIGNED,               #TRIGGER
	paq_Estado TINYINT(1) NOT NULL,
	paq_tipo TINYINT(1) UNSIGNED NOT NULL,
	PRIMARY KEY (paq_idPaquete),
	FOREIGN KEY (paq_tipo) REFERENCES TipoPaquete (tp_idTipo)
);

CREATE TABLE Vehiculo_Paquete(
	VP_matricula VARCHAR(8) NOT NULL,
	VP_idPaquete INTEGER UNSIGNED  NOT NULL,
	VP_Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (VP_matricula, VP_idPaquete, VP_Fecha),
	FOREIGN KEY (VP_matricula) REFERENCES Vehiculo (vehi_matricula),
	FOREIGN KEY (VP_idPaquete) REFERENCES Paquete (paq_idPaquete)
);


CREATE TABLE Paquete_Servicio(
	PS_idPaquete INTEGER UNSIGNED NOT NULL,
	PS_idServicio INTEGER UNSIGNED  NOT NULL,
	PRIMARY KEY (PS_idPaquete,PS_idServicio),
	FOREIGN KEY (PS_idPaquete) REFERENCES Paquete (paq_idPaquete),
	FOREIGN KEY (PS_idServicio) REFERENCES Servicio (serv_idServicio)
);


######################################################
DELIMITER //

DROP TRIGGER IF EXISTS TG_calculaTotalIn//
CREATE TRIGGER TG_calculaTotalIn
  BEFORE INSERT
  ON paquete
  FOR EACH ROW
  BEGIN
    SET NEW.paq_Total=NEW.paq_importe-NEW.paq_descuento;
  END//


DROP TRIGGER IF EXISTS TG_calculaTotalUp//
CREATE TRIGGER TG_calculaTotalUp
  BEFORE UPDATE
  ON paquete
  FOR EACH ROW
  BEGIN
    SET NEW.paq_Total=NEW.paq_importe-NEW.paq_descuento;
  END//


DROP PROCEDURE IF EXISTS Pr_DetallePaq_Serv//
CREATE PROCEDURE Pr_DetallePaq_Serv(IN ID_paquete INT, IN ID_servicio INT)
BEGIN
  INSERT INTO paquete_servicio (PS_idPaquete,PS_idServicio) VALUES (ID_paquete,ID_servicio);
END//

DROP PROCEDURE IF EXISTS Pr_DetalleVehi_Usu//
CREATE PROCEDURE Pr_DetalleVehi_Usu (IN id_Usuario INT,IN matricula VARCHAR(8))
BEGIN
	INSERT INTO vehiculo_usuario (VU_idUsuario,VU_matricula) VALUES (id_Usuario,matricula);
END//

DROP PROCEDURE IF EXISTS Pr_DetalleVehi_Usu//
CREATE PROCEDURE Pr_DetalleVehi_Usu (IN id_Usuario INT,IN matricula VARCHAR(8))
BEGIN
	INSERT INTO vehiculo_usuario (VU_idUsuario,VU_matricula) VALUES (id_Usuario,matricula);
END//

DROP PROCEDURE IF EXISTS Pr_DetalleEmp_Rol//
CREATE PROCEDURE Pr_DetalleEmp_Rol(IN ID_emp INT,IN ID_rol VARCHAR(8))
BEGIN
	INSERT INTO Empleado_RolEmpleado (ER_idEmpleado, ER_idRol) VALUES (ID_emp,ID_rol);
END//

DROP PROCEDURE IF EXISTS Pr_DetalleServ_Emp//
CREATE PROCEDURE Pr_DetalleServ_Emp(IN ID_servicio INT,IN ID_empleado INT)
BEGIN
	INSERT INTO Servicio_Empleado (SE_idServicio, SE_idEmpleado) VALUES (ID_servicio,ID_empleado);
END//

DROP PROCEDURE IF EXISTS Pr_DetalleVehi_Paq//
CREATE PROCEDURE Pr_DetalleVehi_Paq(IN Matricula VARCHAR(8),IN ID_paquete INT)
BEGIN
	INSERT INTO Vehiculo_Paquete (VP_matricula, VP_idPaquete) VALUES (Matricula,ID_paquete);
END//

DELIMITER ;
########################################################
COMMIT;
