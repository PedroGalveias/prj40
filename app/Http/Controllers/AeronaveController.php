<?php

namespace App\Http\Controllers;

use App\Aeronave;
use App\Movimento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UpdateAeronave;
use App\Http\Requests\StoreAeronave;
use Illuminate\Support\Facades\Gate;

class AeronaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * @return Response
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
     * @param Request $request
     * @return Response
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
     * @param Aeronave $aeronave
     * @return Response
     */
    public function show(Aeronave $aeronave)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Aeronave $aeronave
     * @return Response
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
     * @param UpdateAeronave $request
     * @param Aeronave $aeronave
     * @return Response
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
     * @param Aeronave $aeronave
     * @return Response
     * @throws Exception
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

    public function priceTime(Aeronave $aeronave)
    {
        // TODO -- Preco/Hora Para Cada Aeronave --
        $records = DB::table('aeronaves_valores')->get();

        return view('aeronaves.priceTime', compact('aeronave'))->with('records', $records);
    }
}
