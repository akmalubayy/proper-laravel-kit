<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Resource tidak ditemukan.',
                    'error' => 'Not Found'
                ], 404);
            }

            return response()->view('errors.404', [], 404);
        });

        $this->renderable(function (Throwable $e, $request) {
            //
        });
    }
}
