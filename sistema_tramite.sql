-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 19:00:53
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_tramite`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SEGUIMIENTO_TRAMITE` (IN `NUMERO` VARCHAR(12), IN `DNI` VARCHAR(12))   SELECT
  documento.documento_id,
  documento.doc_dniremitente,
  CONCAT_WS('',documento.doc_nombreremitente, documento.doc_apepatremitente, documento.doc_apematremitente),
  documento.doc_fecharegistro
  
FROM
  documento
  WHERE documento.documento_id=NUMERO and documento.doc_dniremitente=DNI$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SEGUIMIENTO_TRAMITE_DETALLE` (IN `NUMERO` VARCHAR(12))   BEGIN
    SELECT
        m.movimiento_id,
        m.documento_id,
        area_origen.area_nombre AS area_origen_nombre,
        area_destino.area_nombre AS area_destino_nombre,
        m.mov_fecharegistro,
        m.mov_descripcion,
        m.mov_status,
        m.area_origen_id,
        m.areadestino_id
    FROM
        movimiento m
    INNER JOIN
        area area_destino ON m.areadestino_id = area_destino.area_cod
    INNER JOIN
        area area_origen ON m.area_origen_id = area_origen.area_cod
    WHERE
        m.documento_id = NUMERO
    ORDER BY
        m.mov_fecharegistro ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SELECT_AREA` ()   SELECT 
    area.area_cod,
    area.area_nombre
FROM
    area$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SELECT_EMPLEADO` ()   SELECT
    empleado.empleado_id,
    CONCAT_WS(' ', empleado.emple_nombre, empleado.emple_apepat, empleado.emple_apemat)
FROM
    empleado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CARGAR_SELECT_TIPO` ()   SELECT
	tipo_documento.tipodocumento_id,
    tipo_documento.tipodo_descripcion
FROM
	tipo_documento
    WHERE tipo_documento.tipodo_estado='ACTIVO'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_AREA` ()   SELECT 
	area.area_cod,
    area.area_nombre,
    area.area_fecha_registro,
    area.area_estado
FROM 
	area$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_EMPLEADO` ()   SELECT
	empleado.empleado_id, 
	empleado.emple_nombre, 
	empleado.emple_apepat, 
	empleado.emple_apemat, 
	empleado.emple_fechanacimiento, 
	empleado.emple_nrodocumento, 
	empleado.emple_cel, 
	empleado.emple_email, 
	empleado.emple_status, 
	empleado.emple_direccion, 
	empleado.empl_fotoperfil,
	CONCAT_WS(' ',	empleado.emple_nombre,empleado.emple_apepat,empleado.emple_apemat) as em
FROM
	empleado$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TIPO_DOCUMENTO` ()   SELECT
	tipo_documento.tipodocumento_id,
    tipo_documento.tipodo_descripcion,
    tipo_documento.tipodo_estado,
    tipo_documento.tipodo_fregistro
FROM
	tipo_documento$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TRAMITE` ()   SELECT
	documento.documento_id, 
	documento.doc_dniremitente, 
	CONCAT_WS(' ',documento.doc_nombreremitente,documento.doc_apepatremitente,documento.doc_apematremitente) AS REMITENTE, 
	documento.tipodocumento_id, 
	tipo_documento.tipodo_descripcion, 
	documento.doc_status, 
	origen.area_nombre AS origen, 
	destino.area_nombre AS destino, 
	documento.doc_nrodocumento,
    documento.doc_nombreremitente,
    documento.doc_apepatremitente,
    documento.doc_apematremitente,
    documento.doc_celremitente,
    documento.doc_emailremitente,
    documento.doc_descripcion,
    documento.doc_asunto,
    documento.doc_fecharegistro,
    documento.area_origen,
    documento.area_destino
FROM
	documento
	INNER JOIN
	tipo_documento
	ON 
		documento.tipodocumento_id = tipo_documento.tipodocumento_id
	INNER JOIN
	area AS origen
	ON 
		documento.area_origen = origen.area_cod
	INNER JOIN
	area AS destino
	ON 
		documento.area_destino = destino.area_cod$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TRAMITE_AREA` (IN `IDUSUARIO` INT)   BEGIN
    DECLARE IDAREA INT;

    -- Obtener el área del usuario
    SET IDAREA := (SELECT area_id FROM usuario WHERE usu_id = IDUSUARIO);

    SELECT DISTINCT
        d.documento_id,
        d.doc_dniremitente,
        CONCAT_WS(' ', d.doc_nombreremitente, d.doc_apepatremitente, d.doc_apematremitente) AS REMITENTE,
        d.tipodocumento_id,
        td.tipodo_descripcion,
        d.doc_status,
        origen.area_nombre AS origen,
        destino.area_nombre AS destino,
        d.doc_nrodocumento,
        d.doc_nombreremitente,
        d.doc_apepatremitente,
        d.doc_apematremitente,
        d.doc_celremitente,
        d.doc_emailremitente,
        d.doc_descripcion,
        d.doc_asunto,
        d.doc_fecharegistro,
        d.area_origen,
        d.area_destino
    FROM
        documento d
    INNER JOIN
        tipo_documento td ON d.tipodocumento_id = td.tipodocumento_id
    INNER JOIN
        area origen ON d.area_origen = origen.area_cod
    INNER JOIN
        area destino ON d.area_destino = destino.area_cod
    INNER JOIN
        movimiento m ON d.documento_id = m.documento_id
    WHERE
        m.area_origen_id = IDAREA OR m.areadestino_id = IDAREA
    ORDER BY
        d.doc_nrodocumento ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TRAMITE_SEGUIMIENTO` (IN `ID` CHAR(11))   BEGIN
    SELECT 
        m.movimiento_id,
        m.documento_id,
        m.area_origen_id,
        area_origen.area_nombre AS area_origen_nombre,
        m.areadestino_id,
        area_destino.area_nombre AS area_destino_nombre,
        m.mov_fecharegistro,
        m.mov_descripcion,
        m.mov_archivo,
        m.mov_status
    FROM 
        movimiento m
    INNER JOIN 
        area area_origen ON m.area_origen_id = area_origen.area_cod
    INNER JOIN 
        area area_destino ON m.areadestino_id = area_destino.area_cod
    WHERE 
        m.documento_id = ID
    ORDER BY 
        m.mov_fecharegistro ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_USUARIO` ()   SELECT
	usuario.usu_id, 
	usuario.usu_usuario, 
	usuario.empleado_id, 
	usuario.usu_observacion, 
	usuario.usu_status, 
	usuario.area_id, 
	usuario.usu_rol, 
	usuario.universidad_id, 
	area.area_nombre, 
	CONCAT_WS(' ',empleado.emple_nombre,empleado.emple_apepat,empleado.emple_apemat) as nempleado
FROM
	usuario
	INNER JOIN
	area
	ON 
		usuario.area_id = area.area_cod
	INNER JOIN
	empleado
	ON 
		usuario.empleado_id = empleado.empleado_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_AREA` (IN `ID` INT, IN `NAREA` VARCHAR(255), IN `STATUS` VARCHAR(20))   BEGIN
    DECLARE AREAACTUAL VARCHAR(255);
    DECLARE CANTIDAD INT;

    -- Obtener el nombre del área actual
    SET @AREAACTUAL := (SELECT area_nombre FROM area WHERE area_cod = ID);

    IF @AREAACTUAL = NAREA THEN
        -- Si el nombre no ha cambiado, solo actualizamos el estado
        UPDATE area
        SET area_estado = STATUS, 
            area_nombre = NAREA
        WHERE area_cod = ID;
        SELECT 1;
    ELSE
        -- Si el nombre ha cambiado, verificamos si ya existe el nuevo nombre
        SET @CANTIDAD := (SELECT COUNT(*) FROM area WHERE area_nombre = NAREA);

        IF @CANTIDAD = 0 THEN
            -- Si no existe el nombre, realizamos la actualización
            UPDATE area
            SET area_estado = STATUS, 
                area_nombre = NAREA
            WHERE area_cod = ID;
            SELECT 1;
        ELSE
            -- Si el nombre ya existe, retornamos 2
            SELECT 2;
        END IF;
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_EMPLEADO` (IN `ID` INT, IN `NDOCUMENTO` CHAR(12), IN `NOMBRE` VARCHAR(150), IN `APEPAT` VARCHAR(100), IN `APEMAT` VARCHAR(100), IN `FECHA` DATE, IN `CEL` CHAR(9), IN `DIRECCION` VARCHAR(255), IN `EMAIL` VARCHAR(255), IN `STATUS` VARCHAR(20))   BEGIN
DECLARE NDOCUMENTOACTUAL CHAR(12);
DECLARE CANTIDAD INT;
SET @NDOCUMENTOACTUAL:=(SELECT emple_nrodocumento from empleado where empleado_id=ID);
IF @NDOCUMENTOACTUAL = NDOCUMENTO THEN
	UPDATE empleado SET
	emple_nrodocumento=NDOCUMENTO,
	emple_nombre=NOMBRE,
	emple_apepat=APEPAT,
	emple_apemat=APEMAT,
	emple_fechanacimiento=FECHA,
	emple_cel=CEL,
	emple_direccion=DIRECCION,
	emple_email=EMAIL,
	emple_status=STATUS
	WHERE empleado_id=ID;
	SELECT 1;
ELSE
	SET @CANTIDAD:=(SELECT COUNT(*) FROM empleado where emple_nrodocumento=NDOCUMENTO);
	IF @CANTIDAD = 0 THEN
		UPDATE empleado SET
		emple_nrodocumento=NDOCUMENTO,
		emple_nombre=NOMBRE,
		emple_apepat=APEPAT,
		emple_apemat=APEMAT,
		emple_fechanacimiento=FECHA,
		emple_cel=CEL,
		emple_direccion=DIRECCION,
		emple_email=EMAIL,
		emple_status=STATUS
		WHERE empleado_id=ID;
		SELECT 1;
	ELSE
	SELECT 2;
	END IF;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_TIPO` (IN `ID` INT, IN `NTIPO` VARCHAR(255), IN `STATUS` VARCHAR(20))   BEGIN
DECLARE TIPOACTUAL VARCHAR(255);
DECLARE CANTIDAD INT;
SET @TIPOACTUAL:=(SELECT tipodo_descripcion  FROM tipo_documento where tipodocumento_id=ID);
IF @TIPOACTUAL = NTIPO THEN
  UPDATE tipo_documento set
	tipodo_descripcion=NTIPO,
	tipodo_estado=STATUS
	where tipodocumento_id=ID;
	SELECT 1;
ELSE
	SET @CANTIDAD:=(SELECT COUNT(*) FROM tipo_documento where tipodo_descripcion=NTIPO);
	IF @CANTIDAD = 0 THEN
		UPDATE tipo_documento set
		tipodo_descripcion=NTIPO,
		tipodo_estado=STATUS
		where tipodocumento_id=ID;
		SELECT 1;
		SELECT 1;
	ELSE
		SELECT 2;
END IF;

END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_USUARIO` (IN `ID` INT, IN `IDEMPLEADO` INT, IN `IDAREA` INT, IN `ROL` VARCHAR(25))   BEGIN
    UPDATE usuario 
    SET empleado_id = IDEMPLEADO,
        area_id = IDAREA,
        usu_rol = ROL
    WHERE usu_id = ID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_USUARIO_CONTRA` (IN `ID` INT, IN `CONTRA` VARCHAR(250))   UPDATE usuario 
SET usu_contra = CONTRA
WHERE usu_id = ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_USUARIO_STATUS` (IN `ID` INT, IN `STATUS` VARCHAR(20))   UPDATE usuario 
SET usu_status = STATUS
WHERE usu_id = ID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_AREA` (IN `NAREA` VARCHAR(255))   BEGIN
    DECLARE CANTIDAD INT;

    -- Asignar el valor de la cantidad de registros con el nombre NAREA
    SET @CANTIDAD := (SELECT COUNT(*) FROM area WHERE area_nombre = NAREA);

    IF @CANTIDAD = 0 THEN
        -- Insertar un nuevo registro si no hay coincidencias
        INSERT INTO area(area_nombre, area_fecha_registro) VALUES (NAREA, NOW());
        SELECT 1;  -- Indica que se realizó el registro
    ELSE
        -- Si ya existe un registro, no se inserta nada
        SELECT 2;  -- Indica que el área ya existe
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_EMPLEADO` (IN `NDOCUMENTO` CHAR(12), IN `NOMBRE` VARCHAR(150), IN `APEPAT` VARCHAR(100), IN `APEMAT` VARCHAR(100), IN `FECHA` DATE, IN `CEL` CHAR(9), IN `DIRECCION` VARCHAR(255), IN `EMAIL` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM empleado where emple_nrodocumento=NDOCUMENTO);
IF @CANTIDAD = 0 THEN
	INSERT INTO empleado(emple_nrodocumento,emple_nombre,emple_apepat,emple_apemat,emple_fechanacimiento,emple_cel,emple_direccion,emple_email,emple_feccreacion,emple_status,empl_fotoperfil) VALUES(NDOCUMENTO,NOMBRE,APEPAT,APEMAT,FECHA,CEL,DIRECCION,EMAIL,CURDATE(),'ACTIVO','controller/empleado/fotos/admin.png');
	SELECT 1;
ELSE
SELECT 2;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_TIPO` (IN `NTIPO` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM tipo_documento where tipodo_descripcion=NTIPO);
IF @CANTIDAD = 0 THEN
	INSERT INTO tipo_documento(tipodo_descripcion,tipodo_estado,tipodo_fregistro) VALUES(NTIPO,'ACTIVO',NOW());
	SELECT 1;
ELSE
	SELECT 2;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_TRAMITE` (IN `DNI` CHAR(8), IN `NOMBRE` VARCHAR(150), IN `APEPAT` VARCHAR(50), IN `APEMAT` VARCHAR(50), IN `CEL` CHAR(9), IN `EMAIL` VARCHAR(150), IN `AREAPRINCIPAL` INT, IN `AREADESTINO` INT, IN `TIPO` INT, IN `NRODOCUMENTO` VARCHAR(12), IN `ASUNTO` VARCHAR(255), IN `RUTA` TEXT, IN `DESCRIPCION` VARCHAR(255), IN `IDUSUARIO` INT)   BEGIN
    DECLARE cantidad INT;
    DECLARE cod CHAR(12);
    
    -- Generar código del documento
    SET @cantidad := (SELECT COUNT(*) FROM documento);
    IF @cantidad >= 1 AND @cantidad <= 8 THEN
        SET @cod := (SELECT CONCAT('D000000', (@cantidad + 1)));
    ELSEIF @cantidad >= 9 AND @cantidad <= 98 THEN
        SET @cod := (SELECT CONCAT('D00000', (@cantidad + 1)));
    ELSEIF @cantidad >= 99 AND @cantidad <= 998 THEN
        SET @cod := (SELECT CONCAT('D0000', (@cantidad + 1)));
    ELSEIF @cantidad >= 999 AND @cantidad <= 9998 THEN
        SET @cod := (SELECT CONCAT('D000', (@cantidad + 1)));
    ELSEIF @cantidad >= 9999 AND @cantidad <= 99998 THEN
        SET @cod := (SELECT CONCAT('D00', (@cantidad + 1)));
    ELSEIF @cantidad >= 99999 AND @cantidad <= 999998 THEN
        SET @cod := (SELECT CONCAT('D0', (@cantidad + 1)));
    ELSEIF @cantidad >= 999999 THEN
        SET @cod := (SELECT CONCAT('D', (@cantidad + 1)));
    ELSE
        SET @cod := (SELECT CONCAT('D0000001'));
    END IF;
    
    -- Insertar en documento (almacena el JSON completo)
    INSERT INTO documento(
        documento_id, 
        doc_dniremitente, 
        doc_nombreremitente, 
        doc_apepatremitente, 
        doc_apematremitente, 
        doc_celremitente, 
        doc_emailremitente, 
        area_origen, 
        area_destino, 
        tipodocumento_id, 
        doc_nrodocumento, 
        doc_asunto, 
        doc_archivo,  -- Almacena el JSON con todas las rutas
        doc_descripcion,
        doc_status
    ) VALUES (
        @cod, 
        DNI, 
        NOMBRE, 
        APEPAT, 
        APEMAT, 
        CEL, 
        EMAIL, 
        AREAPRINCIPAL, 
        AREADESTINO, 
        TIPO, 
        NRODOCUMENTO, 
        ASUNTO, 
        RUTA,  -- JSON completo de rutas
        DESCRIPCION,
        'EN PROCESO'
    );
    
    -- Insertar en movimiento (ahora también almacena todas las rutas)
    INSERT INTO movimiento(
        documento_id, 
        area_origen_id, 
        areadestino_id, 
        mov_fecharegistro, 
        mov_descripcion, 
        mov_status, 
        usuario_id, 
        mov_archivo  -- Ahora también almacena el JSON completo
    ) VALUES (
        @cod, 
        AREAPRINCIPAL, 
        AREADESTINO, 
        NOW(), 
        DESCRIPCION, 
        'EN PROCESO', 
        IDUSUARIO, 
        RUTA  -- Mismo JSON que en documento
    );
    
    SELECT @cod AS codigo_documento;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_TRAMITE_DERIVAR` (IN `ID` CHAR(15), IN `ORIGEN` INT, IN `DESTINO` INT, IN `DESCRIPCION` VARCHAR(255), IN `IDUSUARIO` INT, IN `RUTA` TEXT, IN `TIPO` VARCHAR(255))   BEGIN
	DECLARE IDMOVIMIENTO INT;
    SET @IDMOVIMIENTO:=(SELECT movimiento_id FROM movimiento WHERE mov_status='EN PROCESO' AND documento_id=ID);
    IF TIPO = "FINALIZAR" THEN 
    
    UPDATE movimiento SET mov_status='FINALIZADO' WHERE movimiento_id=@IDMOVIMIENTO;
    UPDATE documento SET area_origen=ORIGEN, area_destino=ORIGEN, doc_status='FINALIZADO'
    WHERE documento_id=ID;
    INSERT INTO movimiento(documento_id, area_origen_id, areadestino_id, mov_fecharegistro, mov_descripcion, mov_status, usuario_id, mov_archivo)
    VALUES (ID, ORIGEN, ORIGEN, NOW(), DESCRIPCION, 'FINALIZADO', IDUSUARIO, RUTA);
    
    ELSE
    
    UPDATE movimiento SET mov_status='DERIVADO' WHERE movimiento_id=@IDMOVIMIENTO;
    UPDATE documento SET area_origen=ORIGEN, area_destino=DESTINO, doc_status = 'EN PROCESO'
    WHERE documento_id=ID;
    INSERT INTO movimiento(documento_id, area_origen_id, areadestino_id, mov_fecharegistro, mov_descripcion, mov_status, usuario_id, mov_archivo)
    VALUES (ID, ORIGEN, DESTINO, NOW(), DESCRIPCION, 'EN PROCESO', IDUSUARIO, RUTA);
    
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_USUARIO` (IN `USU` VARCHAR(250), IN `CONTRA` VARCHAR(255), IN `IDEMPLEADO` INT, IN `IDAREA` INT, IN `ROL` VARCHAR(25))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD := (SELECT COUNT(*) FROM usuario where usu_usuario=USU);
IF @CANTIDAD = 0 THEN
INSERT INTO 
usuario(usu_usuario, usu_contra, empleado_id,area_id,usu_rol,usu_feccreacion,usu_status,universidad_id) VALUES(USU,CONTRA,IDEMPLEADO,IDAREA,ROL,CURDATE(),'ACTIVO',1);
SELECT 1;
ELSE
SELECT 2;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_WIDGET` ()   SELECT
  (select COUNT(*) FROM documento),
  (select COUNT(*) FROM documento where doc_status="EN PROCESO"),
  (select COUNT(*) FROM documento where doc_status="FINALIZADO")
FROM
  documento LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_WIDGET_AREA` (IN `IDUSUARIO` INT)   BEGIN
    DECLARE IDAREA INT;

    -- Obtener el área del usuario
    SELECT area_id INTO IDAREA FROM usuario WHERE usu_id = IDUSUARIO LIMIT 1;

    -- Retornar conteos de documentos vinculados a esa área en movimientos
    SELECT
        -- Total trámites vinculados al área (como origen o destino en movimientos)
        (SELECT COUNT(DISTINCT d.documento_id)
         FROM documento d
         INNER JOIN movimiento m ON d.documento_id = m.documento_id
         WHERE m.area_origen_id = IDAREA OR m.areadestino_id = IDAREA
        ) AS total_tramites,

        -- Trámites en proceso
        (SELECT COUNT(DISTINCT d.documento_id)
         FROM documento d
         INNER JOIN movimiento m ON d.documento_id = m.documento_id
         WHERE (m.area_origen_id = IDAREA OR m.areadestino_id = IDAREA)
           AND d.doc_status = 'EN PROCESO'
        ) AS tramites_en_proceso,

        -- Trámites finalizados
        (SELECT COUNT(DISTINCT d.documento_id)
         FROM documento d
         INNER JOIN movimiento m ON d.documento_id = m.documento_id
         WHERE (m.area_origen_id = IDAREA OR m.areadestino_id = IDAREA)
           AND d.doc_status = 'FINALIZADO'
        ) AS tramites_finalizados;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_VERIFICAR_USUARIO` (IN `USU` VARCHAR(255))   SELECT
	usuario.usu_id, 
	usuario.usu_usuario, 
	usuario.usu_contra, 
	usuario.usu_feccreacion, 
	usuario.usu_fecupdate, 
	usuario.empleado_id, 
	usuario.usu_observacion, 
	usuario.usu_status, 
	usuario.area_id, 
	usuario.usu_rol, 
	usuario.universidad_id
FROM
	usuario
	where usuario.usu_usuario  = BINARY USU$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `area_cod` int(11) NOT NULL COMMENT 'Codigo auto-incrementado del movimiento del area',
  `area_nombre` varchar(50) NOT NULL COMMENT 'nombre del area',
  `area_fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'fecha del registro del movimiento',
  `area_estado` enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO' COMMENT 'estado del area'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Entidad Area' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`area_cod`, `area_nombre`, `area_fecha_registro`, `area_estado`) VALUES
(1, 'Secretaría Académica', '2025-03-24 20:05:32', 'ACTIVO'),
(2, 'Vicedecanato', '2025-03-24 20:08:41', 'ACTIVO'),
(3, 'Decanato', '2025-03-24 21:53:40', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `documento_id` char(12) NOT NULL,
  `doc_dniremitente` char(8) NOT NULL,
  `doc_nombreremitente` varchar(150) NOT NULL,
  `doc_apepatremitente` varchar(50) NOT NULL,
  `doc_apematremitente` varchar(50) NOT NULL,
  `doc_celremitente` char(9) NOT NULL,
  `doc_emailremitente` varchar(150) NOT NULL,
  `tipodocumento_id` int(11) NOT NULL,
  `doc_nrodocumento` varchar(12) NOT NULL,
  `doc_descripcion` varchar(255) NOT NULL,
  `doc_asunto` varchar(255) NOT NULL,
  `doc_archivo` text NOT NULL,
  `doc_fecharegistro` datetime DEFAULT current_timestamp(),
  `area_id` int(11) DEFAULT 1,
  `doc_status` enum('EN PROCESO','OBSERVADO','FINALIZADO') NOT NULL,
  `area_origen` int(11) NOT NULL DEFAULT 0,
  `area_destino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `empleado_id` int(11) NOT NULL,
  `emple_nombre` varchar(150) DEFAULT NULL,
  `emple_apepat` varchar(100) DEFAULT NULL,
  `emple_apemat` varchar(100) DEFAULT NULL,
  `emple_feccreacion` date DEFAULT current_timestamp(),
  `emple_fechanacimiento` date DEFAULT NULL,
  `emple_nrodocumento` char(12) DEFAULT NULL,
  `emple_cel` char(9) DEFAULT NULL,
  `emple_email` varchar(250) DEFAULT NULL,
  `emple_status` enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO',
  `emple_direccion` varchar(255) DEFAULT NULL,
  `empl_fotoperfil` varchar(255) NOT NULL DEFAULT 'Fotos/admin.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`empleado_id`, `emple_nombre`, `emple_apepat`, `emple_apemat`, `emple_feccreacion`, `emple_fechanacimiento`, `emple_nrodocumento`, `emple_cel`, `emple_email`, `emple_status`, `emple_direccion`, `empl_fotoperfil`) VALUES
(1, 'Edwin Junior', 'Jara', 'Bocanegra', '2025-03-24', '2003-10-26', '72456980', '904115565', 'edwin.jara@upch.pe', 'ACTIVO', 'Puente Piedra', 'controller/empleado/FOTOS/admin.png'),
(2, 'Stephany', 'Toribio', 'Alvarado', '2025-03-26', '2003-11-26', '12345678', '987654321', 'stephany.toribio@upch.pe', 'ACTIVO', 'Ventanilla', 'controller/empleado/FOTOS/admin.png'),
(3, 'Alexandra', 'Lima', 'Quispe', '2025-04-06', '2001-10-10', '29345678', '937654876', 'alexandra.lima@upch.pe', 'ACTIVO', 'Los Olivos', 'controller/empleado/fotos/admin.png'),
(4, 'Admin', 'FACI', 'FAVEZ', '2025-04-06', '2000-05-05', '00000000', '987654321', 'admin.admin@upch.pe', 'ACTIVO', 'Admin', 'controller/empleado/fotos/admin.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `movimiento_id` int(11) NOT NULL,
  `documento_id` char(12) NOT NULL,
  `area_origen_id` int(11) DEFAULT NULL,
  `areadestino_id` int(11) NOT NULL,
  `mov_fecharegistro` datetime DEFAULT current_timestamp(),
  `mov_descripcion` varchar(255) NOT NULL,
  `mov_status` enum('EN PROCESO','OBSERVADO','DERIVADO','FINALIZADO') DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `mov_archivo` text DEFAULT NULL,
  `mov_descripcion_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `tipodocumento_id` int(11) NOT NULL COMMENT 'Codigo auto-incrementado del tipo documento',
  `tipodo_descripcion` varchar(50) NOT NULL COMMENT 'Descripcion del  tipo documento',
  `tipodo_estado` enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO' COMMENT 'estado del tipo de documento',
  `tipodo_fregistro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Entidad Documento' ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`tipodocumento_id`, `tipodo_descripcion`, `tipodo_estado`, `tipodo_fregistro`) VALUES
(1, 'Trámite Académico', 'ACTIVO', '2025-03-24 23:43:00'),
(2, 'Trámite Administrativo', 'ACTIVO', '2025-03-24 23:59:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidad`
--

CREATE TABLE `universidad` (
  `universidad_id` int(11) NOT NULL,
  `uni_razon` varchar(250) NOT NULL,
  `uni_email` varchar(250) NOT NULL,
  `uni_cod` varchar(10) NOT NULL,
  `uni_telefono` varchar(20) NOT NULL,
  `uni_direccion` varchar(250) NOT NULL,
  `uni_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `universidad`
--

INSERT INTO `universidad` (`universidad_id`, `uni_razon`, `uni_email`, `uni_cod`, `uni_telefono`, `uni_direccion`, `uni_logo`) VALUES
(1, 'UPCH', 'upch@upch.pe', '2025', '123456789', 'Av. Honorio Delgado 430, San Martin de Porres 15102', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_id` int(11) NOT NULL,
  `usu_usuario` varchar(250) DEFAULT '',
  `usu_contra` varchar(250) DEFAULT NULL,
  `usu_feccreacion` date DEFAULT current_timestamp(),
  `usu_fecupdate` date DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `usu_observacion` varchar(250) DEFAULT NULL,
  `usu_status` enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO',
  `area_id` int(11) DEFAULT NULL,
  `usu_rol` enum('ADMIN','SECRETARÍA ACADÉMICA','VICEDECANATO','DECANATO') NOT NULL,
  `universidad_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_id`, `usu_usuario`, `usu_contra`, `usu_feccreacion`, `usu_fecupdate`, `empleado_id`, `usu_observacion`, `usu_status`, `area_id`, `usu_rol`, `universidad_id`) VALUES
(1, 'admin', '$2y$12$FBzh4dfZiEH6.ukDcYPA7OwGVLkttoh7SJZtBLKNeKbw9W8nr35PO', '2025-03-24', NULL, 4, NULL, 'ACTIVO', 1, 'ADMIN', 1),
(2, 'edwinjara', '$2y$12$bAVg40.oWvel1Bw6sgv9Z.8e.HZlV8bQB2bumHEwA8J.EUnJNiVCG', '2025-03-28', NULL, 1, NULL, 'ACTIVO', 1, 'SECRETARÍA ACADÉMICA', 1),
(3, 'stephanytoribio', '$2y$12$V9CopqMHyzo09OKBNujbvuukAJOgrZHJu9UwUkMZnPBUnz8F4SKkG', '2025-04-06', NULL, 2, NULL, 'ACTIVO', 2, 'VICEDECANATO', 1),
(4, 'alexandralima', '$2y$12$y8V/V6iLgklQOFCY3RnHjuTZuAfRY7K0H.wxQVvPD0kuc7O.FRKsy', '2025-04-06', NULL, 3, NULL, 'ACTIVO', 3, 'DECANATO', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_cod`) USING BTREE,
  ADD UNIQUE KEY `unico` (`area_nombre`) USING BTREE;

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`documento_id`) USING BTREE,
  ADD KEY `tipodocumento_id` (`tipodocumento_id`) USING BTREE,
  ADD KEY `documento_ibfk_2` (`area_id`),
  ADD KEY `documento_ibfk_3` (`area_origen`),
  ADD KEY `documento_ibfk_4` (`area_destino`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`empleado_id`) USING BTREE;

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`movimiento_id`) USING BTREE,
  ADD KEY `area_origen_id` (`area_origen_id`) USING BTREE,
  ADD KEY `areadestino_id` (`areadestino_id`) USING BTREE,
  ADD KEY `usuario_id` (`usuario_id`) USING BTREE,
  ADD KEY `documento_id` (`documento_id`) USING BTREE;

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`tipodocumento_id`) USING BTREE;

--
-- Indices de la tabla `universidad`
--
ALTER TABLE `universidad`
  ADD PRIMARY KEY (`universidad_id`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id`) USING BTREE,
  ADD KEY `empleado_id` (`empleado_id`) USING BTREE,
  ADD KEY `area_id` (`area_id`) USING BTREE,
  ADD KEY `universidad_id` (`universidad_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `area_cod` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Codigo auto-incrementado del movimiento del area', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `empleado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `movimiento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `tipodocumento_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Codigo auto-incrementado del tipo documento', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `universidad`
--
ALTER TABLE `universidad`
  MODIFY `universidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`tipodocumento_id`) REFERENCES `tipo_documento` (`tipodocumento_id`),
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`area_origen`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `documento_ibfk_4` FOREIGN KEY (`area_destino`) REFERENCES `area` (`area_cod`);

--
-- Filtros para la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `movimiento_ibfk_1` FOREIGN KEY (`area_origen_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `movimiento_ibfk_2` FOREIGN KEY (`areadestino_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `movimiento_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usu_id`),
  ADD CONSTRAINT `movimiento_ibfk_4` FOREIGN KEY (`documento_id`) REFERENCES `documento` (`documento_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleado` (`empleado_id`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_cod`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`universidad_id`) REFERENCES `universidad` (`universidad_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
