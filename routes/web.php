<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware('auth:api')->group(function () {
//     Route::get('/me', [AuthController::class, 'me']);
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });

// Route::get('/rooms', [RoomController::class, 'index']);
// Route::post('/rooms', [RoomController::class, 'store']);
// Route::put('/rooms/{id}', [RoomController::class, 'update']);
// Route::delete('/rooms/{id}', [RoomController::class, 'destroy']);

// Route::get('/bookings', [BookingController::class, 'index']);
// Route::post('/bookings', [BookingController::class, 'store']);
// Route::put('/bookings/{id}', [BookingController::class, 'update']);
// Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);

// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
