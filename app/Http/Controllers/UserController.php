<?php

namespace App\Http\Controllers;

use Dotenv\Validator;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

use App\Http\Requests;
//use App\Http\Controllers\Providers\Auth;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( Auth::check() )
        {
            //$users = User::orderBy('num_socio','asc')->paginate(10);
            $users = UserController::filter($request);


        }
        else{

            return Response(view('errors.403'), 403);
        }
         //$socios = User::orderBy('num_socio','asc')->paginate(10);

       // return view('posts.index')->with('posts', $posts);

        return view('socios.users',compact('users'))->with('socios',$users);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $this->authorize('create', User::class);
        $user = new User();
        return view('socios.add', compact('user'));

    }

    public static function filter(Request $request)
    {
        // TODO

        // P - Piloto
        // NP - Não Piloto (Normal)
        // New Version of Filter


        $users = User::where('num_socio', '<>', -1);


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

        if($request->input('direcao')){
            $users = $users->where('direcao', $request->direcao);
        }

        $users = $users->orderBy('num_socio', 'asc')
            ->orderBy('num_socio')
            ->paginate(20);

        return $users;

            dd($users);
        // V.1

        /**
         * // se nada estiver prenchido
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         * return User::paginate(10);
         * }
         *
         * // se tipo_socio invalido
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email') && !$request->filled('direcao')
         * && ($request->filled('tipo_socio') != 'P' && $request->query('tipo_socio') != 'NP')) {
         * return User::paginate(10);
         * }
         *
         *
         * // só Piloto
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email') && !$request->filled('direcao')
         * && !$request->filled('tipo_socio') && $request->filled('tipo_socio') && $request->query('tipo_socio') == 'P') {
         * return User::where('P', '=', true)->paginate(10);
         * }
         *
         * // só Não-Piloto
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email') && !$request->filled('direcao')
         * && !$request->filled('tipo_socio') && $request->filled('tipo_socio') && $request->query('tipo_socio') == 'NP') {
         * return User::where('NP', '=', true)->paginate(10);
         * }
         *
         * // só direcao
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email')
         * && !$request->filled('tipo_socio') && $request->filled('direcao')) {
         * return User::where('direcao', '=', true)->paginate(10);
         * }
         *
         * //só email
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && $request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         * return User::where('email', 'like', '%' . $request->query('email') . '%')->paginate(10);
         * }
         *
         * //só nome_informal
         * if (!$request->filled('num_socio') && $request->filled('nome_informal') && !$request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         * return User::where('nome_informal', 'like', '%' . $request->query('nome_informal') . '%')->paginate(10);
         * }
         *
         * // só numSocio
         * if ($request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         * return User::where('num_socio', 'like', '%' . $request->query('num_socio') . '%')->paginate(10);
         * }
         *
         *
         * //nome+não-piloto
         * if (!$request->filled('num_socio') && $request->filled('nome_informal') && !$request->filled('email')
         * && $request->filled('tipo_socio') && !$request->filled('direcao')) {
         * //'não-piloto'
         * if ($request->query('tipo_socio') == 'NP') {
         * return User::where('name', 'like', '%' . $request->query('name') . '%')->where('NP', '=', true)->paginate(10);
         * }
         * }
         *
         * //nome+piloto
         * if (!$request->filled('num_socio') && $request->filled('nome_informal') && !$request->filled('email')
         * && $request->filled('tipo_socio') && !$request->filled('direcao')) {
         * //'não-piloto'
         * if ($request->query('tipo_socio') == 'P') {
         * return User::where('name', 'like', '%' . $request->query('name') . '%')->where('P', '=', true)->paginate(10);
         * }
         * }
         *
         *
         * //nome + email
         * if (!$request->filled('num_socio') && $request->filled('nome_informal') && $request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         *
         * $fields = ['nome_informal', 'email'];
         * foreach ($fields as $field) {
         * if (!empty($request->$field)) {
         * $query->where($field, '=', $request->$field);
         * }
         * }
         * }
         *
         * //nome + email
         * if (!$request->filled('num_socio') && $request->filled('nome_informal') && $request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         *
         * $fields = ['nome_informal', 'email'];
         * foreach ($fields as $field) {
         * if (!empty($request->$field)) {
         * return User::where($query->where($field, '=', $request->$field));
         * }
         * }
         * }
         * //nome + num_socio
         * if ($request->filled('num_socio') && $request->filled('nome_informal') && !$request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         * $fields = ['nome_informal', 'num_socio'];
         * foreach ($fields as $field) {
         * if (!empty($request->$field)) {
         * return User::where($query->where($field, '=', $request->$field));
         * }
         * }
         * }
         *
         * //email + num_socio
         * if ($request->filled('num_socio') && !$request->filled('nome_informal') && $request->filled('email')
         * && !$request->filled('tipo_socio') && !$request->filled('direcao')) {
         * $fields = ['email', 'num_socio'];
         * foreach ($fields as $field) {
         * if (!empty($request->$field)) {
         * return User::where($query->where($field, '=', $request->$field));
         * }
         * }
         * }
         *
         * //nome + direcao
         * if (!$request->filled('num_socio') && $request->filled('nome_informal') && !$request->filled('email')
         * && !$request->filled('tipo_socio') && $request->filled('direcao')) {
         * if (Request::get('direcao')) {
         * return User::where('nome_informal', 'like', '%' . $request->query('nome_informal') . '%')->where('direcao', '=', true)->paginate(10);
         * }
         *
         * }
         *
         * //email + direcao
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && $request->filled('email')
         * && !$request->filled('tipo_socio') && $request->filled('direcao')) {
         * if (Request::get('direcao')) {
         * return User::where('email', 'like', '%' . $request->query('email') . '%')->where('direcao', '=', true)->paginate(10);
         * }
         *
         * }
         *
         *
         * //email + tipo
         * if (!$request->filled('num_socio') && !$request->filled('nome_informal') && $request->filled('email')
         * && $request->filled('tipo_socio') && !$request->filled('direcao')) {
         * //piloto
         * if ($request->query('tipo_socio') == 'P') {
         * return User::where('email', 'like', '%' . $request->query('email') . '%')->where('P', '=', true)->paginate(10);
         * } else {
         * //não-piloto
         * return User::where('email', 'like', '%' . $request->query('email') . '%')->where('NP', '=', false)->paginate(10);
         * }
         *
         * }
         *
         * //tipo + direcao
         * if (!$request->filled('num_socio') && $request->filled('nome_informal') && $request->filled('email')
         * && !$request->filled('tipo_socio') && $request->filled('direcao')) {
         * if (Request::get('direcao')) {
         * if ($request->query('tipo_socio') == 'P') {
         * return User::where('name', 'like', '%' . $request->query('num_socio') . '%')->where('P', '=', true)->where('direcao', '=', true)->paginate(10);
         * } else {
         * //não-piloto
         * return User::where('name', 'like', '%' . $request->query('num_socio') . '%')->where('NP', '=', true)->where('direcao', '=', true)->paginate(10);
         * }
         * }
         *
         * }
         *
         *
         * //tipo + num_socio
         * if ($request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email')
         * && $request->filled('tipo_socio') && !$request->filled('direcao')) {
         * //piloto
         * if ($request->query('tipo_socio') == 'P') {
         * return User::where('name', 'like', '%' . $request->query('num_socio') . '%')->where('P', '=', true)->paginate(10);
         * } else {
         * //não-piloto
         * return User::where('name', 'like', '%' . $request->query('num_socio') . '%')->where('NP', '=', false)->paginate(10);
         * }
         *
         * }
         *
         *
         * //direcao + num_socio
         * if ($request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email')
         * && !$request->filled('tipo_socio') && $request->filled('direcao')) {
         * if (Request::get('direcao')) {
         * return User::where('num_socio', 'like', '%' . $request->query('num_socio') . '%')->where('direcao', '=', true)->paginate(10);
         * }
         * }
         *
         * **/
    }



    public function store(Requests\StoreSocio $request)
    {
        /*
        $this->validate($request,[
            'name'=>'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'email'=>'required|email|unique:socios,email',
            'nome_informal'=>'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'sexo'=>'required',
            'data_nascimento'=>'required|date',
            'nif'=>'required|unique:socios,nif|numeric|max:999999999',
            'telefone'=>'required|unique:socios,telefone|regex:/^\+?\d{3}(?: ?\d+)*$/',
            'endereco'=>'required',
            'tipo_socio'=>'required',
            'file_foto'=>'nullable|image'
        ]);

          $user = new User();

        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->sendEmailVerificationNotification();
        $user->save();*/

//        $this->authorize('create', User::class);

        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);


        $user = User::create($data);

        $user->sendEmailVerificationNotification();


        return redirect()->action('UserController@index');


}


    public function show($id)
    {
     //nao é para fazer
    }


    public function edit(User $user)
    {


        if( Auth::check() ) {

            return view('socios.edit', compact('user'));
        }
        else{

            return Response(view('errors.403'), 403);
        }

    }



    public function update(Requests\StoreSocio $request, User $user)
    {


        $data = $request->validated();

        dd($data);

        $keys = array_keys($data, null, true);

        foreach ($keys as $key) {
            unset($data[$key]);
        }


        $user->fill($data );
        $user->save();



        $fileCertificado = $request->file('certificate');

        if ($fileCertificado->isValid()) {


            $name = 'certificado_'.$user->id. '.' . $fileCertificado->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('app/docs_piloto/' . $user->id, $fileCertificado, $name);
        } else{
            //if user has a certificate and want to change it


        }

        return redirect()->route('socios.index');
/*
        $user->fill($request->except('password'));
         $user->save();


        return redirect()->route('socios.index')->with('success', 'O seu perfil foi atualizado!');
*/
    }




    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("errors","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("errors","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
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
        return view('socios.profile',compact('user',$user));
    }
    public function certificado(User $piloto){


        return response()->file(storage_path("app/docs_piloto/certificado_{$piloto->id}.pdf"));

    }
    public function licenca(User $piloto){


        return response()->file(storage_path("app/docs_piloto/licenca_{$piloto->id}.pdf"));

    }
}
