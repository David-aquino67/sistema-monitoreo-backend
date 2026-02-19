<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Services\UsuarioService;
use Docs\UsuarioControllerDocInterface;

class UsuarioController extends Controller implements UsuarioControllerDocInterface
{
    public function index(UsuarioService $usuarioService)
    {
        $usuarios = $usuarioService->listar();
        if(!$usuarios) {
            return response()->json(['message' => 'Error al recuperar usuarios del SIBOP'], 502);
        }
        return response()->json($usuarios, 200);
    }

    public function show($id_sibop, UsuarioRequest $request, UsuarioService $usuarioService)
    {
        $usuario = $usuarioService->buscarPorId($id_sibop);
        if($usuario === false){
            return response()->json(['message' => 'Usuario no encontrado en el SIBOP'], 404);
        }
        return response()->json($usuario, 200);
    }

    public function search(UsuarioService $usuarioService)
    {
        $usuariosFiltrados = $usuarioService->buscarUsuario(
            nombre: request()->query('nombre', null),
            matricula: request()->query('matricula', null)
        );
        return response()->json($usuariosFiltrados, 200);
    }

    public function store(UsuarioRequest $request, UsuarioService $usuarioService)
    {
        $usuario = $usuarioService->importarUsuario($request->validated());
        if(!$usuario){
            return response()->json(['message' => 'Usuario registrado previamente'], 422);
        }
        return response()->json($usuario, 201);
    }

    public function update($id_sibop, UsuarioRequest $request, UsuarioService $usuarioService)
    {
        $usuarioService->actualizarUsuario($id_sibop, $request->validated());
        return response()->json(null, 204);   
    }

    public function destroy($id_sibop, UsuarioRequest $request, UsuarioService $usuarioService)
    {
        $usuarioService->eliminarUsuario($id_sibop);
        return response()->json(null, 204);
    }
}
