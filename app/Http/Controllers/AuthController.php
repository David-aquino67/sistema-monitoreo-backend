<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
// use Docs\AuthControllerDocInterface;
use Illuminate\Http\Request;

class AuthController /* implements AuthControllerDocInterface*/
{
    public function login(Request $request, AuthService $authService)
    {
        // Obtenemos el token del SIBOP
        $authorization = $request->header('Authorization');
        $token = substr($authorization, 7);

        // Validamos que exista el usuario
        $usuario = $authService->searchUserByToken($token);

        if(!$usuario){
            return response()->json([
                'title' => 'Error de autenticación',
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        // Creamos el token
        $token = $authService->createToken($usuario, $token);

        return response()->json([
            'token' => $token,
            'permiso' => $usuario?->FK_permiso_ability,
			'id_sibop' => $usuario?->id_sibop
        ], 200);
    }

	public function validateToken(AuthService $authService)
	{
		$isTokenValid = $authService->validateCurrentUserToken();
		if(!$isTokenValid) {
			return response()->json(['message' => 'Error al autenticar con el SIBOP'], 403);
		}
		return response()->json(null, 200);
	}

    public function logout(Request $request, AuthService $authService)
    {
        $user = $request->user();
        $authService->dropTokens($user);
        return response()->json(null, 204);    
    }

    public function existeUsuario($id_usuario, AuthService $authService)
    {
        $existe = $authService->userExists($id_usuario);
        return response()->json(['existe' => $existe], 200);
    }
}
