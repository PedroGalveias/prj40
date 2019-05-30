<?php
/**
 * Created by PhpStorm.
 * User: Rutherford
 * Date: 28/05/2019
 * Time: 15:51
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreMovimento extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'aeronave' => 'required',
            'piloto_id' => 'required',
            'validade_licenca_piloto' => 'required',
            'tipo_licenca_piloto' => 'required',
            'num_certificado_piloto' => 'required',
            'validade_certificado_piloto' => 'required',
            'classe_certificado_piloto' => 'required',
            'preco_voo' => 'required',
            'num_licenca_piloto' => 'required|numeric|max:999999999',
            'data' => 'required|date',
            'hora_aterragem' => 'required',
            'hora_descolagem' => 'required',
            'tempo_voo' => 'required|numeric|max:999999999',
            'natureza' => 'required',
            'aerodromo_partida' => 'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'aerodromo_chegada' => 'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'num_aterragens' => 'required|numeric|max:999999999',
            'num_descolagens' => 'required|numeric|max:999999999',
            'num_diario' => 'required',
            'num_servico' => 'required',
            'conta_horas_inicio' => 'required',
            'conta_horas_fim' => 'required',
            'num_pessoas' => 'required',
            'tipo_instrucao' => 'nullable',
            'instrutor_id' => 'nullable|numeric|max:999999999',
            'modo_pagamento' => 'nullable',
            'num_recibo' => 'required',
            'observacoes' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'aeronave.required' => 'A matrícula deve ser preeenchida',
            'num_licenca_piloto.required' => 'O número da licença do Piloto deve ser preenchido',
            'num_licenca_piloto.integer' => 'O número da licença do Piloto tem que ser um número inteiro',
            'data.required' => 'A data deve ser preenchida',
            'data.date' => 'O formato da data está inválido',
            'hora_aterragem.required' => 'A hora deve de aterragem deve ser preenchida',
            'hora_descolagem.required' => 'A hora deve de descolagem deve ser preenchida',
            'tempo_voo.required' => 'O tempo de voo deve ser preenchida',
            'natureza.required' => 'A Natureza do voo deve ser preenchida',
            'aerodromo_chegada.required' => 'O Aerodromo de chegada deve ser preenchido',
            'aerodromo_chegada.regex' => 'O Aerodromo de partida não deve conter números',
            'aerodromo_partida.required' => 'O Aerodromo de partida deve ser preenchido',
            'aerodromo_partida.regex' => 'O Aerodromo de chegada não deve conter números',
            'num_aterragens.required' => 'O número de aterragens deve ser preenchido',
            'num_descolagens.required' => 'O número de descolagens deve ser preenchido',
            'num_diario.required' => 'O número do diário deve ser preenchido',
            'num_servico.required' => 'O número do serviço deve ser preenchido',
            'conta_horas_inicio.required' => 'O conta horas início deve ser preenchida',
            'conta_horas_fim.required' => 'O conta horas fim deve ser preenchida',



        ];
    }

}