@extends('layouts.app')

@section('content')

    @if($errors->any())
        @include('partials.errors')
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <form method="POST" action="{{action('MovimentoController@store',$movimento)}}" encrypte="multipart/form-data">

                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="aeronave" class="col-sm-4 col-form-label"> Matricula aeronave </label>
                            <div class="col-sm-10">
                                <input type="text" name="aeronave" class="form-control" id="aeronave" placeholder="aeronave" value="{{old('aeronave',$movimento->aeronave)}}" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="num_licenca_piloto" class="col-sm-4 col-form-label"> Nº licença Piloto</label>
                            <div class="col-sm-10">
                                <input type="text" name="num_licenca_piloto" class="form-control" id="num_licenca_piloto" placeholder="num_licenca_piloto" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validade_licenca_piloto" class="col-sm-4 col-form-label"> Validade licença Piloto</label>
                            <div class="col-sm-10">
                                <input type="date" name="validade_licenca_piloto" class="form-control" id="validade_licenca_piloto" placeholder="validade_licenca_piloto" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_licenca_piloto" class="col-sm-4 col-form-label"> Tipo Licença Piloto</label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="tipo_licenca_piloto">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="ALUNO-PPL(A)">Aluno - Private Pilot License Airplane</option>
                                        <option value="ALUNO-PU">Aluno - Piloto de Ultraleve</option>
                                        <option value="ATPL">Airline Transport Pilot License</option>
                                        <option value="CPL(A)">Comercial Pilot License Airplane</option>
                                        <option value="PPL(A)">Private Pilot License Airplane</option>
                                        <option value="PU">Piloto de Ultraleve</option>
                                    </select>
                                </p></div>
                        </div>

                        <div class="form-group">
                            <label for="num_certificado_piloto" class="col-sm-4 col-form-label"> Nº de Certificado do Piloto</label>
                            <div class="col-sm-10">
                                <input type="text" name="num_certificado_piloto" class="form-control" id="num_certificado_piloto" placeholder="num_certificado_piloto" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validade_certificado_piloto" class="col-sm-4 col-form-label"> Validade do Certificado do Piloto</label>
                            <div class="col-sm-10">
                                <input type="date" name="validade_certificado_piloto" class="form-control" id="validade_certificado_piloto" placeholder="validade_certificado_piloto" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="classe_certificado_piloto" class="col-sm-4 col-form-label"> Classe do Certificado do Piloto</label>
                            <div class="col-sm-10">
                                <input type="text" name="classe_certificado_piloto" class="form-control" id="classe_certificado_piloto" placeholder="classe_certificado_piloto" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data" class="col-sm-4 col-form-label"> Data </label>
                            <div class="col-sm-10">
                                <input type="date" name="data" class="form-control" id="data" placeholder="data" />

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
                                <p>
                                    <select name="natureza">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="T">T</option>
                                        <option value="I">I</option>
                                        <option value="E">E</option>
                                    </select>
                                </p>
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
                                <p>
                                    <select name="aerodromo_partida">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="LPAR">Base Aérea Alverca</option>
                                        <option value="LPAV">Base Aérea de São Jacinto - Aveiro</option>
                                        <option value="LPBG">	Bragança</option>
                                        <option value="LPBJ">Beja</option>
                                        <option value="LPBR">Braga</option>
                                        <option value="LPCB">Castelo Branco</option>
                                        <option value="LPCH">Chaves</option>
                                        <option value="LPCO">Coimbra - Bissaya Barreto</option>
                                        <option value="LPCS">Cascais</option>
                                        <option value="LPEV">Évora</option>
                                        <option value="LPFA">Ferreira do Alentejo</option>
                                        <option value="LPFC">Figueira de Cavaleiros</option>
                                        <option value="LPFR">Faro</option>
                                        <option value="LPIN">Espinho</option>
                                        <option value="LPJF">Leiria - José Ferrinho</option>
                                        <option value="LPLZ">Lousã</option>
                                        <option value="LPMI">Mirandela</option>
                                        <option value="LPMN">Amendoeira - Montemor-o-Novo</option>
                                        <option value="LPMR">	Base Aérea Monte Real</option>
                                        <option value="Base Aérea Montijo">LPMT</option>
                                        <option value="LPMU">Mogadouro</option>
                                        <option value="LPOT">Base Aérea Ota</option>
                                        <option value="LPOV">Base Aérea Ovar</option>
                                        <option value="LPPM">Portimão</option>
                                        <option value="LPPN">Proença a Nova</option>
                                        <option value="LPPR">Porto - Sá Carneiro</option>
                                        <option value="LPPT">Lisboa - Humberto Delgado</option>
                                        <option value="LPSC">Santa Cruz</option>
                                        <option value="LPSE">Seia</option>
                                        <option value="LPSO">Ponte de Sôr</option>
                                        <option value="LPSR">Santarém</option>
                                        <option value="LPST">Base Aérea Sintra</option>
                                        <option value="LPTN">Base Aérea Tancos</option>
                                        <option value="LPVL">Maia - Vilar de Luz</option>
                                        <option value="LPVR">Vila Real</option>
                                        <option value="viseu">Viseu</option>
                                        <option value="U-AIRPARK">Alentejo Air Park</option>
                                        <option value="U-ALQUEIDAO">Alqueidão</option>
                                        <option value="U-ATOUGUIA">Atouguia da Baleia</option>
                                        <option value="U-AZAMBUJA">Azambuja</option>
                                        <option value="U-BEJA">Beja UL</option>
                                        <option value="U-BENAVENTE">Benavente</option>
                                        <option value="U-CAB_BASTO">Cabeceiras de Basto</option>
                                        <option value="U-CAB_VACA">	Cabeço de Vaca</option>
                                        <option value="U-CAMPINHO">Campinho</option>
                                        <option value="U-CASARAO">Casarão</option>
                                        <option value="U-CERVAL">Cerval</option>
                                        <option value="U-FAIAS">Faias</option>
                                        <option value="U-LAGOS">Lagos</option>
                                        <option value="U-LAMEIRA">Herdade da Lameira</option>
                                    </select>
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="aerodromo_chegada" class="col-sm-4 col-form-label"> Aerodromo Chegada </label>
                            <div class="col-sm-10">
                                <p>
                                    <select name="aerodromo_chegada">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="LPAR">Base Aérea Alverca</option>
                                        <option value="LPAV">Base Aérea de São Jacinto - Aveiro</option>
                                        <option value="LPBG">	Bragança</option>
                                        <option value="LPBJ">Beja</option>
                                        <option value="LPBR">Braga</option>
                                        <option value="LPCB">Castelo Branco</option>
                                        <option value="LPCH">Chaves</option>
                                        <option value="LPCO">Coimbra - Bissaya Barreto</option>
                                        <option value="LPCS">Cascais</option>
                                        <option value="LPEV">Évora</option>
                                        <option value="LPFA">Ferreira do Alentejo</option>
                                        <option value="LPFC">Figueira de Cavaleiros</option>
                                        <option value="LPFR">Faro</option>
                                        <option value="LPIN">Espinho</option>
                                        <option value="LPJF">Leiria - José Ferrinho</option>
                                        <option value="LPLZ">Lousã</option>
                                        <option value="LPMI">Mirandela</option>
                                        <option value="LPMN">Amendoeira - Montemor-o-Novo</option>
                                        <option value="LPMR">	Base Aérea Monte Real</option>
                                        <option value="Base Aérea Montijo">LPMT</option>
                                        <option value="LPMU">Mogadouro</option>
                                        <option value="LPOT">Base Aérea Ota</option>
                                        <option value="LPOV">Base Aérea Ovar</option>
                                        <option value="LPPM">Portimão</option>
                                        <option value="LPPN">Proença a Nova</option>
                                        <option value="LPPR">Porto - Sá Carneiro</option>
                                        <option value="LPPT">Lisboa - Humberto Delgado</option>
                                        <option value="LPSC">Santa Cruz</option>
                                        <option value="LPSE">Seia</option>
                                        <option value="LPSO">Ponte de Sôr</option>
                                        <option value="LPSR">Santarém</option>
                                        <option value="LPST">Base Aérea Sintra</option>
                                        <option value="LPTN">Base Aérea Tancos</option>
                                        <option value="LPVL">Maia - Vilar de Luz</option>
                                        <option value="LPVR">Vila Real</option>
                                        <option value="viseu">Viseu</option>
                                        <option value="U-AIRPARK">Alentejo Air Park</option>
                                        <option value="U-ALQUEIDAO">Alqueidão</option>
                                        <option value="U-ATOUGUIA">Atouguia da Baleia</option>
                                        <option value="U-AZAMBUJA">Azambuja</option>
                                        <option value="U-BEJA">Beja UL</option>
                                        <option value="U-BENAVENTE">Benavente</option>
                                        <option value="U-CAB_BASTO">Cabeceiras de Basto</option>
                                        <option value="U-CAB_VACA">	Cabeço de Vaca</option>
                                        <option value="U-CAMPINHO">Campinho</option>
                                        <option value="U-CASARAO">Casarão</option>
                                        <option value="U-CERVAL">Cerval</option>
                                        <option value="U-FAIAS">Faias</option>
                                        <option value="U-LAGOS">Lagos</option>
                                        <option value="U-LAMEIRA">Herdade da Lameira</option>
                                    </select>
                                </p>
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
                                <p>
                                    <select name="tipo_instrucao">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="D">D</option>
                                        <option value="S">S</option>
                                    </select>
                                </p>
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
                                <input type="text" name="preco_voo" class="form-control" id="preco_voo" placeholder="preco_voo"/>

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
                            <label for="confirmado" class="col-sm-4 col-form-label"> Confirmado </label>
                            <div class="col-sm-10">
                                <input type="text" name="confirmado" class="form-control" id="confirmado" placeholder="confirmado" />

                            </div>
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
