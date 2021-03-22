<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function( NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return Route::respondWithRoute('api.fallback');
            }

            return parent::render($request, $e);
        });
        $this->renderable(function( AccessDeniedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()
                    ->json(
                        ['message' => $e->getMessage()]
                    , 403);
            }

            return parent::render($request, $e);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
