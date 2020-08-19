<?php

namespace App\Exceptions;

use App\Traits\GeneralTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    use GeneralTrait;
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof TokenBlacklistedException){
            return response(['error' => 'Token can not use , get new one'],Response::HTTP_BAD_REQUEST);
        }
        elseif($exception instanceof TokenInvalidException){
            return response(['error' => 'Token innvalid'],Response::HTTP_BAD_REQUEST);
        }
        elseif($exception instanceof TokenExpiredException){
            return response(['error' => 'Token is expire'],Response::HTTP_BAD_REQUEST);
        }

        elseif($exception instanceof JWTException){
            return response(['error' => 'Token is not provided'],Response::HTTP_BAD_REQUEST);
        }

        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("0001","Does exist any {$model} with this specified identiticator",404);
        } 

        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request,$exception);
        }

        if($exception instanceof AuthorizationException){
            return $this->errorResponse("0002",$exception->getMessage(),409);
        }

        if($exception instanceof NotFoundHttpException){
            return $this->errorResponse("0003",'The Specified Url cannot be found',404);
        }

        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse("0004",'the specified method you for request is invalid',405);
        }

        /*if($exception instanceof ValidationValidationExcepto){
           return $this->convertValidationExceptionToResponse($exception,$request);
        }*/
        if($exception instanceof BadRequestHttpException){
            return $this->errorResponse("0005",'Bad request does not exist' ,$exception->getStatusCode());
        }

       
        if($exception instanceof HttpException){
            return $this->errorResponse("0006",$exception->getMessage(),$exception->getStatusCode());
        }

        if($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            if($errorCode === 1451){
                return $this->errorResponse("0007",'Cannot remove this resource permanetly . It is related with any other resources',409);
            }
            else{
                return $this->errorResponse("0008",$exception->getMessage(),500);
            }
        }

        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        return $this->errorResponse("0009",'unexcepted exception',500);

    }
}
