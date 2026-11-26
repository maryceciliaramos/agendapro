<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // REGISTRE O MIDDLEWARE AQUI:
        $middleware->alias([
            'active' => \App\Http\Middleware\CheckActiveUser::class,
            'is_admin' => \App\Http\Middleware\EnsureUserIsAdmin::class, // Adicione esta linha
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
