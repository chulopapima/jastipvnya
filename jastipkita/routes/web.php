<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RequestController;
use App\Http\Middleware\CekSession;

// Homepage
Route::get('/', [TripController::class, 'index']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::post('/logout', [AuthController::class, 'logout']);

// =========================================================
// RUTE YANG DILINDUNGI (Menggunakan Class Middleware)
// =========================================================
Route::middleware([CekSession::class])->group(function () {

    Route::get('/dashboard-jastiper', [TripController::class, 'dashboardJastiper']);

    Route::get('/dashboard-pembeli', function () {
        if (session('user_role') !== 'pembeli') {
            return redirect('/dashboard-jastiper');
        }
        
        $trips = \App\Models\Trip::with('user')->latest()->get();
        $myRequests = \App\Models\ItemRequest::where('user_id', session('user_id'))->with('trip')->latest()->get();
        
        return view('dashboard_pembeli', compact('trips', 'myRequests'));
    });

    Route::get('/trip/create', [TripController::class, 'create']);
    Route::post('/trip/store', [TripController::class, 'store']);
    Route::get('/trip/edit/{id}', [TripController::class, 'edit']);
    Route::put('/trip/update/{id}', [TripController::class, 'update']);
    Route::delete('/trip/delete/{id}', [TripController::class, 'destroy']);

    Route::get('/request/create', [RequestController::class, 'create']);
    Route::post('/request/store', [RequestController::class, 'store']);
    Route::post('/request/accept/{id}', [RequestController::class, 'accept']);
    Route::post('/request/reject/{id}', [RequestController::class, 'reject']);
    Route::post('/request/progress/{id}', [RequestController::class, 'updateProgress']);
    Route::delete('/request/delete/{id}', [RequestController::class, 'destroy']);
    
    Route::get('/request/pay/{id}', [RequestController::class, 'pay']);
    Route::get('/request/success/{id}', [RequestController::class, 'success']);
    Route::get('/request/resi/{id}', [RequestController::class, 'cetakResi']);
});

// =========================================================
// RUTE PERBAIKAN DATABASE (Jalankan sekali di browser)
// =========================================================
Route::get('/fix-db', function () {
    // Suntik akun Pembeli (ID 1)
    \App\Models\User::updateOrCreate(
        ['id' => 1],
        ['name' => 'User Pembeli', 'email' => 'Pembeli@gmail.com', 'password' => bcrypt('123'), 'role' => 'pembeli']
    );

    // Suntik akun Jastiper (ID 2)
    \App\Models\User::updateOrCreate(
        ['id' => 2],
        ['name' => 'User Jastiper', 'email' => 'jastiper@gmail.com', 'password' => bcrypt('123'), 'role' => 'jastiper']
    );

    return "Berhasil! Akun dummy sudah dimasukkan ke database. Silakan kembali ke web dan coba buat trip lagi.";
});