<?php

namespace App\Http\Controllers;

use App\Movement;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use Debugbar;
use Illuminate\Support\Facades\Auth;


class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $movimentos = MovementController::filter($request);
            //$movimentos = Movement::orderBy('created_at','asc')->paginate(10);


        } else {

            return Response(view('errors.403'), 403);
        }


        return view('movements.list', compact('movimentos'))->with('movimentos', $movimentos);
    }


    public function create()
    {
        $movimento = new Movement();
        return view('movements.add', compact('movimento'));
        $this->authorize('create', Movement::class);


        $validatedData = $request->validate([]);
        $movimento = Movement::create($validatedData);

        return redirect()->action('MovementController@index');
    }

    public function store(Requests\StoreMovement $request)
    {
        $data = $request->validated();

        $movimento = Movement::create($data);

        return redirect()->action('MovementController@index');
    }

    public static function filter(Request $request)
    {
        if ($movimentos = Movement::where('id', '<>', -1)) {

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

            dd($movimentos);

            $movimentos = $movimentos->orderBy('id', 'asc')
                ->orderBy('id')
                ->paginate(20);
        }
        return $movimentos;
    }

    public function show(Movement $movement)
    {
        //
    }

    public function edit($id)
    {
        $movimento = Movement::findOrFail($id);
        return view('movements.edit', compact('movimento'));
    }


    public function update(Request $request, $id)
    {

        if ($request->has('cancel')) {
            return redirect()->action('MovementController@index');
        }


        // $this->validate($request,[]);

        //  $id = $request->input('id');
        $movement = Movement::findOrFail($id);
        // $movement = Movement::find($id);
        $movement->fill($request->all());
        $movement->save();


        return redirect()->route('movimentos.index');


    }


    public function destroy($id)
    {
        $movimento = Movement::findOrFail($id);
        $movimento->delete();
        return redirect()->back()->with('success', 'moviment deleted successfully!');
    }
}
