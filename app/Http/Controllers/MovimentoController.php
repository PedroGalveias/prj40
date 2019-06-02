<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimento;
use App\Http\Requests\UpdateMovimento;
use App\Movimento;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $movimentos = MovimentoController::filter($request);

        } else {
            return Response(view('errors.403'), 403);
        }

        return view('movimentos.list', compact('movimentos'))->with('movimentos', $movimentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('piloto', Auth::user()) || Gate::allows('direcao', Auth::user())) {
            $aerodromos = DB::table('aerodromos')->get();
            $movimento = new Movimento();
            return view('movimentos.add', compact('movimento','aerodromos'));
        } else {
            return Response(view('errors.403'), 403);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovimento $request)
    {
        $movimento = $request->validated();

        if (Gate::allows('direcao', Auth::user())) {
            Movimento::create($movimento);
        } else {
            if (DB::table('aeronaves_pilotos')->where('piloto_id', $movimento->piloto_id)->where('matricula', $movimento->aeronave)) {
                Movimento::create($movimento);
                $movimento['confirmado'] = 0;
            } else {
                return Response(view('errors.403'), 403);
            }
        }

        return redirect()->action('UserController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Movimento $movimento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimento $movimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Movimento $movimento
     * @return \Illuminate\Http\Response
     */
    public function edit(Movimento $movimento)
    {
        if ((DB::table('movimentos')->where('id', $movimento->id)->where('piloto_id', Auth::id()) && $movimento->confirmado == 0) ||
            (DB::table('movimentos')->where('id', $movimento->id)->where('instrutor_id', Auth::id()) && $movimento->confirmado == 0) ||
            (Gate::allows('direcao', Auth::user()) && $movimento->confirmado == 0)
        ) {
            $aerodromos = DB::table('aerodromos')->get();
            return view('movimentos.edit', compact('title', 'movimento','aerodromos'));
        } else {
            return Response(view('errors.403'), 403);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Movimento $movimento
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMovimento $request, Movimento $movimento)
    {

        $movimentoEdit = $request->validated();

        $keys = array_keys($movimentoEdit, null, true);

        foreach ($keys as $key) {
            unset($movimentoEdit[$key]);
        }
        $movimento->fill($movimentoEdit);
        $movimento->save();
        return redirect()->action('MovimentoController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Movimento $movimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimento $movimento)
    {
        if (Movimento::where('movimento', $movimento->confirmado) == 0) {
            $movimento->forceDelete();
        }
        return redirect()->back();
    }

    public static function filter(Request $request)
    {
        if ($movimentos = Movimento::where('id', '<>', -1)) {
            if ($request->filled('aeronave')) {
                $movimentos = $movimentos->where('aeronave', $request->aeronave);
            }
            if ($request->filled('piloto_id')) {
                $movimentos = $movimentos->where('piloto_id', $request->piloto_id);
            }
            if ($request->filled('id')) {
                $movimentos = $movimentos->where('id', $request->id);
            }
            if ($request->filled('instrutor_id')) {
                $movimentos = $movimentos->where('instrutor_id', $request->instrutor_id);
            }
            if ($request->filled('natureza')) {
                $movimentos = $movimentos->where('natureza', $request->natureza);
            }
            if ($request->filled('data') || $request->filled('data')) {
                $movimentos = $movimentos->whereBetween('natureza', ['from', 'to']);;
            }
            if ($request->filled('confirmado')) {
                $movimentos = $movimentos->where('confirmado', $request->confirmado);
            }
            $movimentos = $movimentos->orderBy('id', 'asc')
                ->orderBy('id')
                ->paginate(25);
        }
        return $movimentos;
    }

    public function estatisticas(Movimento $movimento)
    {
        return view('movimentos.estatisticas', compact('movimento'));
    }
}
