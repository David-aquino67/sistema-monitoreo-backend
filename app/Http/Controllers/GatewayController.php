<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class GatewayController extends Controller
{

    public function dispatch(Request $request, Gateway $gateway)
    {
        $data = collect($request->input('servers'));

        $gateway->dispatchStatusUpdate($data);

        return response()->json([
            'ok' => true,
            'count' => $data->count()
        ]);
    }

}
