CREATE TABLE Cliente (
	id_cliente INTEGER unsigned NOT NULL AUTO_INCREMENT,
	Name VARCHAR(30) NOT NULL,
	Telefono NUMERIC(10,2),
	PRIMARY KEY (id_cliente));

CREATE TABLE Roles(
	Id_rol INTEGER unsigned  NOT NULL AUTO_INCREMENT,
	Nombre VARCHAR(20) NOT NULL,
	PRIMARY KEY (Id_rol));

--MAYBE-- A PASSWORD FOR EMPLOYEES TO ACCESS VIA HTTP TO MODIFY THEIR OWN DATA. SO THE INTERNET IT´S NEEDED
--MAYBE2- APP OR VIA HTTP AGAIN TO RESERVE A DATE, SO WE CAN ADD PROMOTIONS LIKE A RANDOM FREE SERVICE FOR THEM OR A NICE DISCOUNT

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
	FOREIGN KEY (id_rol) REFERENCES Roles (Id_rol));

CREATE TABLE Servicio(
	id_servicio INTEGER unsigned  NOT NULL AUTO_INCREMENT,
	Descripcion TEXT NOT NULL,
	estado TINYINT NOT NULL,
	id_empleado INTEGER unsigned NOT NULL,
	PRIMARY KEY (id_servicio),
	FOREIGN KEY (id_empleado) REFERENCES Empleado(id_empleado));

CREATE TABLE Detalle(
	id_client INTEGER unsigned NOT NULL,
	id_service INTEGER unsigned  NOT NULL,
	Metodopago CHAR(1) NOT NULL,
	Date DATE NOT NULL,
	Subtotal NUMERIC(10,2) NOT NULL,
	Descuento NUMERIC(10,2) NOT NULL,
	Total NUMERIC(10,2) NOT NULL,
	PRIMARY KEY (id_client, id_service),
	FOREIGN KEY (id_client) REFERENCES Cliente (id_cliente),
	FOREIGN KEY (id_service) REFERENCES Servicio (id_servicio));

CREATE TABLE RolesSistema(
	id_rolS INTEGER unsigned NOT NULL AUTO_INCREMENT,
	nombreRol VARCHAR(20) NOT NULL,
	PRIMARY KEY (id_rolS));

CREATE TABLE UsuariosSistem(
	id_user INTEGER unsigned NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(30) NOT NULL UNIQUE,
	email VARCHAR(30) NOT NULL UNIQUE,
	contrasena VARCHAR(30) NOT NULL,
	id_Rol INTEGER unsigned NOT NULL,
	PRIMARY KEY (id_user),
	FOREIGN KEY (id_Rol) REFERENCES RolesSistema(id_rolS));
