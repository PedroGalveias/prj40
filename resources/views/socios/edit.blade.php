@extends('layouts.app')

@section('content')

    @if($errors->any())
        @include('partials.errors')
    @endif

    @dump($errors)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
    <form method="POST" action="{{route('socios',$user)}}" encrypte="multipart/form-data">

    @method('PUT')

    {{csrf_field()}}

    <div class="form-group">
        <label for="name" class="col-sm-4 col-form-label"> Nome Completo </label>
        <div class="col-sm-10">
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="{{old('name', $user->name)}}" />
        </div>
    </div>
        <div class="form-group">
            <label for="num_socio" class="col-sm-4 col-form-label"> Num socio </label>
            <div class="col-sm-10">
                <input type="text" name="num_socio" class="form-control" id="num_socio" placeholder="num_socio" value="{{old('num_socio', $user->num_socio)}}" />
            </div>
        </div>
    <div class="form-group">
        <label for="nome_informal" class="col-sm-4 col-form-label"> Nome Informal </label>
        <div class="col-sm-10">
            <input type="text" name="nome_informal" class="form-control" id="nome_informal" placeholder="nome_informal" value="{{old('nome_informal', $user->nome_informal)}}" />

        </div>
    </div>
    <div class="form-group">
        <label for="endereco" class="col-sm-4 col-form-label"> Endereço </label>
        <div class="col-sm-10">
            <input type="text" name="endereco" class="form-control" id="endereco" placeholder="endereco" value="{{old('endereco', $user->endereco)}}" />
        </div>
    </div>
    <div class="form-group">
        <label for="telefone" class="col-sm-4 col-form-label"> Telefone </label>
        <div class="col-sm-10">
            <input type="text" name="telefone" class="form-control" id="telefone" placeholder="telefone" value="{{old('telefone', $user->telefone)}}" />
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-sm-4 col-form-label"> Email </label>
        <div class="col-sm-10">
            <input type="email" name="email" class="form-control" id="Email" placeholder="Email" value="{{old('email', $user->email)}}" />
        </div>
    </div>

    <div class="form-group">
        <label for="foto" class="col-sm-4 col-form-label">Upload Foto Perfil</label>
        <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
    </div>

    <div class="form-group">
        <label for="nif" class="col-sm-4 col-form-label">NIF</label>
        <div class="col-sm-10">
            <input type="text" name="nif" class="form-control" id="nif" placeholder="nif"  value="{{old('nif', $user->nif)}}" />
        </div>
    </div>


        @if($user->tipo_socio == 'P')
            <div class="form-group">
                <label for="num_licenca" class="col-sm-4 col-form-label"> num_licenca </label>
                <div class="col-sm-10">
                    <input type="text" name="num_licenca" class="form-control" id="num_licenca" placeholder="num_licenca" value="{{old('num_licenca', $user->num_licenca)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="tipo_licenca" class="col-sm-4 col-form-label"> tipo_licenca </label>
                <div class="col-sm-10">
                    <input type="text" name="tipo_licenca" class="form-control" id="tipo_licenca" placeholder="tipo_licenca" value="{{old('tipo_licenca', $user->tipo_licenca)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="instrutor" class="col-sm-4 col-form-label"> instrutor </label>
                <div class="col-sm-10">
                    <input type="text" name="instrutor" class="form-control" id="instrutor" placeholder="instrutor" value="{{old('instrutor', $user->instrutor)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="validade_licenca" class="col-sm-4 col-form-label"> validade licenca </label>
                <div class="col-sm-10">
                    <input type="text" name="validade_licenca" class="form-control" id="validade_licenca" placeholder="validade_licenca" value="{{old('validade_licenca', $user->validade_licenca)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="licenca_confirmada" class="col-sm-4 col-form-label"> licenca confirmada </label>
                <div class="col-sm-10">
                    <input type="text" name="licenca_confirmada" class="form-control" id="licenca_confirmada" placeholder="licenca_confirmada" value="{{old('licenca_confirmada', $user->licenca_confirmada)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="num_certificado" class="col-sm-4 col-form-label"> num certificado </label>
                <div class="col-sm-10">
                    <input type="text" name="num_certificado" class="form-control" id="num_certificado" placeholder="num_certificado" value="{{old('num_certificado', $user->num_certificado)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="classe_certificado" class="col-sm-4 col-form-label"> classe certificado</label>
                <div class="col-sm-10">
                    <input type="text" name="classe_certificado" class="form-control" id="classe_certificado" placeholder="classe_certificado" value="{{old('classe_certificado', $user->classe_certificado)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="validade_certificado" class="col-sm-4 col-form-label"> validade certificado</label>
                <div class="col-sm-10">
                    <input type="text" name="validade_certificado" class="form-control" id="validade_certificado" placeholder="validade_certificado" value="{{old('validade_certificado', $user->validade_certificado)}}" />
                </div>
            </div>
            <div class="form-group">
                <label for="certificado_confirmado" class="col-sm-4 col-form-label"> certificado_confirmado</label>
                <div class="col-sm-10">
                    <input type="text" name="certificado_confirmado" class="form-control" id="certificado_confirmado" placeholder="certificado_confirmado" value="{{old('certificado_confirmado', $user->certificado_confirmado)}}" />
                </div>
            </div>


            <div class="form-group">
                <td><a href="{{route('licenca',['piloto' => $user])}}">licenca.pdf</a>&nbsp
                    <a href="{{route('certificado',['piloto' => $user])}}">certificado.pdf</a></td>
            </div>
            <div class="form-group">



                <label for="upload_file" class="control-label col-sm-3">Upload File </label>
                <div class="col-sm-9">
                    <input class="form-control" type="file" name="upload_file" id="upload_file" value="{{old('name', $user->licenca_confirmada)}}" />
                </div>
            </div>



        @endif

        <div class="form-group">
            <input type="submit" class="btn btn-success" name="ok" href="{{route('socios.update', ['id'=>$user->id])}}" value="guardar">
            <a class="btn btn-primary" href="{{action('UserController@index')}}">voltar</a>

        </div>

     </form>
        </div>
    </div>
</div>
</div>
@endsection
