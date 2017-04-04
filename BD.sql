START TRANSACTION; #EMPIEZA LA TRANSACCION

DROP DATABASE IF EXISTS carwashBD;
CREATE DATABASE carwashBD DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci;

CREATE TABLE TiposVehiculos(
	id_Tipo INTEGER unsigned NOT NULL AUTO_INCREMENT,
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
	matricula char(7) NOT NULL,
	id_Tipo INTEGER unsigned NOT NULL,
	Marca VARCHAR (20) NOT NULL,                                    #NOTA: ESTO PUEDE SER NULL
	PRIMARY KEY (matricula),
	FOREIGN KEY (id_Tipo) REFERENCES TiposVehiculos(id_Tipo)
);

CREATE TABLE Cliente (
	id_cliente INTEGER unsigned NOT NULL AUTO_INCREMENT,
	Nombre VARCHAR(30) NOT NULL,
	Telefono NUMERIC(10,2),
	PRIMARY KEY (id_cliente)
);

CREATE TABLE Detalle_VehiClien(
  id_cliente INTEGER unsigned NOT NULL,
  matricula char(7) NOT NULL,
  PRIMARY KEY (id_cliente,matricula),
  FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
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
	Id_rol INTEGER unsigned  NOT NULL AUTO_INCREMENT,
	Nombre VARCHAR(20) NOT NULL,
	PRIMARY KEY (Id_rol)
);

CREATE TABLE TURNOS(
  Id_turno CHAR(1) NOT NULL,
  nombre VARCHAR(10) NOT NULL,
  PRIMARY KEY (Id_turno)
);

INSERT INTO TURNOS VALUES ('m','Matutino'),
                          ('v','Vespertino');

CREATE TABLE Empleado(
	id_empleado INTEGER unsigned NOT NULL AUTO_INCREMENT,
	nombreE VARCHAR(30) NOT NULL,
	Genero CHAR(1) NOT NULL,
	Telefono INTEGER NOT NULL,
	Turno CHAR(1) NOT NULL,
	direccion VARCHAR(50) NOT NULL,
	salario DECIMAL(10) NOT NULL,
	estado TINYINT NOT NULL,
	FechaIngreso DATE NOT NULL,
	id_rol INTEGER unsigned  NOT NULL,
	PRIMARY KEY (id_empleado),
	FOREIGN KEY (id_rol) REFERENCES RolesE (Id_rol),
	FOREIGN KEY (Turno) REFERENCES TURNOS(Id_turno),
	FOREIGN KEY (Genero) REFERENCES GENERO(id_genero)
);


CREATE TABLE Servicio(
	id_servicio INTEGER unsigned  NOT NULL AUTO_INCREMENT,
	preciobase INTEGER Unsigned NOT NULL,
	Descripcion TEXT NOT NULL,
	estado TINYINT(1) NOT NULL,
	DirImage VARCHAR (50) NOT NULL,
	PRIMARY KEY (id_servicio)
);

CREATE TABLE PaquetesEspeciales(
  id_paquete INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  status TINYINT(1) DEFAULT NULL,                                     #BOOLEAN
  subtotal INTEGER NOT NULL,
  descuento INTEGER NOT NULL,
  total INTEGER NOT NULL,
  PRIMARY KEY (id_paquete)
);

CREATE TABLE Detalle_ServicioyPaquesp(
  id_paquete INTEGER UNSIGNED NOT NULL,
  id_Servicio INTEGER unsigned NOT NULL,
  PRIMARY KEY (id_paquete,id_Servicio),
  FOREIGN KEY (id_paquete) REFERENCES PaquetesEspeciales (id_paquete),
  FOREIGN KEY (id_Servicio)REFERENCES Servicio (id_servicio)
);




CREATE TABLE MetodosPago(
  id_metodoPago INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR (30),
  PRIMARY KEY (id_metodoPago)
);

CREATE TABLE Detalle_ServCli(
	id_client INTEGER unsigned NOT NULL,
	id_service INTEGER unsigned  NOT NULL,
	Metodopago INTEGER UNSIGNED NOT NULL,
	Date DATE NOT NULL,
	Subtotal NUMERIC(10,2) NOT NULL,
	Descuento NUMERIC(10,2) NOT NULL,
	Total NUMERIC(10,2) NOT NULL,
	PRIMARY KEY (id_client, id_service),
	FOREIGN KEY (id_client) REFERENCES Cliente (id_cliente),
	FOREIGN KEY (id_service) REFERENCES Servicio (id_servicio),
	FOREIGN KEY (Metodopago) REFERENCES MetodosPago (id_metodoPago)
);

CREATE TABLE Detalle_ServEmpleado(
  id_service INTEGER unsigned  NOT NULL,
  id_empleado INTEGER unsigned NOT NULL,
  PRIMARY KEY (id_empleado, id_service),
  FOREIGN KEY (id_service) REFERENCES Servicio (id_servicio),
	FOREIGN KEY (id_empleado) REFERENCES Empleado (id_empleado)
);

CREATE TABLE RolesSistema(
	id_rolS INTEGER unsigned NOT NULL AUTO_INCREMENT,
	nombreRol VARCHAR(20) NOT NULL,
	PRIMARY KEY (id_rolS)
);
	
INSERT INTO rolessistema VALUES ('','Administrador'),
                                ('','Cliente');

CREATE TABLE UsuariosSistem(
	id_user INTEGER unsigned NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(30) NOT NULL UNIQUE,
	email VARCHAR(30) NOT NULL UNIQUE,
	contrasena VARCHAR(30) NOT NULL,
	id_Rol INTEGER unsigned NOT NULL,
	PRIMARY KEY (id_user),
	FOREIGN KEY (id_Rol) REFERENCES RolesSistema(id_rolS)
);

COMMIT;
