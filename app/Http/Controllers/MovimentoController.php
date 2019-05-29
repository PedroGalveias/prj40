<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimento;

use App\Movimento;
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
        $title = 'Inserir novo movimento';
        $movimento = new Movimento();
        return view('movimentos.add', compact('movimento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $title = "Editar movimento";

        return view('movimentos.edit', compact('title', 'movimento'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Movimento $movimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimento $movimento)
    {
        //
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
}
