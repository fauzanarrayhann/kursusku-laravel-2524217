<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Hanya akun dengan role "admin" (dan berstatus aktif) yang boleh lewat.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh admin.');
        }

        return $next($request);
    }
}
