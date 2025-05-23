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
    Route::get('/get-reservations', [ReservationController::class, 'index']);
    Route::post('/add-reservation', [ReservationController::class, 'store']);
    Route::get('/get-reservation/{id}', [ReservationController::class, 'show']);
    Route::put('/edit-reservation/{id}', [ReservationController::class, 'update']);
    Route::delete('/delete-reservation/{id}', [ReservationController::class, 'destroy']);

    // Catering Service routes
    Route::get('/get-catering-services', [CateringServiceController::class, 'index']);
    Route::post('/add-catering-service', [CateringServiceController::class, 'store']);
    Route::put('/edit-catering-service/{id}', [CateringServiceController::class, 'update']);
    Route::delete('/delete-catering-service/{id}', [CateringServiceController::class, 'destroy']);

        // Payments
    Route::post('/add-payment', [PaymentController::class, 'store']);
    Route::get('/get-payments/{reservation_id}', [PaymentController::class, 'showByReservation']);
    Route::put('/edit-payment/{id}', [PaymentController::class, 'update']);
    Route::delete('/delete-payment/{id}', [PaymentController::class, 'destroy']);

    // Special Requests
    Route::post('/add-special-request', [SpecialRequestController::class, 'store']);
    Route::get('/get-special-requests/{reservation_id}', [SpecialRequestController::class, 'showByReservation']);
    Route::put('/edit-special-request/{id}', [SpecialRequestController::class, 'update']);
    Route::delete('/delete-special-request/{id}', [SpecialRequestController::class, 'destroy']);

    // Notifications
    Route::post('/add-notification', [NotificationController::class, 'store']);
    Route::get('/get-notifications', [NotificationController::class, 'index']);
    Route::put('/edit-notification/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/edit-notification/{id}', [NotificationController::class, 'update']); // Add update route
    Route::delete('/delete-notification/{id}', [NotificationController::class, 'destroy']);

    
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
