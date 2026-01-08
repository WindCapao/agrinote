<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__)) //set base path
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {  //register middleware
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,  //admin check
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {  //register exception handlers
        //
    })->create();