<?php
/**
 * Created by PhpStorm.
 * User: Rutherford
 * Date: 28/05/2019
 * Time: 15:12
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreAeronave extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'matricula' => 'required|unique:aeronaves,matricula',
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
            'matricula.required' => 'Matrícula não pode estar vazia',
            'matricula.regex' => 'Matricula não está no formato correto',
            'matricula.unique' => 'Esta matricula já se encontra registado',
            'marca.required' => 'Marca não pode estar vazia',
            'marca.regex' => 'Marca deve apenas ter letras e espaços',
            'modelo.required' => 'Modelo não pode estar vazio',
            'modelo.regex' => 'Modelo deve apenas ter letras e números',
        ];

    }


}