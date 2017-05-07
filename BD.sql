START TRANSACTION; #EMPIEZA LA TRANSACCION

DROP DATABASE IF EXISTS carwashBD;
CREATE DATABASE carwashBD DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci;

CREATE TABLE TiposVehiculos(
	id_Tipo TINYINT unsigned NOT NULL AUTO_INCREMENT,
	nombre VARCHAR (30) NOT NULL,
	PRIMARY KEY (id_Tipo)
);

INSERT INTO TiposVehiculos VALUES ('','Taxi'),
                              		('','Compacto'),
                              		('','Camioneta'),
                              		('','Motocicleta'),
                              		('','Furgoneta'),
                              		('','Trailer'),
                              		('','Otro');
CREATE TABLE Vehiculo (
	matricula VARCHAR(8) NOT NULL,
	id_Tipo TINYINT unsigned NOT NULL,
	Marca VARCHAR (20),
	PRIMARY KEY (matricula),
	FOREIGN KEY (id_Tipo) REFERENCES TiposVehiculos(id_Tipo)
);

CREATE TABLE RolesSistema(
  id_rolS SMALLINT unsigned NOT NULL AUTO_INCREMENT,
  nombreRol VARCHAR(20) NOT NULL,
  PRIMARY KEY (id_rolS)
);

INSERT INTO rolessistema VALUES ('','Administrador'),
																('','Cliente');


CREATE TABLE Usuario (
	id_usuario INTEGER unsigned NOT NULL AUTO_INCREMENT,
  id_rolS SMALLINT unsigned NOT NULL,
	nombre VARCHAR(30) NOT NULL UNIQUE,
  correo VARCHAR(30) UNIQUE,
  contrasena VARCHAR(30) NOT NULL,
	Telefono VARCHAR(10),
	PRIMARY KEY (id_usuario),
  FOREIGN KEY(id_rolS)  REFERENCES RolesSistema(id_rolS)
);


INSERT INTO usuario VALUES 
		(NULL, '1', 'admin', 'pilaba@live.com', 'admin', '312154'),
		(NULL, '2', 'Juan Perez', 'JPerez@hotmail.com', '123', '321312'), 
		(NULL, '2', 'Jose Lopez', 'JLopes@gmx.com', '321', '312321');



CREATE TABLE Detalle_VehiUsuario(
  id_usuario INTEGER unsigned NOT NULL,
  matricula VARCHAR(8) NOT NULL,
  PRIMARY KEY (id_usuario,matricula),
  FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
  FOREIGN KEY (matricula) REFERENCES Vehiculo(matricula)
);

CREATE TABLE GENERO(
  id_genero CHAR(1) NOT NULL,
  nombre VARCHAR(6)NOT NULL,
  PRIMARY KEY (id_genero)
);

INSERT INTO GENERO VALUES ('h','Hombre'),
                          ('m','Mujer');


CREATE TABLE RolesE(
	Id_rol SMALLINT unsigned NOT NULL AUTO_INCREMENT,
	Nombre VARCHAR(20) NOT NULL,
	PRIMARY KEY (Id_rol)
);

CREATE TABLE TURNOS(
  Id_turno CHAR(1) NOT NULL,
  nombre VARCHAR(10) NOT NULL,
  PRIMARY KEY (Id_turno)
);

INSERT INTO TURNOS VALUES ('m','Matutino'),
                          ('v','Vespertino'),
													('d','diurno');

CREATE TABLE Empleado(
	id_empleado SMALLINT unsigned NOT NULL AUTO_INCREMENT,
	nombreE VARCHAR(30) NOT NULL,
  Correo VARCHAR(30) NOT NULL UNIQUE,
	Genero CHAR(1) NOT NULL,
	Telefono VARCHAR(10) NOT NULL,
	Turno CHAR(1) NOT NULL,
	direccion VARCHAR(50) NOT NULL,
	salario FLOAT NOT NULL,
	estado TINYINT (1) NOT NULL,
	FechaIngreso DATE NOT NULL,
	id_rol SMALLINT unsigned  NOT NULL,
	PRIMARY KEY (id_empleado),
	FOREIGN KEY (id_rol) REFERENCES RolesE (Id_rol),
	FOREIGN KEY (Turno) REFERENCES TURNOS(Id_turno),
	FOREIGN KEY (Genero) REFERENCES GENERO(id_genero)
);


CREATE TABLE Servicio(
	id_servicio INTEGER UNSIGNED  NOT NULL AUTO_INCREMENT,
	Nombre VARCHAR(30) UNIQUE NOT NULL,
	preciobase FLOAT UNSIGNED NOT NULL,
	estado TINYINT(1) NOT NULL,
	PRIMARY KEY (id_servicio)
);

CREATE TABLE PaquetesEspeciales(
  id_paquete INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  status TINYINT(1) NOT NULL,                                     #BOOLEAN
  subtotal FLOAT NOT NULL,
  descuento FLOAT NOT NULL,
  total FLOAT NOT NULL,
  PRIMARY KEY (id_paquete)
);

CREATE TABLE Detalle_ServicioPaquete(
  id_paquete INTEGER unsigned NOT NULL,
  id_Servicio INTEGER unsigned NOT NULL,
  PRIMARY KEY (id_paquete,id_Servicio),
  FOREIGN KEY (id_paquete) REFERENCES PaquetesEspeciales (id_paquete),
  FOREIGN KEY (id_Servicio)REFERENCES Servicio (id_servicio)
);

CREATE TABLE MetodosPago(
  id_metodoPago TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR (30) NOT NULL,
  PRIMARY KEY (id_metodoPago)
);

CREATE TABLE Detalle_ServUsuario(
	id_usuario INTEGER UNSIGNED NOT NULL,
	id_service INTEGER UNSIGNED  NOT NULL,
	Metodopago TINYINT UNSIGNED NOT NULL,
	Date DATE NOT NULL,
	Subtotal INTEGER UNSIGNED NOT NULL,
	Descuento INTEGER UNSIGNED NOT NULL,
	Total INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (id_usuario, id_service),
	FOREIGN KEY (id_usuario) REFERENCES Usuario (id_usuario),
	FOREIGN KEY (id_service) REFERENCES Servicio (id_servicio),
	FOREIGN KEY (Metodopago) REFERENCES MetodosPago (id_metodoPago)
);

CREATE TABLE Detalle_ServEmpleado(
  id_service INTEGER unsigned  NOT NULL,
  id_empleado SMALLINT unsigned NOT NULL,
  PRIMARY KEY (id_empleado, id_service),
  FOREIGN KEY (id_service) REFERENCES Servicio (id_servicio),
	FOREIGN KEY (id_empleado) REFERENCES Empleado (id_empleado)
);




COMMIT;