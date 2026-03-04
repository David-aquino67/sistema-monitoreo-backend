# SIMF - Sistema de Monitoreo  (Backend)
Sistema de monitoreo de servidores en tiempo real que actúa como un Proxy de Datos, el backend extrae información de disponibilidad desde UptimeKuma, la mapea con unidades del sistema SIBOP y la despacha mediante WebSockets.

## Características Principales
* Conexión Multi-Base de Datos: Integración híbrida entre SQL Server (Datos maestros SIBOP) y MariaDB (Métricas de UptimeKuma).
* Mapeo Dinámico: Tabla de sincronización (monitores_servidores) que vincula IDs externos con unidades internas.
* WebSockets en Tiempo Real: Difusión de cambios de estado mediante Laravel Reverb/Pusher sin recarga de página.
* Automatización: Tarea programada (Scheduler) que monitorea latidos de servidor cada minuto.

## Tecnologías Utilizadas
* Framework: Laravel 11
* Bases de Datos: * SQL Server: Almacenamiento de mapeos y persistencia local (smars).
* MariaDB/MySQL: Fuente de datos externa (kuma1).
* Real-time: Laravel Reverb / Broadcasting (Eventos).
* Lenguaje: PHP 8.2+

# Arquitectura de Datos
* El sistema funciona como un flujo de eventos de tres niveles:
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
