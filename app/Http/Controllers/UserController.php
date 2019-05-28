<?php

namespace App\Http\Controllers;

use App\Aeronave;
use App\Http\Requests\StoreSocio;
use App\Movimento;
use Dotenv\Validator;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

use App\Http\Requests\UpdateSocio;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->direcao) {
            $socios = User::paginate(24);
        } else {
            $socios = User::where('ativo', 1)->paginate(24);
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
        $title = 'Inserir novo sócio';
        $socio = new User();

        return view('socios.add', compact('title', 'socio'));
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
        $title = "Editar Sócio";

        return view('socios.edit', compact('title', 'socio'));
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
        $socioEdit = $request->validated();

        $keys = array_keys($socioEdit, null, true);

        foreach ($keys as $key) {
            unset($socioEdit[$key]);
        }


        $socio->fill($socioEdit);
        $socio->save();


        return redirect()->action('UserController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Movimento::find($id)) {
            $user = User::findOrFail($id);
            $user->delete();

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

    public function desativar_sem_quotas(Request $request)
    {
        $socio = User::where('quota_paga', 0)->update([$request => 0]);
        $socio->save();
        return redirect()->back()->with('success');
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

}
