@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST" action="{{ route('aeronaves.update', ['matricula'=>$aeronave->matricula]) }}" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Conta horas </label>
                            <div class="col-sm-10">
                                <input type="text" name="conta_horas" class="form-control" id="conta_horas" placeholder="Conta_horas" value="{{old('conta_horas', $aeronave->conta_horas)}}" />
                                @if ($errors->has('conta_horas'))
                                    <div class="error">{{ $errors->first('conta_horas') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="marca" class="col-sm-4 col-form-label"> Preço hora </label>
                            <div class="col-sm-10">
                                <input type="text" name="preco_hora" class="form-control" id="preco_hora" placeholder="Preco_hora" value="{{old('preco_hora', $aeronave->preco_hora)}}" />
                                @if ($errors->has('preco_hora'))
                                    <div class="error">{{ $errors->first('preco_hora') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-6">
                                <input type="submit" class="btn btn-success" name="ok" href="{{action('AeronaveController@update',['matricula'=>$aeronave->matricula])}}" value="guardar">
                                <a class="btn btn-primary" href="{{action('AeronaveController@index')}}">voltar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection