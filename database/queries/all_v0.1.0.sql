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
        (57, 2),
        (58, 3),
        (58, 4),
        (59, 5),
        (59, 6),
        (60, 7),
        (60, 8),
        (61, 9),
        (61, 10),
        (62, 11),
        (62, 12),
        (63, 13),
        (63, 14),
        (64, 15),
        (64, 16),
        (65, 17),
        (65, 18),
        (66, 19),
        (66, 20),
        (67, 21),
        (67, 22),
        (68, 23),
        (68, 24),
        (69, 25),
        (69, 26),
        (70, 27),
        (70, 28),
        (71, 29),
        (71, 30),
        (72, 31),
        (72, 32),
        (73, 33),
        (73, 34),
        (74, 35),
        (74, 36),
        (75, 37),
        (75, 38),
        (76, 39),
        (76, 40),
        (77, 41),
        (77, 42),
        (78, 43),
        (78, 44),
        (79, 45),
        (79, 46),
        (80, 47),
        (80, 48),
        (81, 49),
        (81, 50),
        (82, 51),
        (82, 52),
        (83, 53),
        (83, 54),
        (84, 55),
        (84, 56),
        (85, 57),
        (85, 58),
        (86, 59),
        (86, 60),
        (87, 61),
        (87, 62),
        (88, 63),
        (88, 64),
        (89, 65),
        (89, 66),
        (90, 67),
        (90, 68),
        (91, 69),
        (91, 70),
        (92, 71),
        (92, 72),
        (93, 73),
        (93, 74),
        (94, 75),
        (94, 76),
        (95, 77),
        (95, 78),
        (96, 79),
        (96, 80),
        (97, 81),
        (97, 82),
        (98, 83),
        (98, 84),
        (99, 85),
        (99, 86),
        (100, 87),
        (100, 88),
        (101, 89),
        (101, 90),
        (102, 91),
        (102, 92),
        (107, 93),
        (107, 94),
        (112 ,95),
        (112, 96),
        (108, 97),
        (108, 98),
        (109, 99),
        (109, 100),
        (113, 101),
        (113, 102);

	INSERT INTO versiones(numero_version, titulo_version, fecha_liberacion) VALUES
		('v1.1.0', 'Versión inicial del sistema', GETDATE());

	INSERT INTO historial_versiones(numero_version, titulo_cambio, descripcion_cambio) VALUES
		'v1.1.0', 
    'Infraestructura de Conexiones', 
    'Se añadieron las tablas estructurales de mRemoteNG (tblCons, tblRoot, tblConfig) para la gestión centralizada de accesos remotos.';

PRINT 'TERMINA INSERCIÓN DE DATOS (INFORMACIÓN ESTÁTICA) EXITOSAMENTE'
END TRY
BEGIN CATCH
    PRINT 'ERROR EN INSERCIÓN DE DATOS (INFORMACIÓN ESTÁTICA)'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
PRINT '';




CREATE TABLE [dbo].[tblCons] (
[ID] [int] IDENTITY (1001, 1) NOT NULL ,
[ConstantID] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[PositionID] [int] NOT NULL ,
[ParentID] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[LastChange] [datetime] NOT NULL ,
[Name] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[Type] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[Expanded] [bit] NOT NULL ,
[Description] [varchar] (1024) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[Icon] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[Panel] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[Username] [varchar] (512) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[DomainName] [varchar] (512) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[Password] [varchar] (1024) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[Hostname] [varchar] (512) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[Protocol] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[PuttySession] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[Port] [int] NOT NULL ,
[ConnectToConsole] [bit] NOT NULL ,
[UseCredSsp] [bit] NOT NULL ,
[RenderingEngine] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[ICAEncryptionStrength] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[RDPAuthenticationLevel] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[Colors] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[Resolution] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[DisplayWallpaper] [bit] NOT NULL ,
[DisplayThemes] [bit] NOT NULL ,
[EnableFontSmoothing] [bit] NOT NULL ,
[EnableDesktopComposition] [bit] NOT NULL ,
[CacheBitmaps] [bit] NOT NULL ,
[RedirectDiskDrives] [bit] NOT NULL ,
[RedirectPorts] [bit] NOT NULL ,
[RedirectPrinters] [bit] NOT NULL ,
[RedirectSmartCards] [bit] NOT NULL ,
[RedirectSound] [varchar] (64) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[RedirectKeys] [bit] NOT NULL ,
[Connected] [bit] NOT NULL ,
[PreExtApp] [varchar] (256) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[PostExtApp] [varchar] (256) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[MacAddress] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[UserField] [varchar] (256) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[ExtApp] [varchar] (256) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCCompression] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCEncoding] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCAuthMode] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCProxyType] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCProxyIP] [varchar] (128) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCProxyPort] [int] NULL ,
[VNCProxyUsername] [varchar] (512) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCProxyPassword] [varchar] (1024) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCColors] [varchar] (10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCSmartSizeMode] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[VNCViewOnly] [bit] NOT NULL ,
[RDGatewayUsageMethod] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[RDGatewayHostname] [varchar] (512) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[RDGatewayUseConnectionCredentials] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[RDGatewayUsername] [varchar] (512) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[RDGatewayPassword] [varchar] (1024) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[RDGatewayDomain] [varchar] (512) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[InheritCacheBitmaps] [bit] NOT NULL ,
[InheritColors] [bit] NOT NULL ,
[InheritDescription] [bit] NOT NULL ,
[InheritDisplayThemes] [bit] NOT NULL ,
[InheritDisplayWallpaper] [bit] NOT NULL ,
[InheritEnableFontSmoothing] [bit] NOT NULL ,
[InheritEnableDesktopComposition] [bit] NOT NULL ,
[InheritDomain] [bit] NOT NULL ,
[InheritIcon] [bit] NOT NULL ,
[InheritPanel] [bit] NOT NULL ,
[InheritPassword] [bit] NOT NULL ,
[InheritPort] [bit] NOT NULL ,
[InheritProtocol] [bit] NOT NULL ,
[InheritPuttySession] [bit] NOT NULL ,
[InheritRedirectDiskDrives] [bit] NOT NULL ,
[InheritRedirectKeys] [bit] NOT NULL ,
[InheritRedirectPorts] [bit] NOT NULL ,
[InheritRedirectPrinters] [bit] NOT NULL ,
[InheritRedirectSmartCards] [bit] NOT NULL ,
[InheritRedirectSound] [bit] NOT NULL ,
[InheritResolution] [bit] NOT NULL ,
[InheritUseConsoleSession] [bit] NOT NULL ,
[InheritUseCredSsp] [bit] NOT NULL ,
[InheritRenderingEngine] [bit] NOT NULL ,
[InheritICAEncryptionStrength] [bit] NOT NULL ,
[InheritRDPAuthenticationLevel] [bit] NOT NULL ,
[InheritUsername] [bit] NOT NULL ,
[InheritPreExtApp] [bit] NOT NULL ,
[InheritPostExtApp] [bit] NOT NULL ,
[InheritMacAddress] [bit] NOT NULL ,
[InheritUserField] [bit] NOT NULL ,
[InheritExtApp] [bit] NOT NULL ,
[InheritVNCCompression] [bit] NOT NULL,
[InheritVNCEncoding] [bit] NOT NULL ,
[InheritVNCAuthMode] [bit] NOT NULL ,
[InheritVNCProxyType] [bit] NOT NULL ,
[InheritVNCProxyIP] [bit] NOT NULL ,
[InheritVNCProxyPort] [bit] NOT NULL ,
[InheritVNCProxyUsername] [bit] NOT NULL ,
[InheritVNCProxyPassword] [bit] NOT NULL ,
[InheritVNCColors] [bit] NOT NULL ,
[InheritVNCSmartSizeMode] [bit] NOT NULL ,
[InheritVNCViewOnly] [bit] NOT NULL ,
[InheritRDGatewayUsageMethod] [bit] NOT NULL ,
[InheritRDGatewayHostname] [bit] NOT NULL ,
[InheritRDGatewayUseConnectionCredentials] [bit] NOT NULL ,
[InheritRDGatewayUsername] [bit] NOT NULL ,
[InheritRDGatewayPassword] [bit] NOT NULL ,
[InheritRDGatewayDomain] [bit] NOT NULL ,
[LoadBalanceInfo] [varchar] (1024) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
[AutomaticResize] [bit] NOT NULL DEFAULT 1 ,
[InheritLoadBalanceInfo] [bit] NOT NULL DEFAULT 0 ,
[InheritAutomaticResize] [bit] NOT NULL DEFAULT 0
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[tblRoot] (
[Name] [varchar] (2048) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[Export] [bit] NOT NULL ,
[Protected] [varchar] (4048) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
[ConfVersion] [float] NOT NULL
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[tblUpdate] (
[LastUpdate] [datetime] NULL
) ON [PRIMARY]
GO

CREATE TABLE [dbo].[monitor_conexion] (
    [id] [int] IDENTITY(1,1) NOT NULL,
    [unidad_id] [int] NOT NULL,           -- ID que viene del SIBOP
    [constant_id] [varchar](128) NOT NULL, -- FK que apunta a tblCons.ConstantID
    [created_at] [datetime] DEFAULT GETDATE(),
    PRIMARY KEY CLUSTERED ([id] ASC)
) ON [PRIMARY];
GO

CREATE INDEX IX_monitor_conexion_unidad ON [monitor_conexion] (unidad_id);


-- test
USE smars_testing;
GO
SELECT * FROM monitor_conexion 

-- Ajustamos tu columna para que use la misma regla que mRemoteNG
ALTER TABLE [dbo].[monitor_conexion] 
ALTER COLUMN [constant_id] VARCHAR(128) COLLATE SQL_Latin1_General_CP1_CS_AS NOT NULL;
GO
GO

-- 2. Inserción Balanceada (110 campos)
INSERT INTO [dbo].[tblCons]
           ([ConstantID],[PositionID],[ParentID],[LastChange],[Name],[Type],[Expanded],[Description]
           ,[Icon],[Panel],[Username],[DomainName],[Password],[Hostname],[Protocol],[PuttySession]
           ,[Port],[ConnectToConsole],[UseCredSsp],[RenderingEngine],[ICAEncryptionStrength]
           ,[RDPAuthenticationLevel],[Colors],[Resolution],[DisplayWallpaper],[DisplayThemes]
           ,[EnableFontSmoothing],[EnableDesktopComposition],[CacheBitmaps],[RedirectDiskDrives]
           ,[RedirectPorts],[RedirectPrinters],[RedirectSmartCards],[RedirectSound],[RedirectKeys]
           ,[Connected],[PreExtApp],[PostExtApp],[MacAddress],[UserField],[ExtApp],[VNCCompression]
           ,[VNCEncoding],[VNCAuthMode],[VNCProxyType],[VNCProxyIP],[VNCProxyPort],[VNCProxyUsername]
           ,[VNCProxyPassword],[VNCColors],[VNCSmartSizeMode],[VNCViewOnly],[RDGatewayUsageMethod]
           ,[RDGatewayHostname],[RDGatewayUseConnectionCredentials],[RDGatewayUsername]
           ,[RDGatewayPassword],[RDGatewayDomain],[InheritCacheBitmaps],[InheritColors]
           ,[InheritDescription],[InheritDisplayThemes],[InheritDisplayWallpaper]
           ,[InheritEnableFontSmoothing],[InheritEnableDesktopComposition],[InheritDomain]
           ,[InheritIcon],[InheritPanel],[InheritPassword],[InheritPort],[InheritProtocol]
           ,[InheritPuttySession],[InheritRedirectDiskDrives],[InheritRedirectKeys]
           ,[InheritRedirectPorts],[InheritRedirectPrinters],[InheritRedirectSmartCards]
           ,[InheritRedirectSound],[InheritResolution],[InheritUseConsoleSession]
           ,[InheritUseCredSsp],[InheritRenderingEngine],[InheritICAEncryptionStrength]
           ,[InheritRDPAuthenticationLevel],[InheritUsername],[InheritPreExtApp]
           ,[InheritPostExtApp],[InheritMacAddress],[InheritUserField],[InheritExtApp]
           ,[InheritVNCCompression],[InheritVNCEncoding],[InheritVNCAuthMode],[InheritVNCProxyType]
           ,[InheritVNCProxyIP],[InheritVNCProxyPort],[InheritVNCProxyUsername]
           ,[InheritVNCProxyPassword],[InheritVNCColors],[InheritVNCSmartSizeMode]
           ,[InheritVNCViewOnly],[InheritRDGatewayUsageMethod],[InheritRDGatewayHostname]
           ,[InheritRDGatewayUseConnectionCredentials],[InheritRDGatewayUsername]
           ,[InheritRDGatewayPassword],[InheritRDGatewayDomain],[LoadBalanceInfo]
           ,[AutomaticResize],[InheritLoadBalanceInfo],[InheritAutomaticResize])
VALUES
    ('de7c5ca9-5c9f-451e-a52d-c45fc99413cb', 1, '0', '2026-03-24T11:56:50', 'develop', 'Connection', 0, '',
    'mRemoteNG', 'General', 'sa', '', 'CQ2njWKYZU1bzN9NAwsPbclMvnHOvhT8GI+8L/WP8eI=', '11.1.22.201', 'RDP', 'Default Settings',
    3389, 0, 1, 'IE', 'EncrBasic', 'NoAuth', 'Colors16Bit', 'FitToWindow', 
    0, 0, 0, 0, 0, 0, 0, 0, 0, 'DoNotPlay', 0,
    0, NULL, NULL, NULL, NULL, NULL, 'CompNone',
    'EncHextile', 'AuthVNC', 'ProxyNone', '', 0, '',
    '', 'ColNormal', 'SmartSAspect', 0, 'Never', 
    NULL, 'Yes', NULL, NULL, NULL, 0, 0,
    0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 0);
GO
-- 3. Vincular con la tabla de mapeo para Laravel
-- Borramos si existe y re-insertamos para la Unidad ID 1
use smars_testing
DELETE FROM [dbo].[monitor_conexion] WHERE [unidad_id] = 1;
INSERT INTO [dbo].[monitor_conexion] (unidad_id, constant_id, created_at)
VALUES (1, 'de7c5ca9-5c9f-451e-a52d-c45fc99413cb', GETDATE());
GO