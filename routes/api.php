<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CateringServiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SpecialRequestController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

   // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);

    // Catering Service routes
    Route::get('/catering-services', [CateringServiceController::class, 'index']);
    Route::post('/catering-services', [CateringServiceController::class, 'store']);
    Route::put('/catering-services/{id}', [CateringServiceController::class, 'update']);
    Route::delete('/catering-services/{id}', [CateringServiceController::class, 'destroy']);

    // Payment routes
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/{reservation_id}', [PaymentController::class, 'showByReservation']);

    // Special Requests
    Route::post('/special-requests', [SpecialRequestController::class, 'store']);
    Route::get('/special-requests/{reservation_id}', [SpecialRequestController::class, 'showByReservation']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
