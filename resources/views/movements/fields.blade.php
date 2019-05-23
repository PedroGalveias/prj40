@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="aeronave" class="col-sm-4 col-form-label"> Matricula aeronave </label>
                            <div class="col-sm-10">
                                <input type="text" name="aeronave" class="form-control" id="aeronave" placeholder="aeronave" value="{{old('aeronave',$movimento->aeronave)}}" />

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="aeronave" class="col-sm-4 col-form-label"> Num_licenca piloto</label>
                            <div class="col-sm-10">
                                <input type="text" name="aeronave" class="form-control" id="aeronave" placeholder="aeronave" value="{{old('aeronave',$movimento->num_licenca_piloto)}}" />

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="data" class="col-sm-4 col-form-label"> Data </label>
                            <div class="col-sm-10">
                                <input type="text" name="data" class="form-control" id="data" placeholder="data" value="{{old('data',$movimento->data)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora_descolagem" class="col-sm-4 col-form-label"> Hora Descolagem </label>
                            <div class="col-sm-10">
                                <input type="text" name="hora_descolagem" class="form-control" id="hora_descolagem" placeholder="hora_descolagem" value="{{old('hora_descolagem',$movimento->hora_descolagem)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora_aterragem" class="col-sm-4 col-form-label"> Hora Aterragem </label>
                            <div class="col-sm-10">
                                <input type="text" name="hora_aterragem" class="form-control" id="hora_aterragem" placeholder="hora_aterragem" value="{{old('hora_aterragem',$movimento->hora_aterragem)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tempo_voo" class="col-sm-4 col-form-label"> Tempo Voo </label>
                            <div class="col-sm-10">
                                <input type="text" name="tempo_voo" class="form-control" id="tempo_voo" placeholder="tempo_voo" value="{{old('tempo_voo',$movimento->tempo_voo)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="natureza" class="col-sm-4 col-form-label"> Natureza </label>
                            <div class="col-sm-10">
                                <input type="text" name="natureza" class="form-control" id="natureza" placeholder="natureza" value="{{old('natureza',$movimento->natureza)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="piloto_id" class="col-sm-4 col-form-label"> Id Piloto </label>
                            <div class="col-sm-10">
                                <input type="text" name="piloto_id" class="form-control" id="piloto_id" placeholder="piloto_id" value="{{old('piloto_id',$movimento->piloto_id)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="aerodromo_partida" class="col-sm-4 col-form-label"> Aerodromo Partida </label>
                            <div class="col-sm-10">
                                <input type="text" name="aerodromo_partida" class="form-control" id="aerodromo_partida" placeholder="aerodromo_partida" value="{{old('aerodromo_partida',$movimento->aerodromo_partida)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="aerodromo_chegada" class="col-sm-4 col-form-label"> Aerodromo Chegada </label>
                            <div class="col-sm-10">
                                <input type="text" name="aerodromo_chegada" class="form-control" id="aerodromo_chegada" placeholder="aerodromo_chegada" value="{{old('aerodromo_chegada',$movimento->aerodromo_chegada)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_aterragens" class="col-sm-4 col-form-label"> Nº Aterragens </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_aterragens" class="form-control" id="num_aterragens" placeholder="num_aterragens" value="{{old('num_aterragens',$movimento->num_aterragens)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_descolagens" class="col-sm-4 col-form-label"> Nº Descolagens </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_descolagens" class="form-control" id="num_descolagens" placeholder="num_descolagens" value="{{old('num_descolagens',$movimento->num_descolagens)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_diario" class="col-sm-4 col-form-label"> Nº Diário </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_diario" class="form-control" id="num_diario" placeholder="num_diario" value="{{old('num_diario',$movimento->num_diario)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_servico" class="col-sm-4 col-form-label"> Nº Serviço </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_servico" class="form-control" id="num_servico" placeholder="num_servico" value="{{old('num_servico',$movimento->num_servico)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_inicio" class="col-sm-4 col-form-label"> Conta-Horas Início </label>
                            <div class="col-sm-10">
                                <input type="text" name="conta_horas_inicio" class="form-control" id="conta_horas_inicio" placeholder="conta_horas_inicio" value="{{old('conta_horas_inicio',$movimento->conta_horas_inicio)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_fim" class="col-sm-4 col-form-label"> Conta-Horas Fim </label>
                            <div class="col-sm-10">
                                <input type="text" name="conta_horas_fim" class="form-control" id="conta_horas_fim" placeholder="conta_horas_fim" value="{{old('conta_horas_fim',$movimento->conta_horas_fim)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_pessoas" class="col-sm-4 col-form-label"> Nº Pessoas </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_pessoas" class="form-control" id="num_pessoas" placeholder="num_pessoas" value="{{old('num_pessoas',$movimento->num_pessoas)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_instrucao" class="col-sm-4 col-form-label"> Tipo Instrução </label>
                            <div class="col-sm-10">
                                <input type="text" name="tipo_instrucao" class="form-control" id="tipo_instrucao" placeholder="tipo_instrucao" value="{{old('tipo_instrucao',$movimento->tipo_instrucao)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="instrutor_id" class="col-sm-4 col-form-label"> Id Instrutor </label>
                            <div class="col-sm-10">
                                <input type="text" name="instrutor_id" class="form-control" id="instrutor_id" placeholder="instrutor_id" value="{{old('instrutor_id',$movimento->instrutor_id)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_conflito" class="col-sm-4 col-form-label"> Tipo Conflito </label>
                            <div class="col-sm-10">
                                <input type="text" name="tipo_conflito" class="form-control" id="tipo_conflito" placeholder="tipo_conflito" value="{{old('tipo_conflito',$movimento->tipo_conflito)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="justificacao_conflito" class="col-sm-4 col-form-label"> Justificação Conflito </label>
                            <div class="col-sm-10">
                                <input type="text" name="justificacao_conflito" class="form-control" id="justificacao_conflito" placeholder="justificacao_conflito" value="{{old('justificacao_conflito',$movimento->justificacao_conflito)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmado" class="col-sm-4 col-form-label"> Confirmado </label>
                            <div class="col-sm-10">
                                <input type="text" name="confirmado" class="form-control" id="confirmado" placeholder="confirmado" value="{{old('confirmado',$movimento->confirmado)}}" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observacoes" class="col-sm-4 col-form-label"> Observações </label>
                            <div class="col-sm-10">
                                <input type="text" name="observacoes" class="form-control" id="observacoes" placeholder="observacoes" value="{{old('observacoes',$movimento->observacoes)}}" />

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection
