-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-02-2012 a las 19:01:43
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: 'sisco'
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'almacen'
--

DROP TABLE IF EXISTS almacen;
CREATE TABLE IF NOT EXISTS almacen (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  empresa_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY empresa_id (empresa_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Cada uno de los depositos donde se almacenan los productos' AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla 'almacen'
--

INSERT INTO almacen (id, nombre, empresa_id) VALUES
(1, 'Deposito uno', 1),
(2, 'Deposito Dos', 1),
(3, 'Deposito uno', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'banco'
--

DROP TABLE IF EXISTS banco;
CREATE TABLE IF NOT EXISTS banco (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  web varchar(45) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Bancos disponibles' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'banco'
--

INSERT INTO banco (id, nombre, web) VALUES
(1, 'Banesco', NULL),
(2, 'Mercantil', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'bitacora'
--

DROP TABLE IF EXISTS bitacora;
CREATE TABLE IF NOT EXISTS bitacora (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario_id int(11) NOT NULL,
  fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  modulo varchar(200) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla 'bitacora'
--

INSERT INTO bitacora (id, usuario_id, fecha, modulo) VALUES
(1, 1, '2012-01-04 04:04:56', 'inicio sesion'),
(2, 1, '2012-01-08 14:27:17', 'inicio sesion'),
(3, 1, '2012-01-20 03:26:46', 'inicio sesion'),
(4, 1, '2012-01-31 01:16:11', 'intento fallido de inicio de sesión para empresa:1 por anyulled'),
(5, 1, '2012-01-31 01:21:25', 'inicio sesion'),
(6, 1, '2012-01-31 10:26:07', 'inicio sesion'),
(7, 1, '2012-02-01 03:21:13', 'inicio sesion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'categoria'
--

DROP TABLE IF EXISTS categoria;
CREATE TABLE IF NOT EXISTS categoria (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Categorias de productos' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'categoria'
--

INSERT INTO categoria (id, nombre) VALUES
(1, 'Linea blanca'),
(2, 'Electrodomesticos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'cliente'
--

DROP TABLE IF EXISTS cliente;
CREATE TABLE IF NOT EXISTS cliente (
  id int(11) NOT NULL AUTO_INCREMENT,
  Nombre varchar(100) NOT NULL,
  Apellido varchar(100) NOT NULL,
  nacionalidad varchar(1) NOT NULL,
  cedula varchar(20) NOT NULL,
  email varchar(250) NOT NULL,
  telefono_local varchar(20) NOT NULL,
  telefono_trabajo varchar(20) DEFAULT NULL,
  extension_trabajo int(100) DEFAULT NULL,
  Direccion text,
  Cargo varchar(100) DEFAULT NULL,
  Departamento varchar(100) DEFAULT NULL,
  organismo_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY organismo_id (organismo_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Los clientes de cada organismo' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'cliente'
--

INSERT INTO cliente (id, Nombre, Apellido, nacionalidad, cedula, email, telefono_local, telefono_trabajo, extension_trabajo, Direccion, Cargo, Departamento, organismo_id) VALUES
(1, 'raquel', 'campomas', 'v', '13802114', 'susyra79@gmail.com', '04269081852', '02123649248', NULL, 'los teques', 'directora', 'musica', 1),
(2, 'Edgar', 'Quintana', 'v', '13339041', 'edgarquintana@gmail.com', '0121665479', '3055009199', NULL, 'no tengo dirección', 'jefe', 'gerencia', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'configuracion'
--

DROP TABLE IF EXISTS configuracion;
CREATE TABLE IF NOT EXISTS configuracion (
  iva float NOT NULL,
  cantidad_recibos_cliente_en_mora int(11) NOT NULL COMMENT 'Cantidad de recibos para declarar al cliente como moroso'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla 'configuracion'
--

INSERT INTO configuracion (iva, cantidad_recibos_cliente_en_mora) VALUES
(12, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'contrato'
--

DROP TABLE IF EXISTS contrato;
CREATE TABLE IF NOT EXISTS contrato (
  id int(11) NOT NULL AUTO_INCREMENT,
  numero varchar(20) NOT NULL,
  empresa_id int(11) NOT NULL,
  organismo_id int(11) NOT NULL,
  status_contrato_id int(11) NOT NULL,
  cliente_id int(11) NOT NULL,
  fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  vendedor_id int(11) NOT NULL,
  comision_vendedor float NOT NULL,
  frecuencia_id int(11) NOT NULL,
  plazo_id int(11) NOT NULL,
  porcentaje_vendedor int(11) NOT NULL,
  monto float NOT NULL,
  iva float NOT NULL,
  PRIMARY KEY (id),
  KEY empresa_id (empresa_id),
  KEY organismo_id (organismo_id),
  KEY status_contrato_id (status_contrato_id),
  KEY cliente_id (cliente_id),
  KEY vendedor_id (vendedor_id),
  KEY fk_contrato_frecuencia1 (frecuencia_id),
  KEY plazo_id (plazo_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Los contratos de las empresas con los organismos' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla 'contrato'
--

INSERT INTO contrato (id, numero, empresa_id, organismo_id, status_contrato_id, cliente_id, fecha, vendedor_id, comision_vendedor, frecuencia_id, plazo_id, porcentaje_vendedor, monto, iva) VALUES
(1, '2032', 1, 1, 1, 2, '2012-02-01 10:53:03', 1, 10, 1, 1, 500, 70000, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'contrato_productos'
--

DROP TABLE IF EXISTS contrato_productos;
CREATE TABLE IF NOT EXISTS contrato_productos (
  contrato_id int(11) NOT NULL,
  producto_id int(11) NOT NULL,
  almacen_id int(11) NOT NULL,
  cantidad int(11) NOT NULL,
  UNIQUE KEY contrato_id (contrato_id,producto_id,almacen_id),
  KEY producto_id (producto_id),
  KEY almacen_id (almacen_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla 'contrato_productos'
--

INSERT INTO contrato_productos (contrato_id, producto_id, almacen_id, cantidad) VALUES
(1, 4, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'cuotas'
--

DROP TABLE IF EXISTS cuotas;
CREATE TABLE IF NOT EXISTS cuotas (
  id int(11) NOT NULL AUTO_INCREMENT,
  recibo_id int(11) NOT NULL,
  monto float NOT NULL,
  status_recibo_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY status_recibo_id (status_recibo_id),
  KEY recibo_id (recibo_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'cuotas'
--

INSERT INTO cuotas (id, recibo_id, monto, status_recibo_id) VALUES
(1, 2, 50, 1),
(2, 2, 50, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'empresa'
--

DROP TABLE IF EXISTS empresa;
CREATE TABLE IF NOT EXISTS empresa (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  Rif varchar(50) NOT NULL,
  banco_id int(11) NOT NULL,
  Numero_cuenta varchar(20) NOT NULL,
  PRIMARY KEY (id),
  KEY banco_id (banco_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Empresas que venden los productos' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'empresa'
--

INSERT INTO empresa (id, nombre, Rif, banco_id, Numero_cuenta) VALUES
(1, 'Inversiones El Turco', 'J-15913233-8', 1, '15010037145802138547'),
(2, 'Megasys', '000000', 2, '000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'entrada'
--

DROP TABLE IF EXISTS entrada;
CREATE TABLE IF NOT EXISTS entrada (
  id int(11) NOT NULL AUTO_INCREMENT,
  fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usuario_id int(11) NOT NULL,
  empresa_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id),
  KEY empresa_id (empresa_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'entrada'
--

INSERT INTO entrada (id, fecha, usuario_id, empresa_id) VALUES
(1, '2012-02-01 03:38:49', 1, 1),
(2, '2012-02-01 03:40:34', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'entrada_detalle'
--

DROP TABLE IF EXISTS entrada_detalle;
CREATE TABLE IF NOT EXISTS entrada_detalle (
  id int(11) NOT NULL,
  entrada_id int(11) NOT NULL,
  producto_id int(11) NOT NULL,
  almacen_id int(11) NOT NULL,
  cantidad int(11) NOT NULL,
  costo float NOT NULL,
  PRIMARY KEY (id),
  KEY entrada_id (entrada_id),
  KEY producto_id (producto_id),
  KEY almacen_id (almacen_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla 'entrada_detalle'
--

INSERT INTO entrada_detalle (id, entrada_id, producto_id, almacen_id, cantidad, costo) VALUES
(0, 2, 4, 1, 200, 4000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'frecuencia'
--

DROP TABLE IF EXISTS frecuencia;
CREATE TABLE IF NOT EXISTS frecuencia (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  frecuencia int(100) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Frecuencuas de pago de los productos por organismo' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla 'frecuencia'
--

INSERT INTO frecuencia (id, nombre, frecuencia) VALUES
(1, 'Mensual', NULL),
(2, 'Semanal', NULL),
(3, 'Quincenal (10 y 25)', NULL),
(4, 'Quincenal (15 y 30)', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'lote'
--

DROP TABLE IF EXISTS lote;
CREATE TABLE IF NOT EXISTS lote (
  id int(11) NOT NULL AUTO_INCREMENT,
  fecha_generacion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usuario_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'lote_detalle'
--

DROP TABLE IF EXISTS lote_detalle;
CREATE TABLE IF NOT EXISTS lote_detalle (
  id int(11) NOT NULL AUTO_INCREMENT,
  lote_id int(11) NOT NULL,
  recibo_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY fk_lote_detalle_lote (lote_id),
  KEY fk_lote_detalle_recibo (recibo_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'medio_pago'
--

DROP TABLE IF EXISTS medio_pago;
CREATE TABLE IF NOT EXISTS medio_pago (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipo_medio_pago_id int(11) NOT NULL,
  banco_id int(11) DEFAULT NULL,
  numero_cuenta varchar(20) DEFAULT NULL,
  usuario_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY fk_medio_pago_tipo_medio_pago1 (tipo_medio_pago_id),
  KEY Banco_id (banco_id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'medio_pago'
--

INSERT INTO medio_pago (id, tipo_medio_pago_id, banco_id, numero_cuenta, usuario_id) VALUES
(1, 2, 1, '01052478954125877854', 2),
(2, 1, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'organismo'
--

DROP TABLE IF EXISTS organismo;
CREATE TABLE IF NOT EXISTS organismo (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  dias_cobro_banco int(11) NOT NULL COMMENT 'Cantidad de días de plazo para realizar el cobro en banco hasta cambiar a nómina',
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Organismos que gestionan contratos' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'organismo'
--

INSERT INTO organismo (id, nombre, dias_cobro_banco) VALUES
(1, 'Alcaldía del Municipio Guaicaipuro', 90),
(2, 'Contraloría del Estado Miranda', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'plazo'
--

DROP TABLE IF EXISTS plazo;
CREATE TABLE IF NOT EXISTS plazo (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Cantidad de meses que dura un contrato' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'plazo'
--

INSERT INTO plazo (id, nombre) VALUES
(1, 12),
(2, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'producto'
--

DROP TABLE IF EXISTS producto;
CREATE TABLE IF NOT EXISTS producto (
  id int(11) NOT NULL AUTO_INCREMENT,
  codigo varchar(45) NOT NULL,
  nombre varchar(200) NOT NULL,
  empresa_id int(11) NOT NULL,
  categoria_id int(11) NOT NULL,
  cantidad_minima int(11) NOT NULL COMMENT 'Cantidad minima por almacen',
  precio_venta float NOT NULL,
  precio_6 float DEFAULT NULL,
  precio_12 float DEFAULT NULL,
  precio_18 float DEFAULT NULL,
  Observacion text,
  PRIMARY KEY (id),
  KEY empresa_id (empresa_id),
  KEY categoria_id (categoria_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='productos disponibles para la venta' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla 'producto'
--

INSERT INTO producto (id, codigo, nombre, empresa_id, categoria_id, cantidad_minima, precio_venta, precio_6, precio_12, precio_18, Observacion) VALUES
(3, 'tvlg32', 'Televisor Lg 32''', 1, 1, 0, 4000, 4200, 4500, 5000, 'no hay existencia'),
(4, 'laptop001', 'Laptop Acer', 1, 2, 0, 5900, 6200, 6500, 7000, 'shit');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'producto_almacen'
--

DROP TABLE IF EXISTS producto_almacen;
CREATE TABLE IF NOT EXISTS producto_almacen (
  producto_id int(11) NOT NULL,
  almacen_id int(11) NOT NULL,
  cantidad int(11) NOT NULL,
  UNIQUE KEY producto_almacen (producto_id,almacen_id),
  KEY almacen_id (almacen_id),
  KEY producto_id (producto_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla 'producto_almacen'
--

INSERT INTO producto_almacen (producto_id, almacen_id, cantidad) VALUES
(3, 1, 26),
(3, 2, 12),
(4, 1, 400);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'recibo'
--

DROP TABLE IF EXISTS recibo;
CREATE TABLE IF NOT EXISTS recibo (
  id int(11) NOT NULL AUTO_INCREMENT,
  cliente_id int(11) NOT NULL,
  contrato_id int(11) NOT NULL,
  monto double NOT NULL,
  fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status_recibo_id int(11) NOT NULL,
  medio_pago_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY fk_recibo_contrato1 (contrato_id),
  KEY fk_recibo_cliente1 (cliente_id),
  KEY fk_recibo_status_recibo1 (status_recibo_id),
  KEY medio_pago_id (medio_pago_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Recibos correspondientes al pago de productos según contrato' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'recibo'
--

INSERT INTO recibo (id, cliente_id, contrato_id, monto, fecha, status_recibo_id, medio_pago_id) VALUES
(1, 2, 1, 500, '2012-02-01 04:30:00', 1, 2),
(2, 2, 1, 500, '2012-03-01 11:00:52', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'salida'
--

DROP TABLE IF EXISTS salida;
CREATE TABLE IF NOT EXISTS salida (
  id int(11) NOT NULL AUTO_INCREMENT,
  fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usuario_id int(11) NOT NULL,
  empresa_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id),
  KEY empresa_id (empresa_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla 'salida'
--

INSERT INTO salida (id, fecha, usuario_id, empresa_id) VALUES
(1, '2012-02-01 11:03:29', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'salida_detalle'
--

DROP TABLE IF EXISTS salida_detalle;
CREATE TABLE IF NOT EXISTS salida_detalle (
  id int(11) NOT NULL AUTO_INCREMENT,
  salida_id int(11) NOT NULL,
  producto_id int(11) NOT NULL,
  almacen_id int(11) NOT NULL,
  cantidad int(11) NOT NULL,
  contrato_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY entrada_id (salida_id),
  KEY producto_id (producto_id),
  KEY almacen_id (almacen_id),
  KEY contrato_id (contrato_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla 'salida_detalle'
--

INSERT INTO salida_detalle (id, salida_id, producto_id, almacen_id, cantidad, contrato_id) VALUES
(1, 1, 4, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'status_contrato'
--

DROP TABLE IF EXISTS status_contrato;
CREATE TABLE IF NOT EXISTS status_contrato (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla 'status_contrato'
--

INSERT INTO status_contrato (id, nombre) VALUES
(1, 'vigente'),
(2, 'cancelado'),
(3, 'incobrable'),
(4, 'moroso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'status_recibo'
--

DROP TABLE IF EXISTS status_recibo;
CREATE TABLE IF NOT EXISTS status_recibo (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla 'status_recibo'
--

INSERT INTO status_recibo (id, nombre) VALUES
(1, 'Pendiente'),
(2, 'Cobrado'),
(3, 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'tipo_medio_pago'
--

DROP TABLE IF EXISTS tipo_medio_pago;
CREATE TABLE IF NOT EXISTS tipo_medio_pago (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tipos de medios de pago disponibles' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla 'tipo_medio_pago'
--

INSERT INTO tipo_medio_pago (id, nombre) VALUES
(1, 'Nómina'),
(2, 'Banco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'tipo_usuario'
--

DROP TABLE IF EXISTS tipo_usuario;
CREATE TABLE IF NOT EXISTS tipo_usuario (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla 'tipo_usuario'
--

INSERT INTO tipo_usuario (id, nombre) VALUES
(1, 'Admin'),
(2, 'Cliente'),
(3, 'Empresa'),
(4, 'Organismo'),
(5, 'Demo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'usuario'
--

DROP TABLE IF EXISTS usuario;
CREATE TABLE IF NOT EXISTS usuario (
  id int(11) NOT NULL AUTO_INCREMENT,
  login varchar(50) NOT NULL,
  clave varchar(100) NOT NULL,
  Nombre varchar(200) NOT NULL,
  cedula varchar(20) DEFAULT NULL,
  telefono varchar(20) DEFAULT NULL,
  correo varchar(100) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Usuarios con acceso al sistema' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla 'usuario'
--

INSERT INTO usuario (id, login, clave, Nombre, cedula, telefono, correo) VALUES
(1, 'anyulled', 'alrorecg', 'Anyul Rivas', '15913233', '0426-7174942', 'anyulled@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'usuario_empresa_rol'
--

DROP TABLE IF EXISTS usuario_empresa_rol;
CREATE TABLE IF NOT EXISTS usuario_empresa_rol (
  usuario_id int(11) NOT NULL,
  empresa_id int(11) NOT NULL,
  tipo_usuario_id int(11) NOT NULL,
  UNIQUE KEY usuario_id (usuario_id,empresa_id,tipo_usuario_id),
  KEY empresa_id (empresa_id),
  KEY tipo_usuario_id (tipo_usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla 'usuario_empresa_rol'
--

INSERT INTO usuario_empresa_rol (usuario_id, empresa_id, tipo_usuario_id) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'vendedor'
--

DROP TABLE IF EXISTS vendedor;
CREATE TABLE IF NOT EXISTS vendedor (
  id int(11) NOT NULL AUTO_INCREMENT,
  Nombre varchar(150) NOT NULL,
  telefono_1 varchar(20) NOT NULL,
  telefono_2 varchar(20) DEFAULT NULL,
  empresa_id int(11) NOT NULL,
  email varchar(50) DEFAULT NULL,
  direccion text,
  comision float NOT NULL,
  PRIMARY KEY (id),
  KEY fk_vendedor_empresa1 (empresa_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Vendedores de la empresa' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla 'vendedor'
--

INSERT INTO vendedor (id, Nombre, telefono_1, telefono_2, empresa_id, email, direccion, comision) VALUES
(1, 'mayckel', '04129561900', NULL, 1, 'mayckellee@hotmail.com', 'los teques', 10);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT almacen_ibfk_1 FOREIGN KEY (empresa_id) REFERENCES empresa (id);

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT bitacora_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuario (id);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT cliente_ibfk_1 FOREIGN KEY (organismo_id) REFERENCES organismo (id);

--
-- Filtros para la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT contrato_ibfk_7 FOREIGN KEY (plazo_id) REFERENCES plazo (id),
  ADD CONSTRAINT contrato_ibfk_1 FOREIGN KEY (empresa_id) REFERENCES empresa (id),
  ADD CONSTRAINT contrato_ibfk_2 FOREIGN KEY (organismo_id) REFERENCES organismo (id),
  ADD CONSTRAINT contrato_ibfk_3 FOREIGN KEY (status_contrato_id) REFERENCES status_contrato (id),
  ADD CONSTRAINT contrato_ibfk_4 FOREIGN KEY (cliente_id) REFERENCES `cliente` (id),
  ADD CONSTRAINT contrato_ibfk_6 FOREIGN KEY (vendedor_id) REFERENCES vendedor (id),
  ADD CONSTRAINT fk_contrato_frecuencia1 FOREIGN KEY (frecuencia_id) REFERENCES frecuencia (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contrato_productos`
--
ALTER TABLE `contrato_productos`
  ADD CONSTRAINT contrato_productos_ibfk_1 FOREIGN KEY (contrato_id) REFERENCES contrato (id),
  ADD CONSTRAINT contrato_productos_ibfk_2 FOREIGN KEY (producto_id) REFERENCES producto (id),
  ADD CONSTRAINT contrato_productos_ibfk_3 FOREIGN KEY (almacen_id) REFERENCES almacen (id);

--
-- Filtros para la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT cuotas_ibfk_1 FOREIGN KEY (recibo_id) REFERENCES recibo (id),
  ADD CONSTRAINT cuotas_ibfk_2 FOREIGN KEY (status_recibo_id) REFERENCES status_recibo (id);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT empresa_ibfk_1 FOREIGN KEY (banco_id) REFERENCES banco (id);

--
-- Filtros para la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT entrada_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuario (id),
  ADD CONSTRAINT entrada_ibfk_2 FOREIGN KEY (empresa_id) REFERENCES empresa (id);

--
-- Filtros para la tabla `entrada_detalle`
--
ALTER TABLE `entrada_detalle`
  ADD CONSTRAINT entrada_detalle_ibfk_1 FOREIGN KEY (entrada_id) REFERENCES entrada (id),
  ADD CONSTRAINT entrada_detalle_ibfk_2 FOREIGN KEY (producto_id) REFERENCES producto (id),
  ADD CONSTRAINT entrada_detalle_ibfk_3 FOREIGN KEY (almacen_id) REFERENCES almacen (id);

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT lote_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuario (id);

--
-- Filtros para la tabla `lote_detalle`
--
ALTER TABLE `lote_detalle`
  ADD CONSTRAINT fk_lote_detalle_lote FOREIGN KEY (lote_id) REFERENCES lote (id),
  ADD CONSTRAINT fk_lote_detalle_recibo FOREIGN KEY (recibo_id) REFERENCES recibo (id);

--
-- Filtros para la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  ADD CONSTRAINT medio_pago_ibfk_1 FOREIGN KEY (Banco_id) REFERENCES banco (id),
  ADD CONSTRAINT medio_pago_ibfk_2 FOREIGN KEY (tipo_medio_pago_id) REFERENCES tipo_medio_pago (id),
  ADD CONSTRAINT medio_pago_ibfk_3 FOREIGN KEY (banco_id) REFERENCES banco (id),
  ADD CONSTRAINT medio_pago_ibfk_5 FOREIGN KEY (usuario_id) REFERENCES `cliente` (id);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT producto_ibfk_1 FOREIGN KEY (empresa_id) REFERENCES empresa (id),
  ADD CONSTRAINT producto_ibfk_2 FOREIGN KEY (categoria_id) REFERENCES categoria (id);

--
-- Filtros para la tabla `producto_almacen`
--
ALTER TABLE `producto_almacen`
  ADD CONSTRAINT producto_almacen_ibfk_1 FOREIGN KEY (producto_id) REFERENCES producto (id),
  ADD CONSTRAINT producto_almacen_ibfk_2 FOREIGN KEY (almacen_id) REFERENCES almacen (id);

--
-- Filtros para la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT fk_recibo_cliente1 FOREIGN KEY (cliente_id) REFERENCES `cliente` (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_recibo_contrato1 FOREIGN KEY (contrato_id) REFERENCES contrato (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_recibo_status_recibo1 FOREIGN KEY (status_recibo_id) REFERENCES status_recibo (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT recibo_ibfk_1 FOREIGN KEY (medio_pago_id) REFERENCES medio_pago (id);

--
-- Filtros para la tabla `salida`
--
ALTER TABLE `salida`
  ADD CONSTRAINT salida_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuario (id),
  ADD CONSTRAINT salida_ibfk_2 FOREIGN KEY (empresa_id) REFERENCES empresa (id);

--
-- Filtros para la tabla `salida_detalle`
--
ALTER TABLE `salida_detalle`
  ADD CONSTRAINT salida_detalle_ibfk_1 FOREIGN KEY (producto_id) REFERENCES producto (id),
  ADD CONSTRAINT salida_detalle_ibfk_2 FOREIGN KEY (almacen_id) REFERENCES almacen (id),
  ADD CONSTRAINT salida_detalle_ibfk_3 FOREIGN KEY (contrato_id) REFERENCES contrato (id),
  ADD CONSTRAINT salida_detalle_ibfk_4 FOREIGN KEY (salida_id) REFERENCES salida (id);

--
-- Filtros para la tabla `usuario_empresa_rol`
--
ALTER TABLE `usuario_empresa_rol`
  ADD CONSTRAINT usuario_empresa_rol_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuario (id),
  ADD CONSTRAINT usuario_empresa_rol_ibfk_2 FOREIGN KEY (empresa_id) REFERENCES empresa (id),
  ADD CONSTRAINT usuario_empresa_rol_ibfk_3 FOREIGN KEY (tipo_usuario_id) REFERENCES tipo_usuario (id);

--
-- Filtros para la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD CONSTRAINT fk_vendedor_empresa1 FOREIGN KEY (empresa_id) REFERENCES empresa (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
