<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProximityAlertController extends Controller
{
    public function checkProximity(Request $request)
    {
        $response = Http::post('https://warehouse-proximity.onrender.com/check_proximity', [
            'warehouse' => [14.5995, 120.9842],
            'delivery' => [$request->lat, $request->lng],
            'radius' => $request->radius ?? 250
        ]);

        $data = $response->json();

        if (!$data || !is_array($data)) {
            $data = ['error' => 'Invalid response from API'];
        }

        return view('dashboard.alerts', ['data' => $data]);
    }
}