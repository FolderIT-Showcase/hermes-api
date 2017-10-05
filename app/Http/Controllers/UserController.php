<?php

namespace App\Http\Controllers;

use App\ParametroUsuario;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;

class UserController extends Controller
{
    protected $jwtauth;

    public function __construct(JWTAuth $jwtauth)
    {
        $this->jwtauth = $jwtauth;
        $this->middleware('permission:view_usuario', ['only' => ['index', 'indexRoles', 'show']]);
        $this->middleware('permission:create_usuario', ['only' => ['store']]);
        $this->middleware('permission:edit_usuario', ['only' => ['update']]);
        $this->middleware('permission:delete_usuario', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::with('roles')->with('parametros')->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexRoles()
    {
        return response()->json(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->register($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return response()->json($usuario->load('roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        if($request->has('password')) {
            $validator = $this->validatorUpdate($request->json()->all());
        } else {
            $validator = $this->validatorUpdateNoPass($request->json()->all());
        }

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);
        }

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        if($request->has('password')) {
           $usuario->password = bcrypt($request->password);
        }
        $usuario->detachRole(null);
        $rol = Role::where('id', $request->rol_id)->first();
        $usuario->attachRole($rol);
        $usuario->save();

        return response()->json($usuario->load('roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return response()->json('ok', 200);
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
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorUpdateNoPass(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$data['id'],
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$data['id'],
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
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Display the specified resource in storage.
     *
     * @param User $usuario
     * @return \Illuminate\Http\Response
     */
    protected function getParametros(User $usuario)
    {
        return response()->json($usuario->parametros);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $usuario
     * @return \Illuminate\Http\Response
     */
    public function postParametros(Request $request, User $usuario)
    {
        $parametros = ParametroUsuario::firstOrNew(array('user_id' => $usuario->id));
        $parametros->fill($request->json()->all())->save();
        return response()->json($parametros);
    }
}
