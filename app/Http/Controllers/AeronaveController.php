<?php

namespace App\Http\Controllers;

use App\Aeronave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Rules\double;

class AeronaveController extends Controller
{

    public function index()
    {

        if (Auth::check()) {
            $aeronaves = Aeronave::orderBy('matricula', 'asc')->paginate(10);
        } else {

            return Response(view('errors.403'), 403);
        }

        return view('aeronaves.list', compact('aeronaves'))->with('aeronaves', $aeronaves);
    }


    public function create()
    {
        $aeronave = new Aeronave();
        return view('aeronaves.add', compact('aeronave'));
        $this->authorize('create', Aeronave::class);
    }


    public function store(Request $request)
    {
        if ($request->has('cancel')) {
            return redirect()->action('AeronvaveController@index');
        }

        $validatedData = $request->validate([
            'matricula' => 'required|unique:aeronaves,matricula|regex:/[A-Za-z]{3}-[0-9]{3}/',
            'marca' => 'required|regex:/(^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÒÖÚÇÑ ]+$)+/',
            'modelo' => 'required|regex:/(^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÒÖÚÇÑ ]+$)+/',
            'numLugares' => 'required|integer|between:1,4',
            'conta_horas' => 'required|integer',
            'preco_hora' => 'required|integer',
        ], [
            'numLugares.required' => 'Número de lugares não pode estar vazio',
            'numLugares.regex' => 'Número de lugares deve ser entre 1-4!',
            'matricula.required' => 'Matrícula não pode estar vazia',
            'matricula.regex' => 'Número de lugares deve ser entre 1-4!',
            'matricula.unique' => 'Esta matricula já se encontra registado',
            'marca.required' => 'Marca não pode estar vazia',
            'marca.regex' => 'Marca deve apenas ter letras e espaços',
            'modelo.required' => 'Modelo não pode estar vazio',
            'modelo.regex' => 'Modelo deve apenas ter letras e espaços',
        ]);


        if ($validatedData->fails()) {
            return Redirect::back()->withErrors($validatedData);
        }

        $aeronave = new Aeronave();
        $aeronave->fill($request->all());
        $aeronave->save();

        return redirect()->action('AeronaveController@index');
    }


    public function show($id)
    {
        //
    }


    public function edit($matricula)
    {
        $aeronave = Aeronave::findOrFail($matricula);
        return view('aeronaves.edit', compact('aeronave'));

    }


    public function update(Request $request, Aeronave $aeronave)
    {
        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }

        $this->validate($request, [
            'conta_horas' => 'required|integer',
            'preco_hora' => 'required|integer',
        ]);

        if ($this->fails()) {
            return Redirect::back()->withErrors($this);
        }

        $aeronave->fill($request->all());
        $aeronave->save();
        
        return redirect()->action('AeronaveController@index');
    }


    public function destroy($matricula)
    {

        $aeronave = Aeronave::findOrFail($matricula);
        $aeronave->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
