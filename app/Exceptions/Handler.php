<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Throwable;

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
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        //
        });
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Flare, Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            if($request->expectsJson()) {
                return response()->json(['status' => 'FAILED', 'code' => 404, 'message' => 'Record not found.'], 404);
            }
        }
        return parent::render($request, $exception);
    }
}
