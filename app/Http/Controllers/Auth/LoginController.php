<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    protected $jwtauth;

    /**
     * Create a new controller instance.
     * @param JWTAuth $jwtauth
     */
    public function __construct(JWTAuth $jwtauth)
    {
        $this->jwtauth = $jwtauth;
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->json()->all();

        try {
            if (! $token = $this->jwtauth->attempt($credentials)) {
                return response()->json(['error' => 'Usuario o contraseña inválido'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ha ocurrido un error'], 500);
        }

        return response()->json(compact('token'));
    }
}
