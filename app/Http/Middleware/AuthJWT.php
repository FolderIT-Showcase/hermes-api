<?php

namespace App\Http\Middleware;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;

class authJWT
{
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::toUser($request->header('Authorization'));
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
