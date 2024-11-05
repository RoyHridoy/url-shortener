<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (ValidationException $exception) {
            foreach ($exception->errors() as $value) {
                foreach ($value as $message) {
                    $errors[] = [
                        'status' => 422,
                        'message' => $message,
                    ];
                }
            }
            return response()->json(['errors' => $errors]);
        });

        $exceptions->render(function (AuthenticationException $exception) {
            return response()->json([
                'errors' => [
                    'status' => 401,
                    'message' => 'Unauthenticated'
                ]
            ]);
        });

        $exceptions->render(function (NotFoundHttpException $exception) {
            return response()->json([
                'errors' => [
                    'status' => 404,
                    'message' => 'The Resource cannot be found.'
                ]
            ]);
        });

        // All kind of Exceptions will be Handled
        $exceptions->render(function (Throwable $exception) {
            $className = get_class($exception);
            $index = strrpos($className, '\\');
            return response()->json([
                'errors' => [
                    'type' => substr($className, $index + 1),
                    'status' => 0,
                    'message' => $exception->getMessage()
                ]
            ]);
        });
    })->create();
