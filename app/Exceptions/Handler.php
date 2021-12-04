<?php

namespace App\Exceptions;

use http\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        'current_password',
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
        $this->renderable(function (NotFoundHttpException $e , $request){
            if($request->expectsJson()){
                return Route::respondWithRoute('api.fallback');
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e , $request){
            if($request->expectsJson()){
                return Route::respondWithRoute('api.fallback');
            }
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
