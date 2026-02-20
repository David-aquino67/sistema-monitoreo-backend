<?php

namespace Docs;

use App\Services\AuthService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface AuthControllerDocInterface
{
    #[OA\Post(
        path: "/api/auth/login",
        summary: "Migrar sesión del SIBOP al MOCACI",
        description: "Endpoint para autenticar usuarios migrando su sesión (token) desde el SIBOP. Cada que se crea un token nuevo para el MOCACI se invalida el anterior.",
        security: [['bearerAuth' => []]],
        tags: ["Auth"],
		responses: [
            new OA\Response(
                response: 200,
                description: "Autenticación exitosa",
				content: new OA\JsonContent(
					properties: [
						new OA\Property(
							property: "token",
							description: "Token de autenticación generado para MOCACI",
							type: "string",
							example: "1|abcdefghijklmnopqrstuvwxyz1234567890"
						),
						new OA\Property(
							property: "permiso",
							description: "ID del permiso asociado al usuario",
							type: "string",
							example: "admin"
						),
						new OA\Property(
							property: "id_sibop",
							description: "ID del usuario en SIBOP",
							type: "integer",
							example: 123
						)
					]
				)
            ),
			new OA\Response(
                response: 404,
                description: "Usuario no encontrado",
				content: new OA\JsonContent(
					properties: [
						new OA\Property(
							property: "title",
							type: "string",
							example: "Error de autenticación"
						),
						new OA\Property(
							property: "message",
							type: "string",
							example: "Usuario no encontrado"
						)
					]
				)
            ),
			new OA\Response(
                response: 401,
                description: "Token no proporcionado",
				content: new OA\JsonContent(
					properties: [
						new OA\Property(
							property: "message",
							type: "string",
							example: "Token no proporcionado"
						)
					]
				)
            ),
			new OA\Response(
                response: 422,
                description: "Token de proporcionado, pero invalido en el SIBOP",
				content: new OA\JsonContent(
					properties: [
						new OA\Property(
							property: "error",
							type: "string",
							example: "Token inválido o expirado"
						),
						new OA\Property(
							property: "exception",
							type: "string",
							example: "Unauthenticated SIBOP token"
						)
					]
				)
            ),
        ]
    )]
	public function login(Request $request, AuthService $authService);

	#[OA\Get(
        path: "/api/auth/logout",
        summary: "Cerrar sesión del usuario (i.e. eliminar tokens)",
        description: "Endpoint para cerrar la sesión del usuario autenticado, es decir, eliminar la validez de su ultimo token creado",
        security: [['bearerAuth' => []]],
        tags: ["Auth"],
		responses: [
            new OA\Response(
                response: 204,
                description: "Sesión cerrada exitosamente (Sin contenido)",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 401,
                description: "No autenticado - Token inválido, expirado o no proporcionado",
				content: new OA\JsonContent(
					properties: [
						new OA\Property(
							property: "message",
							type: "string",
							example: "Unauthenticated."
						)
					]
				)
            ),
        ]
    )]
	public function logout(Request $request, AuthService $authService);

	#[OA\Get(
        path: "/api/auth/validate/token",
        summary: "Validar token de sesión actual",
        description: "Endpoint para verificar que el token del usuario actual sigue siendo válido en el SIBOP.",
        security: [['bearerAuth' => []]],
        tags: ["Auth"],
		responses: [
            new OA\Response(
                response: 200,
                description: "Token válido",
				content: new OA\JsonContent()
            ),
			new OA\Response(
                response: 401,
                description: "No autenticado - Token inválido, expirado o no proporcionado",
				content: new OA\JsonContent(
					properties: [
						new OA\Property(
							property: "message",
							type: "string",
							example: "Unauthenticated."
						)
					]
				)
            ),
        ]
    )]
	public function validateToken(AuthService $authService);

	#[OA\Get(
        path: "/api/auth/validate/user/{id_usuario}",
        summary: "Verificar existencia de usuario",
        description: "Endpoint para verificar si un usuario existe en el sistema mediante su ID de SIBOP.",
        tags: ["Auth"],
		parameters: [
			new OA\Parameter(
				name: "id_usuario",
				description: "ID del usuario en SIBOP",
				in: "path",
				required: true,
				schema: new OA\Schema(
					type: "integer",
					example: 1
				)
			),
		],
		responses: [
            new OA\Response(
                response: 200,
                description: "Verificación exitosa",
				content: new OA\JsonContent(
					properties: [
						new OA\Property(
							property: "existe",
							description: "Indica si el usuario existe en el sistema",
							type: "boolean",
							example: true
						)
					]
				)
            ),
        ]
    )]
	public function existeUsuario($id_usuario, AuthService $authService);
}