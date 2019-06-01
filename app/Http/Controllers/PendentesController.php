<?php

namespace App\Http\Controllers;


use App\Movimento;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class PendentesController extends Controller
{
    public function index()
    {
        if (Gate::allows('direcao', Auth::user())) {

            $movimentos = Movimento::where('confirmado', '0')->paginate(25);
            
            $socios = DB::table('users')
                ->where('certificado_confirmado', 'LIKE', Null)
                ->orWhere('licenca_confirmada', 'LIKE', Null)
                ->paginate(25);


            return view('pendentes.list', compact('movimentos', 'socios'));

        }
    }
}
