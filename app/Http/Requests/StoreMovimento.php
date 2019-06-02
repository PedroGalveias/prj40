<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMovimento extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            'aeronave' => 'required|exists:aeronaves,matricula',
            'piloto_id' => 'required',
            'data' => 'required|date_format:Y-m-d',
            'hora_descolagem' => 'required',
            'hora_aterragem' => 'required',
            'tempo_voo' => 'required|numeric|min:1',
            'aerodromo_partida' => 'required|exists:aerodromos,code',
            'aerodromo_chegada' => 'required|exists:aerodromos,code',
            'num_aterragens' => 'required|integer|min:1',
            'num_descolagens' => 'required|integer|min:1',
            'num_diario' => 'required|integer|min:1',
            'num_servico' => 'required|integer|min:1',
            'conta_horas_inicio' => 'required|integer|min:1',
            'conta_horas_fim' => 'required|integer|gt:conta_horas_inicio|min:1',
            'num_pessoas' => 'required|integer|min:1',
            'modo_pagamento' => ['required', Rule::in(['N', 'T', 'P','M'])],
            'preco_voo' => 'required|integer|min:1',
            'num_recibo' => 'required|max:20',
            'observacoes' => 'nullable',
            'natureza' => ['required', Rule::in(['T', 'I', 'E'])],
            'num_licenca_piloto' => 'required|numeric|max:999999999',
            'validade_licenca_piloto' => 'required|date',
            'num_certificado_piloto' => 'required',
            'validade_certificado_piloto' => 'required|date',
            'tipo_licenca_piloto' => 'required',
            'classe_certificado_piloto' => 'required',
            'confirmado' => 'required',
            //INSTRUTOR
            'num_certificado_instrutor' => 'nullable',
            'validade_licenca_instrutor' => 'nullable|date',
            'tipo_instrucao' => ['nullable', Rule::in(['D', 'S'])],
            'instrutor_id' => 'nullable|numeric',
            'validade_certificado_instrutor' => 'nullable|date',
        ];

        return $rules;
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