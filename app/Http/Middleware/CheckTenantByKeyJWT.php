<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tenant;

class CheckTenantByKeyJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('Authorization') !== null ) {
            try{
                JWTAuth::setToken(str_replace('Bearer ', '', $request->header('Authorization')));
                $ten = JWTAuth::getPayload()->get('ten');
            } catch (\Exception $e){
                return response()->json(['error' => 'El token es inválido.'], 401);
            }

            $tenant = Tenant::setTenantByKey($ten);

            if (!$tenant) {
                return response()->json(['error' => 'Empresa incorrecta.'], 401);
            }
        }

        return $next($request);
    }
}
