<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSocio;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {

            $users = UserController::filter($request);


        } else {

            return Response(view('errors.403'), 403);
        }


        return view('users.users', compact('users'))->with('users', $users);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('users.add', compact('user'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSocio $request)
    {

        $socio = $request->validated();

        $num_socio = User::max('num_socio');
        $socio['num_socio'] = ++$num_socio;
        $socio['password'] = Hash::make($socio['data_nascimento']);
        $user = User::create($socio);
        $user->sendEmailVerificationNotification();


        return redirect()->action('UserController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nao é para fazer
    }


    public function edit(User $user)
    {

        return view('users.edit', compact('user'));
    }


    public function update(StoreSocio $request, User $user)
    {


        $rules = [
            'name' => 'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email,' . user()->id . ',id',
            'nome_informal' => 'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'sexo' => 'required',
            'data_nascimento' => 'required|date',
            'nif' => 'required|integer|max:999999999',
            'telefone' => 'required|long|regex:/^\+?\d{3}(?: ?\d+)*$/',
            'endereco' => 'required',
            'tipo_socio' => 'required',
            'file_foto' => 'nullable|image'
        ];


        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator);

        }
        $fileCertificado = $request->file('certificate');

        if ($fileCertificado != null) {
            $validator['certificado_confirmado'] = 0;

        }
        if ($fileCertificado->isValid()) {


            $certificadoNome = 'certificado_' . $user->id . '.' . $fileCertificado->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('app/docs_piloto/' . $user->id, $fileCertificado, $certificadoNome);
        } else {
            //if user has a certificate and want to change it


        }

        $name = $request->file_foto;

        if ($name->isValid()) {
            $name = $name->hashname();

            Storage::disk('public')->putFileAs('fotos', request()->file('file_foto'), $name);
        }
        $keys = array_keys($validator, null, true);

        foreach ($keys as $key) {
            unset($validator[$key]);
        }
        $user->fill($validator);
        $user->save();
        return redirect()->action('UserController@index');

        /*
    $socioEdit = $request->validated();
    dd($socioEdit);
//        $request->profile_picture->storeAs('fotos', $socio->id.'_pic.jpg');

    $keys = array_keys($socioEdit, null, true);

    foreach ($keys as $key) {
        unset($socioEdit[$key]);
    }
    */


    }

    public static function filter(Request $request)
    {
        if ($users = User::where('num_socio', '<>', -1)) {

            if ($request->filled('email')) {
                $users = $users->where('email', $request->email);
            }
            if ($request->filled('tipo_socio')) {
                $users = $users->where('tipo_socio', $request->tipo_socio);
            }
            if ($request->filled('num_socio')) {

                $users = $users->where('num_socio', $request->num_socio);
            }
            if ($request->filled('nome_informal')) {
                $users = $users->where('nome_informal', $request->nome_informal);
            }

            if ($request->filled('direcao')) {
                $users = $users->where('direcao', $request->direcao);
            }
        }
        $users = $users->orderBy('num_socio', 'asc')
            ->orderBy('num_socio')
            ->paginate(20);

        return $users;
    }


    public function showChangePasswordForm()
    {
        return view('auth.changepassword');
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success", "Password changed successfully !");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');

    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user', $user));
    }

    public function certificado(User $piloto)
    {


        return response()->file(storage_path("app/docs_piloto/certificado_{$piloto->id}.pdf"));

    }

    public function licenca(User $piloto)
    {


        return response()->file(storage_path("app/docs_piloto/licenca_{$piloto->id}.pdf"));

    }

}
