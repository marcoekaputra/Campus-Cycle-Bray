<?php

use App\Http\Controllers\MidtransWebhookController;
use Illuminate\Support\Facades\Route;

// Endpoint Webhook Midtrans Snap
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handleCallback'])->name('midtrans.callback');
