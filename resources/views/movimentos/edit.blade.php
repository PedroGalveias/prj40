@extends('layouts.app')
@section('content')

    @if($errors->any())
        @include('partials.errors')
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <form method="POST" action="{{action('MovimentoController@update',$movimento)}}"
                          encrypte="multipart/form-data">
                        @method('PUT')
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="aeronave" class="col-sm-4 col-form-label"> Matricula aeronave </label>
                            <div class="col-sm-10">
                                <input type="text" name="aeronave" class="form-control" id="aeronave"
                                       value="{{old('aeronave',$movimento->aeronave)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="piloto_id" class="col-sm-4 col-form-label"> Id Piloto </label>
                            <div class="col-sm-10">
                                <input type="text" name="piloto_id" class="form-control" id="piloto_id"
                                       value="{{old('piloto_id', $movimento->piloto_id)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data" class="col-sm-4 col-form-label"> Data </label>
                            <div class="col-sm-10">
                                <input type="date" name="data" class="form-control" id="data"
                                       value="{{old('data', $movimento->data)}}"/>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="hora_descolagem" class="col-sm-4 col-form-label"> Hora Descolagem </label>
                            <div class="col-sm-10">
                                <input type="datetime" name="hora_descolagem" class="form-control"
                                       id="hora_descolagem"
                                       value="{{old('hora_descolagem', $movimento->hora_descolagem)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora_aterragem" class="col-sm-4 col-form-label"> Hora Aterragem </label>
                            <div class="col-sm-10">
                                <input type="datetime" name="hora_aterragem" class="form-control"
                                       id="hora_aterragem"
                                       value="{{old('hora_aterragem', $movimento->hora_aterragem)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tempo_voo" class="col-sm-4 col-form-label"> Tempo Voo </label>
                            <div class="col-sm-10">
                                <input type="number" name="tempo_voo" class="form-control" id="tempo_voo"
                                       value="{{old('tempo_voo', $movimento->tempo_voo)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="aerodromo_partida" class="col-sm-4 col-form-label"> Aerodromo Partida </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="aerodromo_partida" class="form-control">
                                        @foreach($aerodromos as $aerodromo)
                                            <option value="{{$aerodromo->code}}">{{$aerodromo->nome}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="aerodromo_chegada" class="col-sm-4 col-form-label"> Aerodromo Chegada </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="aerodromo_chegada" class="form-control">
                                        @foreach($aerodromos as $aerodromo)
                                            <option value="{{$aerodromo->code}}">{{$aerodromo->nome}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                </p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="num_aterragens" class="col-sm-4 col-form-label"> Nº Aterragens </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_aterragens" class="form-control" id="num_aterragens"
                                       value="{{old('num_aterragens', $movimento->num_aterragens)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_descolagens" class="col-sm-4 col-form-label"> Nº Descolagens </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_descolagens" class="form-control" id="num_descolagens"
                                       value="{{old('num_descolagens', $movimento->num_descolagens)}}"/>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="num_diario" class="col-sm-4 col-form-label"> Nº Diário </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_diario" class="form-control" id="num_diario"
                                       value="{{old('num_diario', $movimento->num_diario)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_servico" class="col-sm-4 col-form-label"> Nº Serviço </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_servico" class="form-control" id="num_servico"
                                       value="{{old('num_servico', $movimento->num_servico)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_inicio" class="col-sm-4 col-form-label"> Conta-Horas Início </label>
                            <div class="col-sm-10">
                                <input type="number" name="conta_horas_inicio" class="form-control"
                                       id="conta_horas_inicio"
                                       value="{{old('conta_horas_inicio', $movimento->conta_horas_inicio)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_fim" class="col-sm-4 col-form-label"> Conta-Horas Fim </label>
                            <div class="col-sm-10">
                                <input type="number" name="conta_horas_fim" class="form-control" id="conta_horas_fim"
                                       value="{{old('conta_horas_fim', $movimento->conta_horas_fim)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_pessoas" class="col-sm-4 col-form-label"> Nº Pessoas </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_pessoas" class="form-control" id="num_pessoas"
                                       value="{{old('num_pessoas', $movimento->num_pessoas)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="modo_pagamento" class="col-sm-4 col-form-label"> Modo de Pagamento </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="modo_pagamento">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="N" {{old('modo_pagamento', $movimento->modo_pagamento) == 'N' ? 'selected' : ''}}>
                                            N
                                        </option>
                                        <option value="M" {{old('modo_pagamento', $movimento->modo_pagamento) == 'M' ? 'selected' : ''}}>
                                            M
                                        </option>
                                        <option value="T" {{old('modo_pagamento', $movimento->modo_pagamento) == 'T' ? 'selected' : ''}}>
                                            T
                                        </option>
                                        <option value="P" {{old('modo_pagamento', $movimento->modo_pagamento) == 'P' ? 'selected' : ''}}>
                                            P
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="preco_voo" class="col-sm-4 col-form-label"> Preço do Voo </label>
                            <div class="col-sm-10">
                                <input type="number" name="preco_voo" class="form-control" id="preco_voo"
                                       value="{{old('preco_voo', $movimento->preco_voo)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_recibo" class="col-sm-4 col-form-label"> Nº do Recibo </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_recibo" class="form-control" id="num_recibo"
                                       value="{{old('num_recibo', $movimento->num_recibo)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observacoes" class="col-sm-4 col-form-label"> Observações </label>
                            <div class="col-sm-10">
                                <input type="text" name="observacoes" class="form-control" id="observacoes"
                                       value="{{old('observacoes', $movimento->observacoes)}}"/>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="natureza" class="col-sm-4 col-form-label"> Natureza </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="natureza">
                                        <option disabled selected="">Selecione...</option>

                                        <option value="T" {{old('natureza', $movimento->natureza) == 'T' ? 'selected' : ''}}>
                                            T
                                        </option>
                                        <option value="I" {{old('natureza', $movimento->natureza) == 'I' ? 'selected' : ''}}>
                                            I
                                        </option>
                                        <option value="E" {{old('natureza', $movimento->natureza) == 'E' ? 'selected' : ''}}>
                                            E
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <!-- SÓ APARECE O HTML DEBAIXO SE A NATUREZA DESTE MOVIMENTO FOR DE INSTRUÇÃO (I) -->

                        <div class="form-group">
                            <label for="tipo_instrucao" class="col-sm-4 col-form-label"> Tipo Instrução </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="tipo_instrucao">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="D" {{old('tipo_instrucao', $movimento->tipo_instrucao) == 'D' ? 'selected' : ''}}>
                                            D
                                        </option>
                                        <option value="S" {{old('tipo_instrucao', $movimento->tipo_instrucao) == 'S' ? 'selected' : ''}}>
                                            S
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_licenca_piloto" class="col-sm-4 col-form-label"> Nº licença Piloto</label>
                            <div class="col-sm-10">
                                <input type="text" name="num_licenca_piloto" class="form-control"
                                       id="num_licenca_piloto"
                                       value="{{old('num_licenca_piloto', $movimento->num_licenca_piloto)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_licenca_piloto" class="col-sm-4 col-form-label"> Tipo Licença
                                Piloto</label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="tipo_licenca_piloto">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="ALUNO-PPL(A)" {{old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) == 'ALUNO-PPL(A)' ? 'selected' : ''}}>
                                            Aluno - Private Pilot License Airplane
                                        </option>
                                        <option value="ALUNO-PU" {{old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) == 'ALUNO-PU' ? 'selected' : ''}}>
                                            Aluno - Piloto de Ultraleve
                                        </option>
                                        <option value="ATPL" {{old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) == 'ATPL' ? 'selected' : ''}}>
                                            Airline Transport Pilot License
                                        </option>
                                        <option value="CPL(A)" {{old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) == 'CPL(A)' ? 'selected' : ''}}>
                                            Comercial Pilot License Airplane
                                        </option>
                                        <option value="PPL(A)" {{old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) == 'PPL(A)' ? 'selected' : ''}}>
                                            Private Pilot License Airplane
                                        </option>
                                        <option value="PU" {{old('tipo_licenca_piloto', $movimento->tipo_licenca_piloto) == 'PU' ? 'selected' : ''}}>
                                            Piloto de Ultraleve
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validade_licenca_piloto" class="col-sm-4 col-form-label"> Validade licença
                                Piloto</label>
                            <div class="col-sm-10">
                                <input type="date" name="validade_licenca_piloto" class="form-control"
                                       id="validade_licenca_piloto"
                                       value="{{old('validade_licenca_piloto', $movimento->validade_licenca_piloto)}}"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="num_certificado_piloto" class="col-sm-4 col-form-label"> Número Certificado
                                Médico Piloto</label>
                            <div class="col-sm-10">
                                <input type="text" name="num_certificado_piloto" class="form-control"
                                       id="num_certificado_piloto"
                                       value="{{old('num_certificado_piloto', $movimento->num_certificado_piloto)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="classe_certificado_piloto" class="col-sm-4 col-form-label"> Classe do
                                Certificado do Piloto</label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="classe_certificado_piloto">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="Class 1" {{old('classe_certificado_piloto', $movimento->classe_certificado_piloto) == 'Class 1' ? 'selected' : ''}}>
                                            Class 1 medical certificate
                                        </option>
                                        <option value="Class 2" {{old('classe_certificado_piloto', $movimento->classe_certificado_piloto) == 'Class 2' ? 'selected' : ''}}>
                                            Class 2 medical certificate
                                        </option>
                                        <option value="LAPL" {{old('classe_certificado_piloto', $movimento->classe_certificado_piloto) == 'LAPL' ? 'selected' : ''}}>
                                            Light Aircraft Pilot Licence Medical
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="validade_certificado_piloto" class="col-sm-4 col-form-label"> Validade do
                                Certificado do Piloto</label>
                            <div class="col-sm-10">
                                <input type="date" name="validade_certificado_piloto" class="form-control"
                                       id="validade_certificado_piloto"
                                       value="{{old('validade_certificado_piloto', $movimento->validade_certificado_piloto)}}"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="num_licenca_instrutor" class="col-sm-4 col-form-label">Número Licença
                                Instrutor</label>
                            <div class="col-sm-10">
                                <input type="number" name="num_licenca_instrutor" class="form-control"
                                       id="num_licenca_instrutor"
                                       value="{{old('num_licenca_instrutor', $movimento->num_licenca_instrutor)}}"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="tipo_licenca_instrutor" class="col-sm-4 col-form-label"> Tipo Licença
                                Instrutor</label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="tipo_licenca_instrutor">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="ALUNO-PPL(A)" {{old('tipo_licenca_instrutor', $movimento->tipo_licenca_instrutor) == 'ALUNO-PPL(A)' ? 'selected' : ''}}>
                                            Aluno - Private Pilot License Airplane
                                        </option>
                                        <option value="ALUNO-PU" {{old('tipo_licenca_instrutor', $movimento->tipo_licenca_instrutor) == 'ALUNO-PU' ? 'selected' : ''}}>
                                            Aluno - Piloto de Ultraleve
                                        </option>
                                        <option value="ATPL" {{old('tipo_licenca_instrutor', $movimento->tipo_licenca_instrutor) == 'ATPL' ? 'selected' : ''}}>
                                            Airline Transport Pilot License
                                        </option>
                                        <option value="CPL(A)" {{old('tipo_licenca_instrutor', $movimento->tipo_licenca_instrutor) == 'CPL(A)' ? 'selected' : ''}}>
                                            Comercial Pilot License Airplane
                                        </option>
                                        <option value="PPL(A)" {{old('tipo_licenca_instrutor', $movimento->tipo_licenca_instrutor) == 'PPL(A)' ? 'selected' : ''}}>
                                            Private Pilot License Airplane
                                        </option>
                                        <option value="PU" {{old('tipo_licenca_instrutor', $movimento->tipo_licenca_instrutor) == 'PU' ? 'selected' : ''}}>
                                            Piloto de Ultraleve
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validade_licenca_instrutor" class="col-sm-4 col-form-label">Validade
                                Licença
                                Instrutor</label>
                            <div class="col-sm-10">
                                <input type="date" name="validade_licenca_instrutor" class="form-control"
                                       id="validade_licenca_instrutor"
                                       value="{{old('validade_licenca_instrutor', $movimento->validade_licenca_instrutor)}}"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_certificado_instrutor" class="col-sm-4 col-form-label"> Número
                                Certificado
                                Médico Instrutor </label>
                            <div class="col-sm-10">
                                <input type="text" name="num_certificado_instrutor" class="form-control"
                                       id="num_certificado_instrutor"
                                       value="{{old('num_certificado_instrutor', $movimento->num_certificado_instrutor)}}"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validade_licenca_instrutor" class="col-sm-4 col-form-label">Validade
                                Licença
                                Instrutor</label>
                            <div class="col-sm-10">
                                <input type="date" name="validade_licenca_instrutor" class="form-control"
                                       id="validade_licenca_instrutor"
                                       value="{{old('validade_licenca_instrutor', $movimento->validade_licenca_instrutor)}}"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="instrutor_id" class="col-sm-4 col-form-label"> Id Instrutor </label>
                            <div class="col-sm-10">
                                <input type="text" name="instrutor_id" class="form-control" id="instrutor_id"
                                       value="{{old('instrutor_id', $movimento->instrutor_id)}}"/>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="classe_certificado_instrutor" class="col-sm-4 col-form-label"> Classe do
                                Certificado Médico do Instrutor</label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="classe_certificado_instrutor">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="Class 1" {{old('classe_certificado_instrutor', $movimento->classe_certificado_instrutor) == 'Class 1' ? 'selected' : ''}}>
                                            Class 1 medical certificate
                                        </option>
                                        <option value="Class 2" {{old('classe_certificado_instrutor', $movimento->classe_certificado_instrutor) == 'Class 2' ? 'selected' : ''}}>
                                            Class 2 medical certificate
                                        </option>
                                        <option value="LAPL" {{old('classe_certificado_instrutor', $movimento->classe_certificado_instrutor) == 'LAPL' ? 'selected' : ''}}>
                                            Light Aircraft Pilot Licence Medical
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validade_certificado_instrutor" class="col-sm-4 col-form-label">Validade Certificado Médico Instrutor</label>
                            <div class="col-sm-10">
                                <input type="date" name="validade_certificado_instrutor" class="form-control"
                                       id="validade_certificado_instrutor"
                                       value="{{old('validade_certificado_instrutor', $movimento->validade_certificado_instrutor)}}"/>
                            </div>
                        </div>

                        @if(Auth::user()->direcao == '1')
                            <div class="form-group">
                                <label for="confirmado" class="col-sm-4 col-form-label"> Confirmado </label>
                                <div class="col-sm-10">

                                    <p>
                                        <select name="confirmado">
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
                                        </select>
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="confirmado" class="col-sm-4 col-form-label"> Confirmado </label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="confirmado" value="0">
                                    <p>
                                        <select name="confirmado" disabled>
                                            <option value="">Não</option>
                                            <option value="">Sim</option>
                                        </select>
                                    </p>
                                </div>
                            </div>

                        @endif


                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="ok" value="Guardar">
                            <a class="btn btn-primary" href="{{action('MovimentoController@index')}}">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
