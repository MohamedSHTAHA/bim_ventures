<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Check if the request expects JSON or it's an API request
        if ($request->expectsJson() || $request->is('api/*')) {
            // Handle API-specific exceptions here
            // For example, return a JSON response
            // return $exception;
            // dd($exception->getMessage(), $exception);
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    protected function handleApiException(Request $request, Throwable $exception)
    {
        // $statusCode = method_exists($exception, 'getStatusCode') && $exception->getStatusCode()
        //     ? $exception->getStatusCode()
        //     : ((bool)$exception->getCode() ? $exception->getCode() : 500); // Default status code if none is available
        // dd($statusCode, ((bool)$exception->getCode() ? $exception->getCode() : 500));
        $statusCode = $this->isHttpException($exception) ? $exception->getStatusCode() : ((bool)$exception->getCode() ? $exception->getCode() : 500);

        // Map specific exception types to appropriate status codes
        $statusCode = $this->mapExceptionToStatusCode($exception, $statusCode);


        return Response::apiResponse($exception->getMessage(), [], $statusCode);
    }

    protected function mapExceptionToStatusCode(Throwable $exception, int $statusCode): int
    {
        if (
            $exception instanceof ModelNotFoundException ||
            $exception instanceof NotFoundHttpException
        ) {
            return 404; // Resource not found
        }

        if ($exception instanceof ValidationException) {
            return 422; // Unprocessable Entity (validation errors)
        }

        if ($exception instanceof AuthenticationException) {
            return 401; // Unauthorized
        }

        if ($exception instanceof HttpException) {
            return (int) $exception->getStatusCode(); // Other HTTP exceptions
        }




        // Add more mappings for expected exceptions here...

        return $statusCode;
    }
}
