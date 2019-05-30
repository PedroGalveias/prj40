<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovimento;

use App\Movimento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * @return Response
     */
    public function create()
    {
        if (Auth::user()->tipo_socio == 'P' || Auth::user()->direcao == 1) {
            $title = 'Inserir novo movimento';
            $movimento = new Movimento();
            return view('movimentos.add', compact('movimento'));
        }
        else{
            return Response(view('errors.403'), 403);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(StoreMovimento $request)
    {

        $movimento = $request->validated();
        $movimento['confirmado'] = 0;
        Movimento::create($movimento);

        return redirect()->action('UserController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param Movimento $movimento
     * @return Response
     */
    public function show(Movimento $movimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Movimento $movimento
     * @return Response
     */
    public function edit(Movimento $movimento)
    {
        if ((Auth::user()->id == $movimento->piloto_id && $movimento->confirmacao==0) || (Auth::user()->id == $movimento->instrutor_id && $movimento->confirmacao==0)|| (Auth::user()->direcao == 1 && $movimento->confirmacao==0)) {
            $title = "Editar movimento";

            return view('movimentos.edit', compact('title', 'movimento'));
        }else{
            return Response(view('errors.403'), 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Movimento $movimento
     * @return Response
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
     * @param Movimento $movimento
     * @return Response
     * @throws Exception
     */
    public function destroy(Movimento $movimento)
    {
        if (Movimento::where('movimento', $movimento->confirmado) == false) {
            $movimento->forceDelete();
        } else {
            $movimento->delete();
        }

        return redirect()->back()->with('success', 'Movement deleted successfully!');
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
