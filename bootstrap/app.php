<?php

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->redirectUsersTo('home'); 
        $middleware->redirectGuestsTo('/'); 
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
