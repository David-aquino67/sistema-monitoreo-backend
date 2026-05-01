USE smars;
INSERT INTO versiones(numero_version, titulo_version, fecha_liberacion) VALUES
	('v0.2.0', 'Simplificación de cards de reestablecimiento', GETDATE());

INSERT INTO historial_versiones(numero_version, titulo_cambio, descripcion_cambio) VALUES
(
	'v0.2.0',
	'Simplificación de cards de reestablecimiento',
	'Ahora solo hay una card de reeestablecimiento por unidad que incluye datos de los sensores de red (router) y de http'
);

ALTER TABLE monitores_servidores ADD tipo_monitor VARCHAR(10) NOT NULL DEFAULT 'http';

GO

INSERT INTO monitores_servidores (FK_id_unidad, FK_id_monitor_kuma, tipo_monitor) VALUES
	(57, 1, 'http');

GO

UPDATE monitores_servidores SET tipo_monitor = 'red_router' WHERE REGISTRO_id IN (
	3, 5, 7, 9, 11, 13, 15, 2, 17, 19, 21, 23, 26, 27, 29, 31, 33, 35, 37, 39, 41,
	43, 45, 47, 49, 51, 53, 55, 57, 59, 61, 63, 65, 67, 69, 71, 73, 75, 77, 79, 81,
	83, 85, 87, 89, 91, 93, 95, 97, 99, 101, 103
);

GO

DELETE FROM monitores_servidores WHERE REGISTRO_id IN (92, 93, 1, 2);
UPDATE monitores_servidores SET tipo_monitor = 'red', FK_id_monitor_kuma = 26 WHERE REGISTRO_id = 25;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 103 WHERE REGISTRO_id = 102;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 104 WHERE REGISTRO_id = 103;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 16 WHERE REGISTRO_id = 1;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 28 WHERE REGISTRO_id = 27;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 27 WHERE REGISTRO_id = 26;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 30 WHERE REGISTRO_id = 29;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 29 WHERE REGISTRO_id = 28;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 32 WHERE REGISTRO_id = 31;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 31 WHERE REGISTRO_id = 30;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 34 WHERE REGISTRO_id = 33;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 33 WHERE REGISTRO_id = 32;

GO

UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 35 WHERE REGISTRO_id = 34;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 36 WHERE REGISTRO_id = 35;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 37 WHERE REGISTRO_id = 36;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 38 WHERE REGISTRO_id = 37;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 39 WHERE REGISTRO_id = 38;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 40 WHERE REGISTRO_id = 39;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 41 WHERE REGISTRO_id = 40;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 42 WHERE REGISTRO_id = 41;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 43 WHERE REGISTRO_id = 42;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 44 WHERE REGISTRO_id = 43;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 45 WHERE REGISTRO_id = 44;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 46 WHERE REGISTRO_id = 45;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 47 WHERE REGISTRO_id = 46;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 48 WHERE REGISTRO_id = 47;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 49 WHERE REGISTRO_id = 48;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 50 WHERE REGISTRO_id = 49;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 51 WHERE REGISTRO_id = 50;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 52 WHERE REGISTRO_id = 51;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 53 WHERE REGISTRO_id = 52;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 54 WHERE REGISTRO_id = 53;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 55 WHERE REGISTRO_id = 54;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 56 WHERE REGISTRO_id = 55;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 57 WHERE REGISTRO_id = 56;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 58 WHERE REGISTRO_id = 57;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 59 WHERE REGISTRO_id = 58;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 60 WHERE REGISTRO_id = 59;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 61 WHERE REGISTRO_id = 60;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 62 WHERE REGISTRO_id = 61;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 63 WHERE REGISTRO_id = 62;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 64 WHERE REGISTRO_id = 63;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 65 WHERE REGISTRO_id = 64;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 66 WHERE REGISTRO_id = 65;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 67 WHERE REGISTRO_id = 66;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 68 WHERE REGISTRO_id = 67;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 69 WHERE REGISTRO_id = 68;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 70 WHERE REGISTRO_id = 69;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 71 WHERE REGISTRO_id = 70;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 72 WHERE REGISTRO_id = 71;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 73 WHERE REGISTRO_id = 72;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 74 WHERE REGISTRO_id = 73;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 75 WHERE REGISTRO_id = 74;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 76 WHERE REGISTRO_id = 75;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 77 WHERE REGISTRO_id = 76;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 78 WHERE REGISTRO_id = 77;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 79 WHERE REGISTRO_id = 78;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 80 WHERE REGISTRO_id = 79;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 81 WHERE REGISTRO_id = 80;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 82 WHERE REGISTRO_id = 81;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 83 WHERE REGISTRO_id = 82;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 84 WHERE REGISTRO_id = 83;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 85 WHERE REGISTRO_id = 84;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 86 WHERE REGISTRO_id = 85;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 87 WHERE REGISTRO_id = 86;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 88 WHERE REGISTRO_id = 87;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 89 WHERE REGISTRO_id = 88;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 90 WHERE REGISTRO_id = 89;
UPDATE monitores_servidores SET tipo_monitor = 'http', FK_id_monitor_kuma = 91 WHERE REGISTRO_id = 90;
UPDATE monitores_servidores SET tipo_monitor = 'red_router', FK_id_monitor_kuma = 92 WHERE REGISTRO_id = 91;

GO

INSERT INTO monitores_servidores (FK_id_unidad, FK_id_monitor_kuma, tipo_monitor) VALUES
	(110, 101, 'http'),
	(110, 102, 'red_router'),
	(111, 24, 'http'),
	(111, 25, 'red_router');

GO

UPDATE monitores_servidores SET tipo_monitor = 'red_router' WHERE REGISTRO_id = 25

GO

--Helper
SELECT
    ms.REGISTRO_id,
    ms.FK_id_unidad,
    ms.FK_id_monitor_kuma,
    u.descripcion,
    ms.tipo_monitor,
    kuma.name AS nombre_monitor_kuma
FROM monitores_servidores ms
INNER JOIN sibop.dbo.unidades u
    ON u.REGISTRO_id = ms.FK_id_unidad
INNER JOIN OPENQUERY([KUMA_SERVER], 'SELECT id, name FROM `monitor`') AS kuma
    ON kuma.id = ms.FK_id_monitor_kuma
ORDER BY u.descripcion, ms.tipo_monitor;


-- tabla de Catálogo de Acciones
CREATE TABLE cat_acciones (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              nombre VARCHAR(255) NOT NULL,
                              ruta_script VARCHAR(255) NOT NULL,
                              descripcion VARCHAR(255) DEFAULT NULL,
                              created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                              updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- tabla de Histórico de Acciones
CREATE TABLE historico_acciones (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    unidad_id INT NOT NULL,
                                    accion_id INT NOT NULL,
                                    usuario_sibop_id INT NOT NULL,
                                    resultado_salida TEXT DEFAULT NULL,
                                    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                                    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Definir la relación foránea
                                    CONSTRAINT fk_accion
                                        FOREIGN KEY (accion_id)
                                            REFERENCES cat_acciones(id)
) ENGINE=InnoDB;
