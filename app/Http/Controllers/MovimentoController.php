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
    public function index()
    {
        if (Auth::check()) {
            $movimentos = Movimento::orderBy('created_at', 'asc')->paginate(25);


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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movimento $movimento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimento $movimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movimento $movimento
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
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Movimento $movimento
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
     * @param  \App\Movimento $movimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimento $movimento)
    {
        //
    }
}
