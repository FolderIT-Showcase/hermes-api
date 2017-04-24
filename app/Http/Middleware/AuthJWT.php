<?php

namespace App\Http\Middleware;
use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class authJWT
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json(['error'=>'El token es inválido']);
            }else if ($e instanceof TokenExpiredException){
                return response()->json(['error'=>'El token ha expirado']);
            }else{
                return response()->json(['error'=>'Ha ocurrido un error']);
            }
        }
        return $next($request);
    }
}
