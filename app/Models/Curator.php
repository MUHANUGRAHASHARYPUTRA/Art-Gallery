<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Curator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'curator') {
            
            // TAMBAHAN: Jika status pending, lempar ke halaman pending
            if (Auth::user()->status === 'pending') {
                return redirect()->route('curator.pending');
            }

            return $next($request);
        }

        abort(403);
    }
}