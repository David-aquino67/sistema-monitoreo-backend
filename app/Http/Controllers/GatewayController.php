<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use http\Client\Request;

class GatewayController extends Controller
{

    public function dispatch(Request $request, Gateway $gateway)
    {
        $data = collect($request->input('servers'));

        $gateway->dispatchStatusUpdate($data);

        return response()->json([
            'ok' => true,
            'message' => 'Status dispatch iniciado',
            'count' => $data->count()
        ], 202);
    }

}
