<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller
{
    protected $jwtauth;

    /**
     * Create a new controller instance.
     *
     * @param JWTAuth $jwtauth
     */
    public function __construct(JWTAuth $jwtauth)
    {
        $this->jwtauth = $jwtauth;
        $this->middleware('jwt.auth', ['except' => ['register']]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->json()->all());

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }

        $newUser = $this->create($request->json()->all());

        $rol = Role::where('id', $request->rol_id)->first();
        $newUser->attachRole($rol);
        $newUser->save();

        return response()->json($newUser->load('roles'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
