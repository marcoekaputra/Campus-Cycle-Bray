<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    /**
     * Endpoint Webhook Callback Midtrans Snap
     * POST /api/midtrans/callback
     */
    public function handleCallback(Request $request, MidtransService $midtransService): JsonResponse
    {
        $payload = $request->all();

        $result = $midtransService->handleNotification($payload);

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ]);
    }
}
