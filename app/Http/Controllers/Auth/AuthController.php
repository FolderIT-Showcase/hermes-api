<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $jwtauth;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        if(isset($request->json()->all()['username'])
            && isset($request->json()->all()['password'])
            && isset($request->json()->all()['tenant'])) {
            $credentials = ['username' => $request->json()->all()['username'], 'password' => $request->json()->all()['password']];
            $tenant = ['ten' => $request->json()->all()['tenant']];
        } else {
            return response()->json(['error' => 'Parámetros incorrectos'], 401);
        }

        try {
            if (! $token = JWTAuth::customClaims($tenant)->attempt($credentials)) {
                return response()->json(['error' => 'Usuario o contraseña inválido'], 401);
            }
        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 500);
        }
        $user = $this->guard()->user();

        return response()->json(['token'=>$token, 'user'=>$user]);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json('ok');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json(['token' => $this->guard()->refresh()]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
