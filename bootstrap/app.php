<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'DataTables' => Yajra\DataTables\Facades\DataTables::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
        $middleware->web([
            //
        ]);
        $middleware->api([
            //
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            return ResponseError($exception, "Record not found", 404);
        });
    })
    ->create();
