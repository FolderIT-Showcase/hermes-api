<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    private $hasher;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HasherContract $hasher)
    {
        $this->middleware('jwt.auth', ['except' => ['reset']]);
        $this->hasher = $hasher;
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        //Se comprueba que todos los campos estén presentes y sean válidos
        try {
            $this->validate($request, $this->rules(), $this->validationErrorMessages());
        } catch (ValidationException $exception) {
            return response()->json(['error' => $exception->validator->errors()], 400);
        }

        //Se obtiene la fila de la tabla reset_password que contiene el email y el token
        $query = DB::query()
            ->from('password_resets')
            ->where('email', '=', $request->json()->all()['email']);
        $reset = $query->first();

        if($reset === null) {
            return response(['error' => 'Reestablecimiento de contraseña no solicitado por el usuario']);
        }

        //Se comprueba que el token recibido como parámetro se corresponda con el almacenado
        if(!$this->hasher->check($request->json()->all()['token'], $reset->token)){
            return response()->json(['error' => 'Token inválido'], 400);
        } else {
            //Se verifica que el token no haya expirado, la expiración es de 1 hora
            $now = Carbon::now();
            $created_at = Carbon::parse($reset->created_at);
            $diff = $now->diffInSeconds($created_at);
            if($diff >= 3600) {
                return response()->json(['error' => 'Token expirado'], 400);
            } else {

                //Se setea en el usuario la nueva contraseña y se borra la fila del reset_password
                $user = User::where('email', '=', $request->json()->all()['email'])->first();
                $user->password = bcrypt($request->json()->all()['password']);
                $user->save();
                $query->delete();

                return response()->json('ok');
            }
        }
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->json()->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }
}
