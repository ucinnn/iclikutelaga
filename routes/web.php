<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Middleware bisa pakai alias 'valid.role' jika didaftarkan di Kernel.php
Route::get('/users', function () {
    return view('livewire.show-home');
})->middleware(['auth']); // auth + custom role middleware

// // Route untuk logout
Route::post('/logout', function () {
    \Filament\Facades\Filament::auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/admin/login');
})->name('logout');

Route::get('/admin/custom-logout', [\App\Http\Controllers\LogoutController::class, 'logout'])->name('custom.logout');

// Route::get('/login', function () {
//     return view('filament.auth.login'); // 👈 Sesuaikan dengan tampilan login kamu
// })->name('login');

// Route::post('/login', function (Request $request) {
//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $request->session()->regenerate();

//         // Arahkan ke dashboard sesuai role
//         return redirect()->intended('/user/dashboard');
//     }

//     return back()->withErrors([
//         'email' => 'Login gagal, periksa kembali email dan password.',
//     ]);
// });