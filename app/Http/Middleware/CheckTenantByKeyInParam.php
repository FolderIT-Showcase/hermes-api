<?php

namespace App\Http\Middleware;

use Closure;
use Tenant;

class CheckTenantByKeyInParam
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
        if(isset($request->json()->all()['tenant'])) {
            $ten = $request->json()->all()['tenant'];
        } else {
            return response()->json(['error' => 'Parámetros incorrectos'], 401);
        }
        $tenant = Tenant::setTenantByKey($ten);

        if (!$tenant) {
            return response()->json(['error' => 'Empresa incorrecta.'], 401);
        }

        return $next($request);
    }
}
