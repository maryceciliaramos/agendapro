<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- ADICIONE ESTA LINHA

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    // Verifica se o usuário logado é admin
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }

    // Se não for admin, redireciona para o dashboard comum
    return redirect('/dashboard')->with('error', 'Acesso negado. Área exclusiva do administrador.');
}
    }

