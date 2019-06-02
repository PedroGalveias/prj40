<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Created by PhpStorm.
 * User: Rutherford
 * Date: 28/05/2019
 * Time: 01:57
 */
class UpdateSocio extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = (int)$this->route()->parameters()['socio']->id;
        return [
            'name'=>'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'email'=>'required|email|unique:users,email,'.$id,
            'nome_informal'=>'required|regex:/^([a-zA-Z]+\s)*[a-zA-Z]+$/',
            'sexo'=>'required',
            'data_nascimento'=>'required|date',
            'nif'=>'required|unique:users,nif,'.$id, //.'|numeric|max:999999999
            'telefone'=>'required|unique:users,telefone,'.$id, //'|regex:/^\+?\d{3}(?: ?\d+)*$/',
            'endereco'=>'required',
            'tipo_socio'=>'required',
            'file_foto'=>'nullable|image',
            'direcao'=>'required',
            'ativo'=>'nullable',
            'certificado_confirmado'=>'nullable',
            'licenca_confirmada'=>'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'O nome deve ser preeenchido',
            'name.regex'=>'O nome não deve conter acentos',
            'email.required'=>'O email deve ser preenchido',
            'email.email'=>'O formato do email não é válido',
            'email.unique'=>'Este email já se encontra registado',
            'nome_informal.required'=>'O nome deve ser preenchido',
            'nome_informal.regex'=>'O nome não deve conter números',
            'sexo.required'=>'O género tem que ser definido',
            'data_nascimento.required'=>'A data de nascimento deve ser preenchida',
            'data_nascimento.date'=>'O formato da data está inválido',
            'nif.required'=>'O NIF deve ser preenchido',
            'nif.unique'=>'Este NIF já se encontra registado',
            'nif.integer'=>'O NIF tem que ser um número inteiro',
            'telefone.required'=>'O número de telefone deve ser preenchido',
            'telefone.unique'=>'Este número de telefone já se encontra registado',
            'telefone.regex'=>'O formato número de telefone não é válido',
            'endereco.required'=>'O endereço deve ser preenchido',
            'tipo_socio.required'=>'O tipo de sócio tem que ser preenchido',
            'file_foto.image'=>'O ficheiro não é uma imagem ou é de um formato não suportado',
        ];
    }
}