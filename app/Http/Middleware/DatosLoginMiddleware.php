<?php

namespace App\Http\Middleware;

use App\Services\Sibop;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DatosLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization');

		if (!$authorization || !str_starts_with($authorization, 'Bearer ')) {
			return response()->json(['error' => 'Token no proporcionado o mal formado'], 401);
		}

		$token = substr($authorization, 7);

		try {
			Sibop::validateToken($token);
		} catch (\Exception $e) {
			return response()->json([
				'error' => 'Token no valido en el SIBOP',
				'exception' => $e->getMessage()
			], 422);
		}

		return $next($request);
    }
}
