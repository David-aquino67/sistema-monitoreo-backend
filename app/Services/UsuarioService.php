<?php

namespace App\Services;

use App\Models\Usuario;
use Exception;

class UsuarioService
{
	public function listar()
	{
		$usuarios = Usuario::with(['permiso'])->get();
        $usuariosExtendidos = $usuarios->map(function ($usuario) {

            try {
                $datosExternos = (object) $usuario->datosCompletos();
            } catch (\Exception $e) {
                return false;
            }

            $usuario->datosSibop = $datosExternos;
            return $usuario;
        });

		return $usuariosExtendidos;
	}

	public function buscarPorId($id)
	{
		$usuario = Usuario::find($id);

		if(!$usuario) {
			return false;
		}

		$id_sibop = $usuario->id_sibop;

		try {
            $datosSibop = Sibop::datosCompletosUsuario(env('SIBOP_API_TOKEN'), $id_sibop);
        } catch (\Exception $e) {
            return false;
        }

		$usuario->sibop = $datosSibop;
		return $usuario;
	}

	public function buscarUsuario($nombre = null, $matricula = null)
	{
		$params = [];

		if($nombre) {
			$params['nombre'] = $nombre;
		}

		if($matricula) {
			$params['matricula'] = $matricula;
		}

		try {
            $resultados = Sibop::filtroUsuarios(env('SIBOP_API_TOKEN'), $params);
        } catch (\Exception $e) {
            return [];
        }

		return $resultados;
	}

	public function importarUsuario($data)
	{
		$existe = Usuario::where('id_sibop', $data['id_sibop'])->exists();
		if($existe){
			return false;
		}
		$usuario = new Usuario();
		$usuario->id_sibop = $data['id_sibop'];
		$usuario->FK_permiso_ability = $data['FK_permiso_ability'];
		$usuario->save();
		return $usuario;
	}

	public function actualizarUsuario($id, $data)
	{
		$usuario = Usuario::find($id);
		$usuario->FK_permiso_ability = $data['FK_permiso_ability'];
		$usuario->save();
	}

	public function eliminarUsuario($id)
	{
		$usuario = Usuario::find($id);
		$usuario->delete();
	}
}