<?php

namespace App\Http\Controllers;

use App\Aeronave;
use App\Movimento;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UpdateAeronave;
use App\Http\Requests\StoreAeronave;
use Illuminate\Support\Facades\Gate;
use DB;

class AeronaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $aeronaves = Aeronave::orderBy('matricula', 'asc')->paginate(25);


        } else {

            return Response(view('errors.403'), 403);
        }


        return view('aeronaves.list', compact('aeronaves'))->with('aeronaves', $aeronaves);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('direcao', Auth::user())) {
            $aeronave = new Aeronave();
            return view('aeronaves.add', compact('aeronave'));
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
    public function store(StoreAeronave $request)
    {
        $aeronave = $request->validated();

        Aeronave::create($aeronave);

        return redirect()->action('AeronaveController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aeronave $aeronave
     * @return \Illuminate\Http\Response
     */
    public function show(Aeronave $aeronave)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aeronave $aeronave
     * @return \Illuminate\Http\Response
     */
    public function edit(Aeronave $aeronave)
    {
        if (Gate::allows('direcao', Auth::user())) {
            $title = "Editar Aeronave";
            return view('aeronaves.edit', compact('aeronave'));
        } else {
            return Response(view('errors.403'), 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Aeronave $aeronave
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAeronave $request, Aeronave $aeronave)
    {

        $matriculaEdit = $request->validated();

        $keys = array_keys($matriculaEdit, null, true);

        foreach ($keys as $key) {
            unset($matriculaEdit[$key]);
        }
        $aeronave->fill($matriculaEdit);
        $aeronave->save();
        return redirect()->route('aeronaves.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aeronave $aeronave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aeronave $aeronave)
    {
        if (Movimento::where('aeronave', $aeronave->matricula)->count() == 0) {
            $aeronave->forceDelete();
        } else {
            $aeronave->delete();
        }

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
    public function listaPilotosAutorizados(Aeronave $aeronave)
    {
        $title = "Pilotos autorizados a voar a aeronave $aeronave->matricula";
        $pilotoAeronavesId = DB::table('aeronaves_pilotos')->where('matricula',$aeronave->matricula)->pluck('piloto_id'); //autorizados


        $pilotos = User::where('tipo_socio','P');
        $pilotosAuto = User::where('tipo_socio','P');

        $pilotosNaoAuto = $pilotos->whereNotIn('id',$pilotoAeronavesId)->get(); //nao autorizados

        $pilotosAuto = $pilotosAuto->whereIn('id',$pilotoAeronavesId)->get(); //autorizados

        return view('socios.listaAutorizados', compact('title', 'pilotosAuto','pilotosNaoAuto','aeronave'));

    }
    public function removePiloto(User $piloto)
    {
        //  $pilotoRemovido = DB::table('aeronaves_pilotos')->where(['piloto_id','=',$piloto->id],['matricula','=',$aeronave->matricula])->get();
        dd($piloto);

      //  $pilotoRemovido->delete();

        return redirect()->back();

    }




}
