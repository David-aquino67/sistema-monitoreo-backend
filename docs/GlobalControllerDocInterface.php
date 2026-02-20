<?php

namespace Docs;

use App\Services\GlobalService;
use OpenApi\Attributes as OA;

interface GlobalControllerDocInterface
{
	#[OA\Delete(
        path: "/api/global/cache",
        summary: "Limpia la caché del sistema",
        description: "Endpoint para eliminar la caché almacenada del sistema (por ejemplo, datos del SIBOP cacheados)",
        tags: ["Global"],
		security: [['bearerAuth' => []]],
		responses: [
            new OA\Response(
                response: 204,
                description: "Caché eliminada exitosamente",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
        ]
    )]
	public function destroyCache(GlobalService $globalService);

	#[OA\Get(
        path: "/api/global/versiones",
        summary: "Lista todas las versiones del sistema",
        description: "Endpoint para obtener el historial completo de versiones del sistema ordenadas por fecha de liberación descendente",
        tags: ["Global"],
		security: [['bearerAuth' => []]],
		responses: [
            new OA\Response(
                response: 200,
                description: "Obtención de listado exitoso",
				content: new OA\JsonContent(
					type: "array",
					items: new OA\Items(
						type: "object",
						properties: [
							new OA\Property(property: "numero_version", type: "string", example: "1.0.0"),
							new OA\Property(property: "fecha_liberacion", type: "string", format: "date", example: "2026-01-27"),
							new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-01-27T12:00:00.000000Z"),
							new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2026-01-27T12:00:00.000000Z"),
						]
					)
				)
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
        ]
    )]
	public function indexVersiones(GlobalService $globalService);

	#[OA\Get(
        path: "/api/global/versiones/ultima",
        summary: "Obtiene la última versión del sistema",
        description: "Endpoint para obtener la versión más reciente del sistema basada en la fecha de liberación",
        tags: ["Global"],
		security: [['bearerAuth' => []]],
		responses: [
            new OA\Response(
                response: 200,
                description: "Obtención exitosa de la última versión",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "numero_version", type: "string", example: "1.0.0"),
						new OA\Property(property: "fecha_liberacion", type: "string", format: "date", example: "2026-01-27"),
						new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-01-27T12:00:00.000000Z"),
						new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2026-01-27T12:00:00.000000Z"),
					]
				)
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
        ]
    )]
	public function showUltimaVersion(GlobalService $globalService);

	#[OA\Get(
        path: "/api/global/versiones/{version}",
        summary: "Obtiene una versión específica del sistema",
        description: "Endpoint para obtener los detalles de una versión específica del sistema por su número de versión",
        tags: ["Global"],
		security: [['bearerAuth' => []]],
		parameters: [
			new OA\Parameter(
				name: "version",
				in: "path",
				required: true,
				description: "Número de versión a consultar",
				schema: new OA\Schema(type: "string", example: "1.0.0")
			)
		],
		responses: [
            new OA\Response(
                response: 200,
                description: "Obtención exitosa de la versión",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "numero_version", type: "string", example: "1.0.0"),
						new OA\Property(property: "fecha_liberacion", type: "string", format: "date", example: "2026-01-27"),
						new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-01-27T12:00:00.000000Z"),
						new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2026-01-27T12:00:00.000000Z"),
					]
				)
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 404,
                description: "Versión no encontrada",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "message", type: "string", example: "La versión solicitada no existe")
					]
				)
            ),
        ]
    )]
	public function showVersion(GlobalService $globalService, $version);
}
