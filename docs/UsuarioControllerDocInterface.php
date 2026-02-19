<?php

namespace Docs;

use App\Http\Requests\UsuarioRequest;
use App\Services\UsuarioService;
use OpenApi\Attributes as OA;

interface UsuarioControllerDocInterface
{
	#[OA\Get(
        path: "/api/usuarios",
        summary: "Lista todos los usuarios desde SIBOP",
        description: "Endpoint para obtener el listado de usuarios desde el sistema SIBOP",
        tags: ["Usuarios"],
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
							new OA\Property(property: "id", type: "integer", example: 1),
							new OA\Property(property: "nombre", type: "string", example: "Juan Pérez"),
							new OA\Property(property: "matricula", type: "string", example: "12345"),
							new OA\Property(property: "email", type: "string", example: "juan.perez@example.com"),
						]
					)
				)
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 502,
                description: "Error al recuperar usuarios del SIBOP",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "message", type: "string", example: "Error al recuperar usuarios del SIBOP")
					]
				)
            ),
        ]
    )]
	public function index(UsuarioService $usuarioService);

	#[OA\Get(
        path: "/api/usuarios/{id_sibop}",
        summary: "Obtiene un usuario específico por su ID de SIBOP",
        description: "Endpoint para obtener información detallada de un usuario desde SIBOP",
        tags: ["Usuarios"],
		security: [['bearerAuth' => []]],
		parameters: [
			new OA\Parameter(
				name: "id_sibop",
				in: "path",
				required: true,
				description: "ID del usuario en SIBOP",
				schema: new OA\Schema(type: "integer", example: 1)
			)
		],
		responses: [
            new OA\Response(
                response: 200,
                description: "Usuario encontrado",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "id", type: "integer", example: 1),
						new OA\Property(property: "nombre", type: "string", example: "Juan Pérez"),
						new OA\Property(property: "matricula", type: "string", example: "12345"),
						new OA\Property(property: "email", type: "string", example: "juan.perez@example.com"),
					]
				)
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 422,
                description: "Usuario no encontrado en el SIBOP",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "message", type: "string", example: "Usuario no encontrado en el SIBOP")
					]
				)
            ),
        ]
    )]
	public function show($id_sibop, UsuarioRequest $request, UsuarioService $usuarioService);

	#[OA\Get(
        path: "/api/usuarios/search",
        summary: "Busca usuarios por nombre o matrícula",
        description: "Endpoint para buscar usuarios en el sistema mediante filtros de nombre y/o matrícula",
        tags: ["Usuarios"],
		security: [['bearerAuth' => []]],
		parameters: [
			new OA\Parameter(
				name: "nombre",
				in: "query",
				required: false,
				description: "Nombre del usuario a buscar",
				schema: new OA\Schema(type: "string", example: "Juan")
			),
			new OA\Parameter(
				name: "matricula",
				in: "query",
				required: false,
				description: "Matrícula del usuario a buscar",
				schema: new OA\Schema(type: "string", example: "12345")
			)
		],
		responses: [
            new OA\Response(
                response: 200,
                description: "Búsqueda exitosa",
				content: new OA\JsonContent(
					type: "array",
					items: new OA\Items(
						type: "object",
						properties: [
							new OA\Property(property: "id", type: "integer", example: 1),
							new OA\Property(property: "nombre", type: "string", example: "Juan Pérez"),
							new OA\Property(property: "matricula", type: "string", example: "12345"),
							new OA\Property(property: "email", type: "string", example: "juan.perez@example.com"),
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
	public function search(UsuarioService $usuarioService);

	#[OA\Post(
        path: "/api/usuarios",
        summary: "Importa un usuario desde SIBOP al sistema MOCACI",
        description: "Endpoint para registrar/importar un usuario del SIBOP al sistema MOCACI con un permiso específico",
        tags: ["Usuarios"],
		security: [['bearerAuth' => []]],
		requestBody: new OA\RequestBody(
			required: true,
			content: new OA\JsonContent(
				type: "object",
				   required: ["id_sibop", "FK_permiso_ability", "id_sibop_jefe"],
				   properties: [
					   new OA\Property(property: "id_sibop", type: "integer", example: 1, description: "ID del usuario en SIBOP"),
					   new OA\Property(property: "FK_permiso_ability", type: "string", example: "admin", description: "Permiso a asignar al usuario"),
					   new OA\Property(property: "id_sibop_jefe", type: "integer", example: 1, description: "ID del jefe del usuario en SIBOP"),
				   ]
			)
		),
		responses: [
            new OA\Response(
                response: 201,
                description: "Usuario importado exitosamente",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "id_sibop", type: "integer", example: 1),
						new OA\Property(property: "FK_permiso_ability", type: "string", example: "admin"),
						new OA\Property(property: "REGISTRO_fecha_creacion", type: "string", format: "date-time", example: "2026-01-22T17:09:12.176000Z"),
						new OA\Property(property: "REGISTRO_fecha_ultimo_cambio", type: "string", format: "date-time", example: "2026-01-22T17:09:12.176000Z"),
					]
				)
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 422,
                description: "Usuario registrado previamente",
				content: new OA\JsonContent(
					type: "object",
					properties: [
						new OA\Property(property: "message", type: "string", example: "Usuario registrado previamente")
					]
				)
            ),
        ]
    )]
	public function store(UsuarioRequest $request, UsuarioService $usuarioService);

	#[OA\Put(
        path: "/api/usuarios/{id_sibop}",
        summary: "Actualiza el permiso de un usuario",
        description: "Endpoint para actualizar el permiso asignado a un usuario en el sistema MOCACI",
        tags: ["Usuarios"],
		security: [['bearerAuth' => []]],
		parameters: [
			new OA\Parameter(
				name: "id_sibop",
				in: "path",
				required: true,
				description: "ID del usuario en SIBOP",
				schema: new OA\Schema(type: "integer", example: 1)
			)
		],
		requestBody: new OA\RequestBody(
			required: true,
			content: new OA\JsonContent(
				type: "object",
				required: ["FK_permiso_ability", "id_sibop_jefe"],
				properties: [
					new OA\Property(property: "FK_permiso_ability", type: "string", example: "user", description: "Nuevo permiso a asignar"),
					new OA\Property(property: "id_sibop_jefe", type: "integer", example: 1, description: "ID del jefe del usuario en SIBOP"),
				]
			)
		),
		responses: [
            new OA\Response(
                response: 204,
                description: "Usuario actualizado exitosamente",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 422,
                description: "Usuario no encontrado o error de validación",
				content: new OA\JsonContent()
            ),
        ]
    )]
	public function update($id_sibop, UsuarioRequest $request, UsuarioService $usuarioService);

	#[OA\Delete(
        path: "/api/usuarios/{id_sibop}",
        summary: "Elimina un usuario del sistema MOCACI",
        description: "Endpoint para eliminar un usuario registrado en MOCACI (no elimina del SIBOP)",
        tags: ["Usuarios"],
		security: [['bearerAuth' => []]],
		parameters: [
			new OA\Parameter(
				name: "id_sibop",
				in: "path",
				required: true,
				description: "ID del usuario en SIBOP",
				schema: new OA\Schema(type: "integer", example: 1)
			)
		],
		responses: [
            new OA\Response(
                response: 204,
                description: "Usuario eliminado exitosamente",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 401,
                description: "No autorizado",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 422,
                description: "Usuario no encontrado",
				content: new OA\JsonContent()
            ),
        ]
    )]
	public function destroy($id_sibop, UsuarioRequest $request, UsuarioService $usuarioService);
}
