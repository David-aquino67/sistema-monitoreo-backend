## Documentacion de mensajes Kuma a Servidor Backend Laravel
Existen dos tipo des monitores
- Servidores httpp
- Servidores de red

[2026-02-18 16:54:10] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"ping","group":"uptimekuma-ping","resource":"U.M.F. 09 RED","environment":"Desarrollo","severity":"cleared","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service ping is up."}  
[2026-02-18 16:55:20] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"ping","group":"uptimekuma-ping","resource":"U.M.F. 09 RED","environment":"Desarrollo","severity":"critical","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service ping is down."}  
[2026-02-18 16:59:29] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"http","group":"uptimekuma-http","resource":"Sistema local 004: T por T","environment":"Desarrollo","severity":"critical","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service http is down."}  
[2026-02-18 17:00:08] local.INFO: Iniciando escaneo del servidor: js{"correlate":[],"event":"http","group":"uptimekuma-http","resource":"Sistema local 004: T por T","environment":"Desarrollo","severity":"cleared","service":["UptimeKuma"],"value":"Timeout","tags":["uptimekuma"],"attributes":[],"origin":"uptimekuma","type":"exceptionAlert","text":"Service http is up."}  

% ============================================================
% Archivo de Monitoreo de Servicios - UptimeKuma
% Fecha: 2026-02-18
% ============================================================

% --- ALERTAS CRÍTICAS ---
% [Hora: 16:12:18] Recurso: U.M.F. 09 RED
% Evento: ping | Severidad: critical | Estado: Service ping is down.

% [Hora: 16:12:49] Recurso: U.M.F. 56 RED
% Evento: ping | Severidad: critical | Estado: Service ping is down.

% [Hora: 16:12:52] Recurso: U.M.F 44 SIMF
% Evento: http | Severidad: critical | Estado: Service http is down.

% [Hora: 16:12:53] Recurso: U.M.F. 30 RED
% Evento: ping | Severidad: critical | Estado: Service ping is down.

% [Hora: 16:13:04] Recurso: Ixtepec RED
% Evento: ping | Severidad: critical | Estado: Service ping is down.

% --- RECUPERACIONES ---
% [Hora: 16:28:59] Recurso: U.M.F 44 SIMF
% Evento: http | Severidad: cleared | Estado: Service http is up.

% [Hora: 16:29:01] Recurso: Ixtepec RED
% Evento: ping | Severidad: cleared | Estado: Service ping is up.

% [Hora: 16:29:53] Recurso: U.M.F. 30 RED
% Evento: ping | Severidad: cleared | Estado: Service ping is up.

% [Hora: 16:31:17] Recurso: U.M.F. 56 RED
% Evento: ping | Severidad: cleared | Estado: Service ping is up.

% [Hora: 16:42:09] Recurso: U.M.F. 09 RED
% Evento: ping | Severidad: cleared | Estado: Service ping is up.

[2026-02-18 16:47:11] → Marca de tiempo del evento (fecha y hora exacta en que se registró).
• 	local.INFO → Nivel de log del sistema (en este caso, información general).
• 	Iniciando escaneo del servidor → Mensaje descriptivo del proceso que se está ejecutando.
• 	js{…} → Bloque en formato JSON con los detalles técnicos del evento.
Dentro del JSON:
• 	correlate → Lista para correlacionar este evento con otros relacionados. Aquí está vacía.
• 	event → Tipo de evento monitoreado. Ejemplo:  indica que se estaba verificando conectividad por ICMP.
• 	group → Grupo de monitoreo al que pertenece.  agrupa eventos de tipo ping.
• 	resource → El recurso o servidor afectado. Ejemplo: .
• 	environment → Entorno donde ocurre el evento.  indica que es un servidor de pruebas/desarrollo.
• 	severity → Nivel de severidad.  significa que el servicio está caído.
• 	service → Servicio que reporta el evento. Aquí es .
• 	value → Valor asociado al evento.  indica que no hubo respuesta en el tiempo esperado.
• 	tags → Etiquetas para clasificar el evento. Ejemplo: .
• 	attributes → Campo para atributos adicionales. Aquí está vacío.
• 	origin → Origen del evento.  señala que proviene del sistema de monitoreo UptimeKuma.
• 	type → Tipo de alerta.  indica que es una alerta por excepción.
• 	text → Mensaje descriptivo en lenguaje natural. Ejemplo: .
