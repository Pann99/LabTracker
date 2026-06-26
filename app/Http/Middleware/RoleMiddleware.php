<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: middleware('role:admin') atau middleware('role:user')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            // Jika sudah login tapi role salah, redirect ke dashboard masing-masing
            if ($request->user()) {
                if ($request->user()->isAdmin()) {
                    return redirect()->route('admin.alat.index')
                                     ->with('error', 'Akses ditolak.');
                }
                return redirect()->route('user.peminjaman.index')
                                 ->with('error', 'Akses ditolak.');
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}