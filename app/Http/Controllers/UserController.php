<?php

namespace App\Http\Controllers;


use App\Aeronave;
use App\Http\Requests\StoreSocio;
use App\Movimento;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use DB;
use App\Http\Requests\UpdateSocio;

use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::user()->direcao) {
            $matchThese = [['id', '<>', '-1'], ['num_socio', '<>', '-1']];

            $socios = UserController::filter($request, $matchThese);
        } else {
            $matchThese = [['ativo', '=', '1'], ['num_socio', '<>', '-1']];

            $socios = UserController::filter($request, $matchThese);
        }
        $title = 'Sócios';
        return view('socios.list', compact('title', 'socios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('direcao', Auth::user())) {
            $title = 'Inserir novo sócio';
            $socio = new User();
            return view('socios.add', compact('title', 'socio'));
        } else {
            return Response(view('errors.403'), 403);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSocio $request)
    {
        dd($request);
        $image = $request->file('foto_url');

        if ($request->hasFile('foto_url')) {
            if ($request->file('foto_url')->isValid()) {
                Storage::putFile('/storage/app/public/fotos/', $request->file('foto_url'));
                $name = time() . '.' . $image->getClientOriginalExtension();
            }

        }

        $socio = $request->validated();
        //$socio->image = $name;
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
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $socio)
    {
        if (Auth::user()->direcao == 1 || Auth::user()->id == $socio->id) {
            $title = "Editar Sócio";
            return view('socios.edit', compact('title', 'socio'));

        } else {
            return Response(view('errors.403'), 403);

        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSocio $request, User $socio)
    {

        $image = $request->file('foto_file');

        if ($request->hasFile('foto_file')) {
            if ($request->file('foto_file')->isValid()) {
              //  Storage::putFile('/storage/app/public/fotos/', $request->file('foto_file'));
                Storage::putFile('public/fotos/', $request->file('foto_file'));

                $name = time() . '.' . $image->getClientOriginalExtension();
                $socio->foto_url = $name;
            }

        }

        $socioEdit = $request->validated();

        $keys = array_keys($socioEdit, null, true);

        foreach ($keys as $key) {
            unset($socioEdit[$key]);
        }

        $socio->fill($socioEdit);
        $socio->save();
        if (Auth::user()->tipo_socio == 'P') {
            User::where('licenca_confirmada', '1')->update(['licenca_confirmada' => '0']);
            User::where('certificado_confirmado', '1')->update(['certificado_confirmado' => '0']);
        }

        return redirect()->action('UserController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $socio)
    {
        Storage::delete("public/fotos/$socio->foto_url");
        if (Movimento::where('piloto_id', $socio->id)->count() == 0 && Movimento::where('instrutor_id', $socio->id)->count() == 0) {
            $socio->forceDelete();
        } else {
            $socio->delete();
        }

        return redirect()->back();
    }

    public function showChangePasswordForm()
    {
        return view('auth.changepassword');
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("errors", "Your current password does not matches with the password you provided. Please try again.");
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("errors", "New Password cannot be same as your current password. Please choose a different password.");
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

    public function quota(Request $request, User $socio)
    {
        $socio->quota_paga = $request->quota_paga;
        $socio->save();


        return redirect()->back()->with('success');
    }

    public function ativarSocio(Request $request, User $socio)
    {
        $socio->ativo = $request->ativo;
        $socio->save();

        return redirect()->back()->with('success');
    }

    public function desativarSemQuotas()
    {
        User::where('quota_paga', '0')->update(['ativo' => '0']);

        return redirect()->action('UserController@index');
    }

    public function resetQuota()
    {
        User::where('quota_paga', '1')->update(['quota_paga' => '0']);

        return redirect()->action('UserController@index');
    }

    public function certificado(User $piloto)
    {


        return response()->file(storage_path("app/docs_piloto/certificado_{$piloto->id}.pdf"));

    }

    public function licenca(User $piloto)
    {


        return response()->file(storage_path("app/docs_piloto/licenca_{$piloto->id}.pdf"));

    }

    public function sendReActivationEmail(User $socio)
    {
        $socio->sendEmailVerificationNotification();

        return redirect()->back();
    }

    public static function filter(Request $request, $matchThese)
    {

        if ($users = User::where($matchThese)) {


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
            if ($request->filled('direcao')) {
                $users = $users->where('direcao', $request->direcao);
            }
            if ($request->filled('quota_paga')) {
                $users = $users->where('quota_paga', $request->quota_paga);
            }
            if ($request->filled('ativo')) {
                $users = $users->where('ativo', $request->ativo);
            }
        }

        $users = $users->orderBy('num_socio', 'asc')
            ->orderBy('num_socio')
            ->paginate(24);
        return $users;
    }



}
