<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new socios as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect socios after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
          // 'id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:socios'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'num_socio' => ['required', 'int', 'max:11'],
          /*  'nome_informal' => ['required', 'string', 'max:255'],
            'sexo'=>  'required',
            'data_nascimento'=>  'required',
            'nif'=>  'nullable',
            'telefone' => 'nullable|string|unique:socios|regex:/^(\+\d{2,3})?\s*\d{3}\s*\d{3}\s*\d{3}$/',
*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
         if (isset($data['profile_photo'])) {
            $imagem= $data['profile_photo'];
            $nome = basename($imagem->store('profiles', 'public'));
        } else {
            $nome= null;
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_photo' => $nome,
            'phone' => $data['phone'] ?? null,

        ]);


    }

     protected function showRegistrationForm()
    {
        $pagetitle="Register";
        return view('auth.register', compact('pagetitle'));
    }
}
