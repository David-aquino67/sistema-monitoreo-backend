<?php

namespace App\Services;

use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{
	public function searchUserByToken($token)
	{
        // Obtenemos el id del usuario
        try {
            $id = Sibop::obtenerIdUsuario($token);
        } catch (Exception $e) {
			return false;
        }

        // Verificamos si el usuario esta dado de alta en este sistema
        $usuario = Usuario::find($id);

		if(!$usuario) {
			return false;
		}

		return $usuario;
	}

	public function createToken(Usuario $usuario, $sibopToken)
	{
		$usuario->token = $sibopToken;
        $usuario->save();
        $usuario->tokens()->delete();
        $ability = $usuario->FK_permiso_ability;
        $token = $usuario->createToken($usuario->id_sibop, [$ability])->plainTextToken;
        return $token;
	}

	public function dropTokens(Usuario $usuario)
	{
		// Cerramos sesión en este sistema
        $usuario->currentAccessToken()->delete();

        // Eliminamos el token de base de datos
        $usuario->token = NULL;
        $usuario->save();
	}

	public function userExists($id)
	{
		$existe = Usuario::where('id_sibop', $id)->exists();
		return $existe;
	}

	public function validateCurrentUserToken()
	{
		$usuario = Auth::user();	
		try {
            Sibop::validateToken($usuario->token);
			return true;
        } catch (Exception $e) {
            return false;
        }
	}
}