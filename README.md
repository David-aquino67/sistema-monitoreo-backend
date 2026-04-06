# SIMF - Sistema de Monitoreo  (Backend)
Sistema de monitoreo de servidores en tiempo real que actúa como un Proxy de Datos, el backend extrae información de disponibilidad desde UptimeKuma, recupera credenciales de acceso desde mRemoteNG mediante descifrado AES-128, las mapea con unidades del sistema SIBOP y las emite mediante WebSockets.

## Características Principales
* Conexión Multi-Base de Datos: Integración híbrida entre SQL Server (Datos maestros SIBOP y mRemoteNG) y MariaDB (Métricas de UptimeKuma).
* Motor de Criptografía: Módulo de descifrado simétrico (AES-128-CBC) para la recuperación de credenciales de administrador desde la base de datos de mRemoteNG
* Mapeo Dinámico: Tabla de sincronización (monitores_servidores) que vincula IDs externos con unidades internas.
* WebSockets en Tiempo Real: Difusión de cambios de estado mediante Laravel Reverb/Pusher sin recarga de página.
* Automatización: Tarea programada (Scheduler) que monitorea latidos de servidor cada minuto.

## Tecnologías Utilizadas
* Framework: Laravel 11
* Bases de Datos: * SQL Server (smars): Almacenamiento de mapeos, persistencia local y repositorio de mRemoteNG (tblCons).
* MariaDB/MySQL: Fuente de datos externa (kuma1).
* Real-time: Laravel Reverb / Broadcasting (Eventos).
* Lenguaje: PHP 8.2+

# Arquitectura de Datos
* El sistema funciona como un flujo de eventos y servicios de cuatro niveles:
* Capa de Extracción: El comando check:server-status consulta la tabla heartbeat en la base de datos de UptimeKuma.
* Capa de Transformación: Laravel utiliza el modelo MonitorMapeo en SQL Server para traducir el monitor_id a un sibop_id (Unidad Médica/Estación).
* Capa de Difusión: El evento ServerStatusCambio emite el payload procesado a través de canales públicos.

## Instalación y Configuración 

Clonar el repositorio: 
```
git clone https://github.com/imssci/smars_frontend.git
```
Instalar dependencias: 
```
composer install 
 ```

### Configurar entorno: 
### Configuración del Entorno (.env) y database.php
Es necesario configurar ambas conexiones para el correcto funcionamiento:

```
# Conexión Principal - SQL Server (SMARS)
DB_CONNECTION=sqlsrv
DB_HOST=(localhost)
DB_DATABASE=smars

# Conexión Secundaria - MariaDB (UptimeKuma)
DB_HOST_KUMA=1.1.1.1
DB_PORT_KUMA=3306
DB_DATABASE_KUMA=kuma
DB_USERNAME_KUMA=user
DB_PASSWORD_KUMA=***********
```
#### Ejecución (Modo Desarrollo)
Para que el sistema procese y envíe datos automáticamente, ejecuta en terminales separadas:
Servidor API:
```
php artisan serve
```
Servidor WebSockets:
```
php artisan reverb:start --debug
```
Procesador de Tareas (Scheduler):
```
php artisan schedule:work
```
