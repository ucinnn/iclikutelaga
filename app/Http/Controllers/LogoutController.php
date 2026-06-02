<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Bersihkan semua session terlebih dahulu
        Session::flush();

        // Lalu logout dari Filament
        if (Filament::auth()->check()) {
            Filament::auth()->logout();
        }

        // Redirect ke halaman login dengan pesan sukses
        return redirect('admin/login')->with('status', 'Anda berhasil logout.');
    }
}
