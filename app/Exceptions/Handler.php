<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * @author change : Phi .
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $jsEx = new JsonMsgCommon(['msg' => 'Server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        if ($this->isQueryExp($exception)) {
            $jsEx = new JsonMsgCommon(['msg' => 'No connection to db'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } elseif ($this->isModelExp($exception)) {
            $jsEx = new JsonMsgCommon(['msg' => 'Invalid Parameter Value in the Request.'], Response::HTTP_NOT_FOUND);
        } elseif ($this->isHttpExp($exception)) {
            $jsEx = new JsonMsgCommon(['msg' => 'Invalid Route or Parameter in the Request.'], Response::HTTP_BAD_REQUEST);
        }

        return $request->wantsJson() ? $jsEx : parent::render($request, $exception);
    }

    /**
     * @author : Phi .
     * @param $exception
     * @return bool
     */
    public function isQueryExp($exception)
    {
        return $exception instanceof QueryException;
    }

    /**
     * @author : Phi .
     * if its a model not found exception
     * @param $exception
     *
     * @return bool
     */
    public function isModelExp($exception)
    {
        return $exception instanceof ModelNotFoundException;
    }

    /**
     * @author : Phi .
     * if its an http not found exception
     * @param $exception
     *
     * @return bool
     */
    public function isHttpExp($exception)
    {
        return $exception instanceof NotFoundHttpException;
    }
}
