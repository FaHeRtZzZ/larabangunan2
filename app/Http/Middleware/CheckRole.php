<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Cek apakah pengguna terotentikasi
        if (!Auth::check()) {
            return redirect('/login'); // Redirect ke login jika belum login
        }

        // Cek apakah pengguna memiliki peran yang sesuai
        if (Auth::user()->role !== $role) {
            return redirect('/'); // Redirect ke halaman utama jika tidak memiliki peran yang sesuai
        }

        return $next($request); // Melanjutkan request jika memenuhi syarat
    } 
}

