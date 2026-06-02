<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika pengguna tidak login, lanjutkan ke middleware autentikasi
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Filament::auth()->user();
        $selectedModul = session('modul', null);

        // Jika modul belum dipilih, redirect ke login
        if (!$selectedModul) {
            Auth::logout();
            return redirect()->route('filament.auth.login')
                ->with('error', 'Silakan pilih modul terlebih dahulu.');
        }

        // Validasi akses ke modul Admin
        if ($selectedModul === 'admin' && $user->role !== 'admin') {
            Auth::logout();
            return redirect()->route('filament.auth.login')
                ->with('error', 'Anda tidak memiliki akses ke modul Admin.');
        }

        return $next($request);
    }
}
