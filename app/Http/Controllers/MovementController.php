<?php

namespace App\Http\Controllers;

use App\Movement;

use App\Http\Requests;
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
    public function index()
    {
        if( Auth::check() )
        {
            $movimentos = Movement::orderBy('created_at','asc')->paginate(10);


        }
        else{

            return Response(view('errors.403'), 403);
        }


        return view('movements.list',compact('movimentos'))->with('movimentos',$movimentos);
    }


    public function create()
    {
        $movimento = new Movement();
        return view('movements.add', compact('movimento'));
        $this->authorize('create', Movement::class);


        $validatedData=$request->validate([]);
        $movimento = Movement::create($validatedData);

        return redirect()->action('MovementController@index');
    }

    public function store(Requests\StoreMovement $request)
    {
        $data = $request->validated();

        $movimento=Movement::create($data);

        return redirect()->action('MovementController@index');
    }


    public function show(Movement $movement)
    {
        //
    }

    public function edit($id)
    {
        $movimento=Movement::findOrFail($id);
        return view('movements.edit',compact('movimento'));
    }


    public function update(Request $request,$id)
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
        $movimento=Movement::findOrFail($id);
        $movimento->delete();
        return redirect()->back()->with('success', 'moviment deleted successfully!');
    }
}
