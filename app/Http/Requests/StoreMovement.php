<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreMovement extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aeronave'=>'required',
            'num_licenca_piloto'=>'required|numeric|max:999999999',
            'data'=>'required|date',
            'hora_aterragem'=>'required',
            'hora_descolagem'=>'required',
            'tempo_voo'=>'required|numeric|max:999999999',
            'natureza'=>'required',
            'aerodromo_partida'=>'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'aerodromo_chegada'=>'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'num_aterragens'=>'required|numeric|max:999999999',
            'num_descolagens'=>'required|numeric|max:999999999',
            'num_diario'=>'required',
            'num_servico'=>'required',
            'conta_horas_inicio'=>'required',
            'conta_horas_fim'=>'required',
            'num_pessoas'=>'required',
            'tipo_instrucao'=>'required',
            'instrutor_id'=>'required|numeric|max:999999999',
            'modo_pagamento'=>'required',
            'num_recibo'=>'required',
            'observacoes'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'aeronave.required'=>'A matrícula deve ser preeenchida',
            'num_licenca_piloto.required'=>'O número da licença do Piloto deve ser preenchido',
            'num_licenca_piloto.integer'=>'O número da licença do Piloto tem que ser um número inteiro',
            'data.required'=>'A data deve ser preenchida',
            'data.date'=>'O formato da data está inválido',
            'hora_aterragem.required'=>'A hora deve de aterragem deve ser preenchida',
            'hora_descolagem.required'=>'A hora deve de descolagem deve ser preenchida',
            'tempo_voo.required'=>'O tempo de voo deve ser preenchida',
            'natureza.required'=>'A Natureza do voo deve ser preenchida',
            'aerodromo_chegada.required'=> 'O Aerodromo de chegada deve ser preenchido',
            'aerodromo_chegada.regex'=>'O Aerodromo de partida não deve conter números',
            'aerodromo_partida.required'=> 'O Aerodromo de partida deve ser preenchido',
            'aerodromo_partida.regex'=>'O Aerodromo de chegada não deve conter números',
            'num_aterragens.required'=>'O número de aterragens deve ser preenchido',
            'num_descolagens.required'=>'O número de descolagens deve ser preenchido',
            'num_diario.required'=>'O número do diário deve ser preenchido',
            'num_servico.required'=>'O número do serviço deve ser preenchido',
            'conta_horas_inicio.required'=>'O conta horas início deve ser preenchida',
            'conta_horas_fim.required'=>'O conta horas fim deve ser preenchida',
            //'conta_horas_inicio.date'=>'O formato do conta horas início está inválido',
            //'conta_horas_fim.date'=>'O formato do conta horas fim está inválido',
            'num_pessoas.required'=>'O número de pessoas deve ser preenchido',
            'tipo_instrucao.required'=>'O tipo de instrução deve ser preenchido',
            'instrutor_id.required'=>'O id do Instrutor deve ser preenchido',
            'modo_pagamento.required'=>'O modo de pagamento deve ser preenchido',
            'num_recibo.required'=>'O número do recibo deve ser preenchido',
            'observacoes.required'=>'O campo deve ser preenchido',

        ];
    }
}