<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Sibop
{

    /**
     * Inicia sesión en el sistema SIBOP y obtiene un token de acceso.
     * 
     * Esta función realiza una solicitud HTTP POST al endpoint de inicio de sesión del SIBOP 
     * utilizando las credenciales proporcionadas (id_usuario y clave). Si la autenticación es exitosa, 
     * devuelve un token de acceso. Si la autenticación falla, lanza una excepción con un mensaje de error 
     * específico.
     * 
     * @param string $id_usuario El identificador único del usuario en el sistema SIBOP.
     * @param string $clave La clave de acceso del usuario para autenticarse en el sistema SIBOP.
     * 
     * @return string El token de acceso generado por SIBOP si la autenticación es exitosa.
     * 
     * @throws \Exception Si la autenticación falla, se lanza una excepción con un mensaje de error.
     */
    public static function login($id_usuario, $clave)
    {
        $endpoint = env('SIBOP_API_URL') . '/auth/login';

        $data = [
            "id_usuario" => $id_usuario,
            "clave"      => $clave
        ];
        $response = Http::withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->post($endpoint, $data);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['token'];
    }

    /**
     * Cierra sesión en el sistema SIBOP.
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de cierre de sesión de SIBOP. Si la solicitud es exitosa,
     * cierra la sesión del usuario en el sistema SIBOP y devuelve los datos correspondientes a la operación. 
     * Si la solicitud falla, lanza una excepción con un mensaje de error.
     * 
     * @param string $token El token Bearer utilizado para autenticar la solicitud de cierre de sesión.
     * 
     * @return array Los datos devueltos por SIBOP al cerrar la sesión.
     * 
     * @throws \Exception Si la solicitud de cierre de sesión falla, se lanza una excepción con un mensaje de error.
     */
    public static function logout($token)
    {
        $endpoint = env('SIBOP_API_URL') . '/auth/logout/0';
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data;
    }

    /**
     * Valida un token de acceso en el sistema SIBOP.
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de validación de token de SIBOP utilizando el token de acceso 
     * proporcionado. Si la solicitud es exitosa, devuelve los datos relacionados con la validación del token. Si falla, 
     * lanza una excepción con un mensaje de error.
     * 
     * @param string $token El token de acceso que se desea validar en el sistema SIBOP.
     * 
     * @return array Los datos devueltos por SIBOP relacionados con la validación del token de acceso.
     * 
     * @throws \Exception Si la validación del token de acceso falla, se lanza una excepción con un mensaje de error.
     */
    public static function validateToken($token)
    {
        $endpoint = env('SIBOP_API_URL') . '/auth/validate/token';
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data;
    }

    /**
     * Solicita el restablecimiento de la contraseña para un usuario en el sistema SIBOP.
     * 
     * Esta función realiza una solicitud HTTP PATCH al endpoint de restablecimiento de contraseña de SIBOP 
     * utilizando el identificador único del usuario. Si la solicitud es exitosa, devuelve los datos 
     * relacionados con la solicitud de restablecimiento. Si falla, lanza una excepción con un mensaje de error.
     * 
     * @param string $id_usuario El identificador único del usuario para el cual se solicita el restablecimiento de la contraseña.
     * 
     * @return array Los datos devueltos por el SIBOP relacionados con la solicitud de restablecimiento de contraseña.
     * 
     * @throws \Exception Si la solicitud de restablecimiento de contraseña falla, se lanza una excepción con un mensaje de error.
     */
    public static function forgotPwd($id_usuario)
    {
        $endpoint = env('SIBOP_API_URL') . '/auth/forgotpwd/' . $id_usuario;
        $response = Http::withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->patch($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data;
    }

    /**
     * Obtiene la unidad asociada a un usuario en el sistema SIBOP.
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de unidad de SIBOP utilizando el identificador único del usuario. 
     * Si la solicitud es exitosa, devuelve los datos relacionados con la unidad del usuario. Si falla, lanza una excepción con un mensaje de error.
     * 
     * @param string $id_usuario El identificador único del usuario para el cual se desea obtener la oficina informática.
     * @param string $token El token de acceso del sistema que desea usar la API del SIBOP.
     * 
     * @return array Los datos devueltos por SIBOP relacionados con la oficina informática del usuario.
     * 
     * @throws \Exception Si la solicitud de oficina informática falla, se lanza una excepción con un mensaje de error.
     */
    public static function unidadUsuario($token, $id_usuario)
    {
        $endpoint = env('SIBOP_API_URL') . "/system/usuario/{$id_usuario}/unidad";
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['unidad'];
    }

    /**
     * Obtiene las unidades del sistema SIBOP.
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de unidades de SIBOP. Si la solicitud es exitosa, 
     * devuelve los datos relacionados con las unidades del sistema. Si falla, lanza una excepción con un mensaje de error.
     * 
     * @param array $ids Un arreglo con los identificadores de las unidades que se desean recuperar. Si no se proporciona, se recuperan todas las unidades.
     * @param string $token El token de acceso del sistema que desea usar la API del SIBOP.
     * 
     * @return array Los datos devueltos por SIBOP relacionados con las unidades del sistema.
     * 
     * @throws \Exception Si la solicitud de unidades falla, se lanza una excepción con un mensaje de error.
     */
    public static function unidades($token, $ids = [])
    {
        $endpoint = empty($ids) ? env('SIBOP_API_URL') . "/system/unidades" : env('SIBOP_API_URL') . "/system/unidades?filtro=" . urlencode(json_encode($ids));
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint, ['filtro' => $ids]);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['unidades'];
    }

    /**
     * Obtiene la existencia de un conjunto de unidades.
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de existencia de unidades de SIBOP. Si la solicitud es exitosa, 
     * devuelve 1 si no 0. Si falla, lanza una excepción con un mensaje de error.
     * 
     * @param array $ids Un arreglo con los identificadores de las unidades que se desean recuperar
     * @param string $token El token de acceso del sistema que desea usar la API del SIBOP.
     * 
     * @return bool Valor de verdad que indica la existencia de todas las unidades
     * 
     * @throws \Exception Si la solicitud de unidades falla, se lanza una excepción con un mensaje de error.
     */
    public static function existenUnidades($token, $ids = [])
    {
        $endpoint = empty($ids) ? env('SIBOP_API_URL') . "/system/unidades/existen" : env('SIBOP_API_URL') . "/system/unidades/existen?ids=" . urlencode(json_encode($ids));
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint, ['ids' => $ids]);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['existen'];
    }

    /**
     * Obtiene las oficinas informáticas del sistema SIBOP.
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de oficinas informáticas de SIBOP. Si la solicitud es exitosa, 
     * devuelve los datos relacionados con las oficinas informáticas del sistema. Si falla, lanza una excepción con un mensaje de error.
     * 
     * @param array $ids Un arreglo con los identificadores de las oficinas informáticas que se desean recuperar. Si no se proporciona, se recuperan todas las oficinas informáticas.
     * @param string $token El token de acceso del sistema que desea usar la API del SIBOP.
     * 
     * @return array Los datos devueltos por SIBOP relacionados con las oficinas informáticas del sistema.
     * 
     * @throws \Exception Si la solicitud de oficinas informáticas falla, se lanza una excepción con un mensaje de error.
     */
    public static function getUserId($username)
    {
        $endpoint = env('SIBOP_API_URL') . "/auth/user/{$username}/id";
        $response = Http::withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data;
    }

    /**
     * Obtiene los datos completos de un usuario en el sistema SIBOP.
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de datos de usuario de SIBOP utilizando el identificador único del usuario. 
     * Si la solicitud es exitosa, devuelve los datos completos del usuario. Si falla, lanza una excepción con un mensaje de error.
     * 
     * @param string $token El token de acceso del sistema que desea usar la API del SIBOP.
     * @param string $id_usuario El identificador único del usuario para el cual se desean obtener los datos completos.
     * 
     * @return array Los datos completos del usuario en el sistema SIBOP.
     * 
     * @throws \Exception Si la solicitud de datos completos del usuario falla, se lanza una excepción con un mensaje de error.
     */
    public static function datosCompletosUsuario($token, $id_usuario)
    {
        $endpoint = env('SIBOP_API_URL') . "/system/usuario/{$id_usuario}/datos";
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['datos'];
    }

    public static function filtroUsuarios($token, $filtros = [])
    {
        $endpoint = env('SIBOP_API_URL') . "/system/usuario/filtros";
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint, $filtros);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['datos'];
    }

    /**
     * Obtiene si un número de serie es PNAEC V (O no)
     * 
     * Esta función realiza una solicitud HTTP GET al endpoint de datos de PNAEC V. 
     * Si la solicitud es exitosa, devuelve Si/No dependiendo si la serie pertenece al PNAEC V. Si falla, lanza una excepción con un mensaje de error.
     * 
     * @param string $token El token de acceso del sistema que desea usar la API del SIBOP.
     * @param string $serie La serie que se desea validar.
     * 
     * @return string Cadena de texto, puede ser 'Si' o 'No'.
     * 
     * @throws \Exception Si la solicitud falla, se lanza una excepción con un mensaje de error.
     */
    public static function serieEsPnaecV($token, $serie)
    {
        $endpoint = env('SIBOP_API_URL') . "/system/inventario/serie/{$serie}/pnaec/v";
        $response = Http::withToken($token)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['es_pnaec_v'];
    }

    public static function obtenerIdUsuario($tokenUsuario)
    {
        $endpoint = env('SIBOP_API_URL') . "/system/usuario/id";
        $response = Http::withToken($tokenUsuario)->withHeaders(["Accept" => 'application/json', "Content-Type" => 'application/json'])->get($endpoint);

        if (!$response->successful()) {

            Log::error("Error en petición {$endpoint} al SIBOP", ['json' => $response->json(), 'body' => $response->body()]);
            throw new \Exception(json_encode($response->json()));
        }

        $data = $response->json();
        return $data['id'];
    }
}