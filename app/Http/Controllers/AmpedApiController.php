<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AmpedApiController extends Controller
{
    public function fetchTokenFromApi(Request $request)
    {
        $data = json_decode($request->data);
        $response = Http::timeout(30)
        ->withHeaders([
            'Accept' => 'application/json',
            // Add any required headers here
        ])
        ->post('https://api.ampedinnovation.com/v1.0/token', $data);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'error' => 'Failed to fetch token',
            'details' => $response->json()
        ], $response->status());
    }
}
