<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CheckPeriodSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, Closure $next)
{
    // 1. Verificamos si el usuario está logueado
    if (Auth::check()) {
        // 2. Si el usuario es ADMINISTRADOR, lo dejamos pasar siempre
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        // 3. Si es PROFESOR y NO ha elegido periodo, lo mandamos al selector
        if (Auth::user()->role === 'profesor' && !session()->has('periodo_anio_id')) {
            if (!$request->is('select-period')) {
                return redirect()->route('period.select');
            }
        }
    }

    return $next($request);
}
}
