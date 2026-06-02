<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Facades\Filament;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class EnsureHasValidRole
{
    protected array $allowedRoles = ['superadmin', 'admin', 'author'];

    public function handle(Request $request, Closure $next): Response
    {
        // Jika ini adalah request logout, tangani khusus
        if ($request->is('admin/logout')) {
            // Hapus semua session terlebih dahulu
            Session::flush();
            
            // Lalu logout dari Filament
            if (Filament::auth()->check()) {
                Filament::auth()->logout();
            }
            
            // Redirect ke halaman login dengan pesan sukses
            return redirect('admin/login')->with('status', 'Anda berhasil logout.');
        }
        
        $user = Filament::auth()?->user();

        // Biarkan login dan route publik bisa diakses tanpa autentikasi
        if (! $user) {
            // Jangan blokir jika sedang menuju halaman login
            // Filament login terletak di /admin/login
            if ($request->is('admin/login') || $request->is(Filament::getLoginUrl())) {
                return $next($request);
            }

            return redirect('admin/login');
        }

        // Cek session 'modul', jika tidak ada, redirect ke login
        // Skip pengecekan modul jika URL saat ini adalah logout (agar logout tetap bisa dilakukan)
        $selectedModule = session('modul');
        if (! $selectedModule && !$request->is('admin/logout')) {
            // Bersihkan semua session terlebih dahulu
            Session::flush();
            
            // Lalu logout dari Filament
            Filament::auth()->logout();
            
            return redirect('admin/login')->withErrors([
                'email' => 'Sesi modul tidak ditemukan. Silakan login kembali.',
            ]);
        }

        $path = trim($request->path(), '/');

        // Jika mengakses /admin
        if (Str::startsWith($path, 'admin')) {
            if (!in_array($user->role, $this->allowedRoles)) {
                return redirect('/users')->with('error', 'Anda tidak memiliki izin untuk mengakses area admin.');
            }

            if ($path === 'admin') {
                return redirect()->route('filament.admin.pages.dashboard');
            }
        }

        // Jika mengakses /user
        if (Str::startsWith($path, 'user')) {
            if ($path === 'user') {
                return redirect('/users');
            }
        }

        return $next($request);
    }
}