<?php
/**
 * Created by PhpStorm.
 * User: Rutherford
 * Date: 28/05/2019
 * Time: 14:13
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateAeronave extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $matricula = (string)$this->route()->parameters()['aeronave']->matricula;
        return [

            'marca' => 'required|regex:/(^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÒÖÚÇÑ ]+$)+/',
            'modelo' => 'required',
            'num_lugares' => 'required|integer',
            'conta_horas' => 'required|integer',
            'preco_hora' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'num_lugares.required' => 'Número de lugares não pode estar vazio',
            'matricula.unique' => 'Esta matricula já se encontra registado',
            'marca.required' => 'Marca não pode estar vazia',
            'marca.regex' => 'Marca deve apenas ter letras e espaços',
            'modelo.required' => 'Modelo não pode estar vazio',
            'modelo.regex' => 'Modelo deve apenas ter letras e números',
        ];

    }
}