<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            return response()->view('errors.403', [], 403);
        }

        if ($this->isHttpException($e)) {
            $statusCode = $e->getStatusCode();

            switch ($statusCode) {
                case '404':
                    $data = [
                        'siteUrl' => \Session::get('siteUrl'),
                        'lang'    => \Session::get('lang'),
                    ];
                    return response()->view('errors.404', $data, 404);  // this is to avoid redirection. Not using ErrorsController
                break;
                case '429':
                    return redirect()->route('lockout_path')->withError('Too many request. Locked for 60s.');  // 429
                break;

                // return redirect()->route('404_error_path')->with('unknownUrl', \URL::current());
            }
        }

        return parent::render($request, $e);
    }
}
