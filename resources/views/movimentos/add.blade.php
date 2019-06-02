@extends('layouts.app')

@section('content')

    @if($errors->any())
        @include('partials.errors')
    @endif


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <form method="POST" action="{{action('MovimentoController@store',$movimento)}}"
                          encrypte="multipart/form-data">

                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="aeronave" class="col-sm-4 col-form-label"> Matricula aeronave </label>
                            <div class="col-sm-10">
                                <input type="text" name="aeronave" class="form-control" id="aeronave"
                                       placeholder="Matrícula"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="piloto_id" class="col-sm-4 col-form-label"> Id Piloto </label>
                            <div class="col-sm-10">
                                <input type="text" name="piloto_id" class="form-control" id="piloto_id"
                                       value="{{Auth::user()->id}}" readonly/>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="data" class="col-sm-4 col-form-label"> Data </label>
                            <div class="col-sm-10">
                                <input type="date" name="data" class="form-control" id="data"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora_descolagem" class="col-sm-4 col-form-label"> Hora Descolagem </label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="hora_descolagem" class="form-control"
                                       id="hora_descolagem"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hora_aterragem" class="col-sm-4 col-form-label"> Hora Aterragem </label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="hora_aterragem" class="form-control"
                                       id="hora_aterragem"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tempo_voo" class="col-sm-4 col-form-label"> Tempo Voo </label>
                            <div class="col-sm-10">
                                <input type="number" name="tempo_voo" class="form-control" id="tempo_voo"
                                       placeholder="Tempo"/>
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
                                       placeholder="num_aterragens"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_descolagens" class="col-sm-4 col-form-label"> Nº Descolagens </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_descolagens" class="form-control" id="num_descolagens"
                                       placeholder="num_descolagens"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_diario" class="col-sm-4 col-form-label"> Nº Diário </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_diario" class="form-control" id="num_diario"
                                       placeholder="num_diario"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_servico" class="col-sm-4 col-form-label"> Nº Serviço </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_servico" class="form-control" id="num_servico"
                                       placeholder="num_servico"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_inicio" class="col-sm-4 col-form-label"> Conta-Horas Início </label>
                            <div class="col-sm-10">
                                <input type="number" name="conta_horas_inicio" class="form-control"
                                       id="conta_horas_inicio" placeholder="conta_horas_inicio"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conta_horas_fim" class="col-sm-4 col-form-label"> Conta-Horas Fim </label>
                            <div class="col-sm-10">
                                <input type="number" name="conta_horas_fim" class="form-control" id="conta_horas_fim"
                                       placeholder="conta_horas_fim"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_pessoas" class="col-sm-4 col-form-label"> Nº Pessoas </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_pessoas" class="form-control" id="num_pessoas"
                                       placeholder="num_pessoas"/>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="modo_pagamento" class="col-sm-4 col-form-label"> Modo de Pagamento </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="modo_pagamento">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="N">N</option>
                                        <option value="M">M</option>
                                        <option value="T">T</option>
                                        <option value="P">P</option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="preco_voo" class="col-sm-4 col-form-label"> Preço do Voo </label>
                            <div class="col-sm-10">
                                <input type="number" name="preco_voo" class="form-control" id="preco_voo"
                                       placeholder="preco_voo"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_recibo" class="col-sm-4 col-form-label"> Nº do Recibo </label>
                            <div class="col-sm-10">
                                <input type="number" name="num_recibo" class="form-control" id="num_recibo"
                                       placeholder="num_recibo"/>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observacoes" class="col-sm-4 col-form-label"> Observações </label>
                            <div class="col-sm-10">
                                <input type="text" name="observacoes" class="form-control" id="observacoes"
                                       placeholder="observacoes"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label id="natureza" for="natureza" class="col-sm-4 col-form-label"> Natureza </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="natureza" id="natureza">
                                        <option value="-1" disabled selected="">Selecione...</option>
                                        <option value="T">T</option>
                                        <option value="I">I</option>
                                        <option value="E">E</option>
                                    </select>
                                </p>
                            </div>
                        </div>


                        <!-- SÓ APARECE O HTML DEBAIXO SE A NATUREZA DESTE MOVIMENTO FOR DE INSTRUÇÃO (I) -->

                        <div id="mostrarIntrutor">
                            <div class="form-group">

                                <label id="l-tipo_instrucao" for="tipo_instrucao" class="col-sm-4 col-form-label">
                                    Tipo
                                    Instrução </label>
                                <div class="col-sm-10">
                                    <p>
                                        <select id="tipo_instrucao" name="tipo_instrucao"
                                                class="form-control">
                                            <option disabled selected="">Selecione...</option>
                                            <option value="D">D</option>
                                            <option value="S">S</option>
                                        </select>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="num_licenca_piloto" class="col-sm-4 col-form-label"> Nº licença
                                    Piloto</label>
                                <div class="col-sm-10">
                                    <input type="text" name="num_licenca_piloto" class="form-control"
                                           id="num_licenca_piloto" value="{{Auth::user()->num_licenca_piloto}}"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tipo_licenca_piloto" class="col-sm-4 col-form-label"> Tipo Licença
                                    Piloto</label>
                                <div class="col-sm-10">
                                    <p>
                                        <select name="tipo_licenca_piloto">
                                            <option disabled selected="">Selecione...</option>
                                            <option value="ALUNO-PPL(A) ">Aluno - Private Pilot License Airplane
                                            </option>
                                            <option value="ALUNO-PU">Aluno - Piloto de Ultraleve</option>
                                            <option value="ATPL">Airline Transport Pilot License</option>
                                            <option value="CPL(A)">Comercial Pilot License Airplane</option>
                                            <option value="PPL(A)">Private Pilot License Airplane</option>
                                            <option value="PU">Piloto de Ultraleve</option>
                                        </select>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="validade_licenca_piloto" class="col-sm-4 col-form-label"> Validade
                                    licença
                                    Piloto</label>
                                <div class="col-sm-10">
                                    <input type="date" name="validade_licenca_piloto" class="form-control"
                                           id="validade_licenca_piloto"
                                           value="{{Auth::user()->validade_licenca_piloto}}"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="num_certificado_piloto" class="col-sm-4 col-form-label"> Número
                                    Certificado
                                    Médico Piloto </label>
                                <div class="col-sm-10">
                                    <input type="text" name="num_certificado_piloto" class="form-control"
                                           id="num_certificado_piloto"
                                           value="{{Auth::user()->num_certificado_piloto}}"/>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="classe_certificado_piloto" class="col-sm-4 col-form-label"> Classe do
                                    Certificado do Piloto</label>
                                <div class="col-sm-10">
                                    <p>
                                        <select name="classe_certificado_piloto">
                                            <option disabled selected="">Selecione...</option>
                                            <option value="Class 1">Class 1 medical certificate</option>
                                            <option value="Class 2">Class 2 medical certificate</option>
                                            <option value="LAPL"> Light Aircraft Pilot Licence Medical
                                            </option>
                                        </select>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="validade_certificado_piloto" class="col-sm-4 col-form-label">Validade
                                    Certificado Médico Piloto</label>
                                <div class="col-sm-10">
                                    <input type="date" name="validade_certificado_piloto" class="form-control"
                                           id="validade_certificado_piloto"
                                           value="{{Auth::user()->validade_certificado_piloto}}"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="num_licenca_instrutor" class="col-sm-4 col-form-label">Número Licença
                                    Instrutor</label>
                                <div class="col-sm-10">
                                    <input type="number" name="num_licenca_instrutor" class="form-control"
                                           id="num_licenca_instrutor" placeholder="Nº liceça Instrutor"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tipo_licenca_instrutor" class="col-sm-4 col-form-label"> Tipo Licença
                                    Instrutor</label>
                                <div class="col-sm-10">
                                    <p>
                                        <select name="tipo_licenca_instrutor">
                                            <option disabled selected="">Selecione...</option>
                                            <option value="ALUNO-PPL(A)">Aluno - Private Pilot License Airplane
                                            </option>
                                            <option value="ALUNO-PU">Aluno - Piloto de Ultraleve</option>
                                            <option value="ATPL">Airline Transport Pilot License</option>
                                            <option value="CPL(A)">Comercial Pilot License Airplane</option>
                                            <option value="PPL(A)">Private Pilot License Airplane</option>
                                            <option value="PU">Piloto de Ultraleve</option>
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
                                           id="validade_licenca_instrutor"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="num_certificado_instrutor" class="col-sm-4 col-form-label"> Número
                                    Certificado
                                    Médico Instrutor </label>
                                <div class="col-sm-10">
                                    <input type="text" name="num_certificado_instrutor" class="form-control"
                                           id="num_certificado_instrutor"
                                           placeholder="Nº Certificado Médico Instrutor"/>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="validade_licenca_instrutor" class="col-sm-4 col-form-label">Validade
                                    Licença
                                    Instrutor</label>
                                <div class="col-sm-10">
                                    <input type="date" name="validade_licenca_instrutor" class="form-control"
                                           id="validade_licenca_instrutor" placeholder="Validade"/>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="instrutor_id" class="col-sm-4 col-form-label"> Id Instrutor </label>
                                <div class="col-sm-10">
                                    <input type="text" name="instrutor_id" class="form-control" id="instrutor_id"
                                           placeholder="instrutor_id"/>

                                </div>
                            </div>


                            <div class="form-group">
                                <label for="classe_certificado_instrutor" class="col-sm-4 col-form-label"> Classe do
                                    Certificado Médico do Instrutor</label>
                                <div class="col-sm-10">
                                    <p>
                                        <select name="classe_certificado_instrutor">
                                            <option disabled selected="">Selecione...</option>
                                            <option value="Class 1">Class 1 medical certificate</option>
                                            <option value="Class 2">Class 2 medical certificate</option>
                                            <option value="LAPL"> Light Aircraft Pilot Licence Medical
                                            </option>
                                        </select>
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="validade_certificado_instrutor" class="col-sm-4 col-form-label">Validade
                                    Certificado
                                    Médico Instrutor</label>
                                <div class="col-sm-10">
                                    <input type="date" name="validade_certificado_instrutor" class="form-control"
                                           id="validade_certificado_instrutor"/>
                                </div>
                            </div>
                            @if(Auth::user()->direcao == '1')
                                <div class="form-group">
                                    <label for="confirmado" class="col-sm-4 col-form-label"> confirmado </label>
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
                        </div>

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
