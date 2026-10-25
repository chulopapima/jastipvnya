<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RequestController;

// Homepage
Route::get('/', [TripController::class, 'index']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Dashboard Jastiper (Dialihkan ke TripController agar data pendapatan & kolaborasi tim tampil)
Route::get('/dashboard-jastiper', [TripController::class, 'dashboardJastiper'])->middleware('auth');

// Dashboard Pembeli
Route::get('/dashboard-pembeli', function () {
    if (\Illuminate\Support\Facades\Auth::user()->role !== 'pembeli') {
        return redirect('/dashboard-jastiper');
    }
    $trips = \App\Models\Trip::with('user')->latest()->get();
    $myRequests = \App\Models\ItemRequest::where('user_id', \Illuminate\Support\Facades\Auth::id())->with('trip')->latest()->get();
    return view('dashboard_pembeli', compact('trips', 'myRequests'));
})->middleware('auth');

// Group Routes dengan Middleware Auth
Route::middleware(['auth'])->group(function () {
    // CRUD Trip Routes (Khusus Jastiper)
    Route::get('/trip/create', [TripController::class, 'create']);
    Route::post('/trip/store', [TripController::class, 'store']);
    Route::get('/trip/edit/{id}', [TripController::class, 'edit']);
    Route::put('/trip/update/{id}', [TripController::class, 'update']);
    Route::delete('/trip/delete/{id}', [TripController::class, 'destroy']);

    // CRUD Request & Progress Routes (Pembeli & Jastiper)
    Route::get('/request/create', [RequestController::class, 'create']);
    Route::post('/request/store', [RequestController::class, 'store']);
    Route::post('/request/accept/{id}', [RequestController::class, 'accept']);
    Route::post('/request/reject/{id}', [RequestController::class, 'reject']);
    Route::post('/request/progress/{id}', [RequestController::class, 'updateProgress']);
    Route::delete('/request/delete/{id}', [RequestController::class, 'destroy']);
    
    // Midtrans Payment Routes
    Route::get('/request/pay/{id}', [RequestController::class, 'pay']);
    
    // Rute Sukses Pembayaran
    Route::get('/request/success/{id}', [RequestController::class, 'success']);

    Route::middleware(['auth'])->group(function () {
    // Rute Cetak Resi / Invoice Per Pesanan
    Route::get('/request/resi/{id}', [RequestController::class, 'cetakResi']);
});
});