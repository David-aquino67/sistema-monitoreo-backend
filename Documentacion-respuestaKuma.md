## Documentacion de mensajes Kuma a Servidor Backend Laravel
Existen dos tipo des monitores
- Servidores http
- Servidores de red
En este caso he detectado dos tipos de eventos en estos servidores un evento cuando el servidor se cae y tro cuando el servidor es reactivado.
### Mensaje de servidor reacctivado de red
~~~
[2026-02-18 16:54:10] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"ping","group":"uptimekuma-ping","resource":"U.M.F. 09 RED","environment":"Desarrollo","severity":"cleared","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service ping is up."}
~~~
### Mensaje de servidor caido de red
~~~
[2026-02-18 16:55:20] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"ping","group":"uptimekuma-ping","resource":"U.M.F. 09 RED","environment":"Desarrollo","severity":"critical","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service ping is down."}  
~~~
### Mensaje de servidor caido htpp
~~~
[2026-02-18 16:59:29] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"http","group":"uptimekuma-http","resource":"Sistema local 004: T por T","environment":"Desarrollo","severity":"critical","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service http is down."}
~~~
### Mensaje de servidor reacctivado htpp 
~~~
[2026-02-18 17:00:08] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"http","group":"uptimekuma-http","resource":"Sistema local 004: T por T","environment":"Desarrollo","severity":"cleared","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service http is up."}  
~~~
--------------------------------------------------------------------------------------------------------------------------------------

+ **[2026-02-18 16:47:11]:** Marca de tiempo del evento (fecha y hora exacta en que se registró).
+ **local.INFO:** Nivel de log del sistema (en este caso, información general).
+ **Iniciando escaneo del servidor:** Mensaje descriptivo del proceso que se está ejecutando.
+ **js{…}:** Bloque en formato JSON con los detalles técnicos del evento.
-----------------------------------------------------------------------------------
Dentro del JSON:

+ **correlate:** Lista para correlacionar este evento con otros relacionados, es un arreglo vacio
+ **event:** Tipo de evento monitoreado, indica que se estaba verificando conectividad por (pin/http)
+ **group:** Grupo de monitoreo al que pertenece, (uptimekuma-http/uptimekuma-ping)
+ **resource:** Nombre del servidor afectado 
+ **environment:** Entorno donde ocurre el evento, indica que es un servidor de pruebas/desarrollo.
+ **severity:** Nivel de severidad
+ **service:** Servicio que reporta el evento (UptimeKuma)
+ **value:** Valor asociado al evento, TIMEOUT: indica que no hubo respuesta en el tiempo esperado.
+ **tags:** Etiquetas para clasificar el evento (uptimekuma)
+ **attributes:** Campo para atributos adicionales, devuelve un arreglo vacio 
+ **origin:** Origen del evento, señala que proviene del sistema de monitoreo UptimeKuma.
+ **type** Tipo de alerta.  indica que es una alerta por excepción.
+ **text:** Mensaje descriptivo si el servidor (http/ping),(up/down)
