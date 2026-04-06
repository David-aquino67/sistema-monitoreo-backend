# Documentación para descifrar password de mremoteng

## Objetivo de la prueba

* Verificar la integridad del flujo de recuperación de activos, asegurando que el sistema sea capaz de:

* Realizar una consulta relacional (JOIN) entre la base de datos del Dashboard y la base de datos de mRemoteNG.

* Resolver conflictos de intercalación (Collation) en SQL Server.

* Descifrar exitosamente las credenciales institucionales mediante el algoritmo AES-128-CBC.

## Estructura del test ConnectionTest.php
La prueba se implementó bajo el patrón AAA
* ARRANGE: Preparación
    * Se instancian los servicios de cifrado y conexión

* ACT: Ejecución
    * Se solicita la credencial vinculada a la Unidad Médica ID: 1.

* ASSERT: Verificación
    * Validar que existe el mapeo en la tabla monitor_conexion.

* Validar que el algoritmo no devolvió una excepción o error.

## Ficha técnica del test
| Atributo  | Detalle |
| ------------- |:-------------:|
| Nombre del Test | ConnectionTest.php |
| Clase Evaluada | App\Services\EncryptionServic |
| Entorno | Base de Datos smars_testing    |

## Resultados obtenidos
Al ejecutar la suite de pruebas mediante el comando
```
 php artisan test --filter=ConnectionTest
```
se obtuvieron los siguientes resultados en el entorno de desarrollo.

