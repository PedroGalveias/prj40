@extends('layouts.app')

@section('content')

    @if($errors->any())
        @include('partials.errors')
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <form method="POST" action="{{action('MovementController@store')}}">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="aeronave" class="col-sm-4 col-form-label"> Matricula aeronave </label>
                            <div class="col-sm-10">
                                <input type="text" name="aeronave" class="form-control" id="aeronave" placeholder="aeronave" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_licenca_piloto" class="col-sm-4 col-form-label"> Nº licença Piloto</label>
                            <div class="col-sm-10">
                                <input type="text" name="num_licenca_piloto" class="form-control" id="num_licenca_piloto" placeholder="num_licenca_piloto" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data" class="col-sm-4 col-form-label"> Data </label>
                            <div class="col-sm-10">
                                <input type="text" name="data" class="form-control" id="data" placeholder="data" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora_descolagem" class="col-sm-4 col-form-label"> Hora Descolagem </label>
                            <div class="col-sm-10">
                                <input type="text" name="hora_descolagem" class="form-control" id="hora_descolagem" placeholder="hora_descolagem" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora_aterragem" class="col-sm-4 col-form-label"> Hora Aterragem </label>
                            <div class="col-sm-10">
                                <input type="text" name="hora_aterragem" class="form-control" id="hora_aterragem" placeholder="hora_aterragem" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tempo_voo" class="col-sm-4 col-form-label"> Tempo Voo </label>
                            <div class="col-sm-10">
                                <input type="text" name="tempo_voo" class="form-control" id="tempo_voo" placeholder="tempo_voo" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="natureza" class="col-sm-4 col-form-label"> Natureza </label>
                            <div class="col-sm-10">
                                <input type="text" name="natureza" class="form-control" id="natureza" placeholder="natureza"  />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="piloto_id" class="col-sm-4 col-form-label"> Id Piloto </label>
                            <div class="col-sm-10">
                                <input type="text" name="piloto_id" class="form-control" id="piloto_id" placeholder="piloto_id" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="aerodromo_partida" class="col-sm-4 col-form-label"> Aerodromo Partida </label>
                            <div class="col-sm-10">
                                <input type="text" name="aerodromo_partida" class="form-control" id="aerodromo_partida" placeholder="aerodromo_partida" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="aerodromo_chegada" class="col-sm-4 col-form-label"> Aerodromo Chegada </label>
                            <div class="col-sm-10">
                                <input type="text" name="aerodromo_chegada" class="form-control" id="aerodromo_chegada" placeholder="aerodromo_chegada"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_aterragens" class="col-sm-4 col-form-label"> Nº Aterragens </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_aterragens" class="form-control" id="num_aterragens" placeholder="num_aterragens"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_descolagens" class="col-sm-4 col-form-label"> Nº Descolagens </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_descolagens" class="form-control" id="num_descolagens" placeholder="num_descolagens" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_diario" class="col-sm-4 col-form-label"> Nº Diário </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_diario" class="form-control" id="num_diario" placeholder="num_diario" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_servico" class="col-sm-4 col-form-label"> Nº Serviço </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_servico" class="form-control" id="num_servico" placeholder="num_servico"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_inicio" class="col-sm-4 col-form-label"> Conta-Horas Início </label>
                            <div class="col-sm-10">
                                <input type="text" name="conta_horas_inicio" class="form-control" id="conta_horas_inicio" placeholder="conta_horas_inicio"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_fim" class="col-sm-4 col-form-label"> Conta-Horas Fim </label>
                            <div class="col-sm-10">
                                <input type="text" name="conta_horas_fim" class="form-control" id="conta_horas_fim" placeholder="conta_horas_fim"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_pessoas" class="col-sm-4 col-form-label"> Nº Pessoas </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_pessoas" class="form-control" id="num_pessoas" placeholder="num_pessoas"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_instrucao" class="col-sm-4 col-form-label"> Tipo Instrução </label>
                            <div class="col-sm-10">
                                <input type="text" name="tipo_instrucao" class="form-control" id="tipo_instrucao" placeholder="tipo_instrucao"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="instrutor_id" class="col-sm-4 col-form-label"> Id Instrutor </label>
                            <div class="col-sm-10">
                                <input type="text" name="instrutor_id" class="form-control" id="instrutor_id" placeholder="instrutor_id"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modo_pagamento" class="col-sm-4 col-form-label"> Modo de Pagamento </label>
                            <div class="col-sm-10">
                                <input type="text" name="modo_pagamento" class="form-control" id="modo_pagamento" placeholder="modo_pagamento"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_recibo" class="col-sm-4 col-form-label"> Nº do Recibo </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_recibo" class="form-control" id="num_recibo" placeholder="num_recibo"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observacoes" class="col-sm-4 col-form-label"> Observações </label>
                            <div class="col-sm-10">
                                <input type="text" name="observacoes" class="form-control" id="observacoes" placeholder="observacoes" />

                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="ok" href="{{action('MovementController@store')}}" value="guardar">
                            <a class="btn btn-primary" href="{{action('MovementController@index')}}">voltar</a>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
