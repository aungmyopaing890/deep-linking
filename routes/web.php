<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/deeplink', function () {
    $action = request('action') ?? 'default';
    $data = request('data') ?? [];

    // Log the incoming request
    Log::info('Deep Link Request:', [
        'action' => $action,
        'data' => $data,
        'ip' => request()->ip(),
        'user_agent' => request()->header('User-Agent'),
    ]);

    switch ($action) {
        case 'open-profile':
            return response()->json([
                'message' => 'Opening user profile...',
                'user_id' => $data['user_id'] ?? null,
            ]);
        case 'view-item':
            return response()->json([
                'message' => 'Viewing item details...',
                'item_id' => $data['item_id'] ?? null,
            ]);
        default:
            return response()->json([
                'message' => 'Default action triggered',
            ]);
    }
});

Route::get('/.well-known/apple-app-site-association', function () {


    // Log the incoming request
    Log::info('/.well-known/apple-app-site-association:', [
        'action' => 'apple-app-site-association',
    ]);
    $aasa = [
        "applinks" => [
            "apps" => [],
            "details" => [
                [
                    "appID" => "XWPM63M4C4.com.joy.amptest",
                    "paths" => ["*"]
                ]
            ]
        ]
    ];
    return response()->json($aasa, 200, ['Content-Type' => 'application/json']);
});
