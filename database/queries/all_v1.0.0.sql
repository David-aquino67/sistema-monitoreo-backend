BEGIN TRY
SET NOCOUNT ON;
PRINT 'INCIA CONFIGURACIÓN INICIAL'

    USE master;

    IF( DB_ID('smars') IS NOT NULL )
    BEGIN
        DROP DATABASE smars;
    END


    CREATE DATABASE smars COLLATE SQL_latin1_General_CP1_CS_AS;

PRINT 'TERMINA CONFIGURACIÓN INICIAL EXITOSAMENTE'
END TRY
BEGIN CATCH
    PRINT 'ERROR EN CONFIGURACIÓN INICIAL'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
GO
USE smars;
GO
PRINT '';



BEGIN TRY
SET NOCOUNT ON;
PRINT 'INCIA CREACIÓN DE TABLAS DE LARAVEL Y SIBOP'

    CREATE TABLE personal_access_tokens(

        --Columnas de datos
        id                                          BIGINT                          PRIMARY KEY IDENTITY NOT NULL,
        tokenable_type                              NVARCHAR(255)                   NOT NULL,
        tokenable_id                                BIGINT                          NOT NULL,
        name                                        NVARCHAR(255)                   NOT NULL,
        token                                       NVARCHAR(64)                    NOT NULL,
        abilities                                   NVARCHAR(MAX)                   NULL,
        last_used_at                                DATETIME2                       NULL,
        expires_at                                  DATETIME2                       NULL,
        created_at                                  DATETIME2                       NULL,
        updated_at                                  DATETIME2                       NULL
        
    );

   CREATE TABLE cache(

		[key]                                       VARCHAR(255)                    PRIMARY KEY,
		value                                       NVARCHAR(MAX)                   NOT NULL,               
		expiration                                  BIGINT                          NOT NULL

	);


	CREATE TABLE permisos(

        --Columnas de datos
        ability										VARCHAR(20)						NOT NULL PRIMARY KEY,
        descripcion									VARCHAR(255)					NOT NULL

    );

    CREATE TABLE usuarios(

        --Columnas de cajon
        REGISTRO_fecha_creacion                     DATETIME2                       DEFAULT GETDATE(),
        REGISTRO_fecha_ultimo_cambio                DATETIME2                       DEFAULT NULL,

		--Columnas de llave foránea
		FK_permiso_ability                          VARCHAR(20)                     NOT NULL FOREIGN KEY REFERENCES permisos(ability),

        --Columnas de datos
        id_sibop                                    BIGINT                          NOT NULL PRIMARY KEY, 
        token                                       NVARCHAR(64)                    DEFAULT NULL

    );

    CREATE TABLE versiones(

        numero_version                              VARCHAR(20)                    PRIMARY KEY NOT NULL,
        titulo_version                              NVARCHAR(100)                  NOT NULL,
        fecha_liberacion                            DATETIME2                      NOT NULL

    );

    CREATE TABLE historial_versiones(

        REGISTRO_id                                 BIGINT                          NOT NULL PRIMARY KEY IDENTITY,         
        numero_version                              VARCHAR(20)                     NOT NULL FOREIGN KEY REFERENCES versiones(numero_version),
        titulo_cambio                               NVARCHAR(255)                   NOT NULL,              
        descripcion_cambio                          NVARCHAR(MAX)                   NOT NULL

    );

	CREATE TABLE archivos(

		--Columnas de cajon
		REGISTRO_id                                 BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
		REGISTRO_fecha_creacion						DATETIME2						DEFAULT GETDATE(),
		REGISTRO_fecha_ultimo_cambio				DATETIME2						DEFAULT NULL,

		--Columnas de datos del archivo
		system_path                                 VARCHAR(255)                    NOT NULL

	);
    
	-- Laravel Auditing Table
	CREATE TABLE [audits] (
		[id] BIGINT IDENTITY(1,1) NOT NULL,
		
		-- Información del Usuario (Morph)
		[user_type] NVARCHAR(255) NULL,
		[user_id] BIGINT NULL,
		
		-- Evento (created, updated, deleted, etc)
		[event] NVARCHAR(255) NOT NULL,
		
		-- Modelo Auditado (Morphs: auditable_type y auditable_id)
		[auditable_type] NVARCHAR(255) NOT NULL,
		[auditable_id] BIGINT NOT NULL,
		
		-- Valores (Usamos NVARCHAR(MAX) para JSON/Textos largos)
		[old_values] NVARCHAR(MAX) NULL,
		[new_values] NVARCHAR(MAX) NULL,
		
		-- Metadatos
		[url] NVARCHAR(MAX) NULL,
		[ip_address] NVARCHAR(45) NULL,
		[user_agent] NVARCHAR(1023) NULL,
		[tags] NVARCHAR(255) NULL,
		
		-- Timestamps de Laravel
		[created_at] DATETIME NULL,
		[updated_at] DATETIME NULL,

		-- Llave Primaria
		CONSTRAINT [PK_audits] PRIMARY KEY CLUSTERED ([id] ASC)
	);

	-- Índices para mejorar el rendimiento de las relaciones polimórficas
	CREATE INDEX [audits_user_id_user_type_index] ON [audits] ([user_id], [user_type]);
	CREATE INDEX [audits_auditable_type_auditable_id_index] ON [audits] ([auditable_type], [auditable_id]);

	CREATE TABLE jobs(

        id                                          INT                             PRIMARY KEY IDENTITY NOT NULL,             
        queue                                       NVARCHAR(255)                   NOT NULL,                  
        payload                                     NVARCHAR(MAX)                   NOT NULL,                
        attempts                                    INT                             NOT NULL DEFAULT 0,               
        reserved_at                                 BIGINT                          NULL,                     
        available_at                                BIGINT                          NOT NULL,                
        created_at                                  BIGINT                          NOT NULL                  

    );

    CREATE TABLE failed_jobs (

        id                                          BIGINT                          PRIMARY KEY IDENTITY, 
        uuid                                        UNIQUEIDENTIFIER                DEFAULT NEWID() NOT NULL,
        connection                                  NVARCHAR(MAX)                   NOT NULL,
        queue                                       NVARCHAR(MAX)                   NOT NULL, 
        payload                                     NVARCHAR(MAX)                   NOT NULL, 
        exception                                   NVARCHAR(MAX)                   NOT NULL, 
        failed_at                                   DATETIME2                       DEFAULT GETDATE() NOT NULL 

    );

    CREATE TABLE [dbo].[sessions](
        [id] [nvarchar](255) NOT NULL,
        [user_id] [bigint] NULL,
        [ip_address] [varchar](45) NULL,
        [user_agent] [nvarchar](max) NULL,
        [payload] [nvarchar](max) NOT NULL,
        [last_activity] [int] NOT NULL,
    PRIMARY KEY CLUSTERED 
    (
        [id] ASC
    ) WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
    ) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY];

PRINT 'TERMINA CREACIÓN DE TABLAS DE LARAVEL Y SIBOP EXITOSAMENTE'
END TRY
BEGIN CATCH
    PRINT 'ERROR EN CREACIÓN DE TABLAS DE LARAVEL Y SIBOP'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
PRINT '';





BEGIN TRY
SET NOCOUNT ON;
PRINT 'INCIA CREACIÓN DE TABLAS'

    CREATE TABLE monitores_servidores(
        
        --Columnas de cajon
		REGISTRO_id                                 BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
		REGISTRO_fecha_creacion						DATETIME2						DEFAULT GETDATE(),
		REGISTRO_fecha_ultimo_cambio				DATETIME2						DEFAULT NULL,

        --Columnas de llaves foraneas
		FK_id_unidad                                BIGINT                          NOT NULL,
		FK_id_monitor_kuma						    BIGINT                          NOT NULL

    );

PRINT 'TERMINA CREACIÓN DE TABLAS EXITOSAMENTE'
END TRY
BEGIN CATCH
    PRINT 'ERROR EN CREACIÓN DE TABLAS'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
PRINT '';








BEGIN TRY
SET NOCOUNT ON;
PRINT 'INCIA INSERCIÓN DE DATOS (INFORMACIÓN ESTÁTICA)'

	INSERT INTO permisos(ability, descripcion) VALUES 
		('admin', 'Administrador'),
		('temporal', 'Monitoreo de fin de semana'),	
		('monitoreo', 'Monitoreo');

	INSERT INTO usuarios(id_sibop, FK_permiso_ability) VALUES 
		(1, 'admin');

	INSERT INTO monitores_servidores(FK_id_unidad, FK_id_monitor_kuma) VALUES 
		(64, 15), -- UMF 9 SIBOP, Kuma UMF 9 HTTP
		(64, 16); -- UMF 9 SIBOP, Kuma UMF 9 Red

	INSERT INTO versiones(numero_version, titulo_version, fecha_liberacion) VALUES 
		('v1.0.0', 'Versión inicial del sistema', GETDATE());

	INSERT INTO historial_versiones(numero_version, titulo_cambio, descripcion_cambio) VALUES 
		('v1.0.0', 'Página de estado', 'Se añade pagina de estado de los servidores SIMF');

PRINT 'TERMINA INSERCIÓN DE DATOS (INFORMACIÓN ESTÁTICA) EXITOSAMENTE'
END TRY
BEGIN CATCH
    PRINT 'ERROR EN INSERCIÓN DE DATOS (INFORMACIÓN ESTÁTICA)'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
PRINT '';
