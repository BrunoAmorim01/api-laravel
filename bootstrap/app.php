<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        channels: __DIR__.'/../routes/channels.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $ex, Request $request) {

            if ($ex instanceof AuthenticationException) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => $ex->getMessage(),
                    ], 401);

                }
            }

            if ($ex instanceof BadRequestHttpException) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'message' => $ex->getMessage(),
                    ], 400);
                }
            }
        });


        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });



    })->create();
