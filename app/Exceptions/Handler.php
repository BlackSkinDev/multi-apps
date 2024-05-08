<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\ThrottleRequestsException;


class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            $error = 'Route not found';
            if ($e instanceof ModelNotFoundException) {
                $modelName = class_basename($e->getModel());
                $error = "$modelName not found";
            }
          return errorResponse($error, 404);
        }
        elseif ($e instanceof ValidationException) {
           return errorResponse($e->validator->errors()->first(), Response::HTTP_UNPROCESSABLE_ENTITY, $e->validator->errors());
        }
        elseif ($e instanceof AuthenticationException) {
           return errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        elseif ($e instanceof ClientErrorException) {
            return errorResponse($e->getMessage(),$e->getCode());
        }

        elseif ($e instanceof ThrottleRequestsException) {
            return errorResponse('Max attempts exceeded.Retry later.',$e->getCode());
        }

        return  errorResponse($e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
