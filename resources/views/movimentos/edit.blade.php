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
                                    <select name="aerodromo_partida">
                                        <option disabled selected="">Selecione...</option>
                                        <option value="LPAR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPAR' ? 'selected' : ''}}>
                                            Base Aérea Alverca
                                        </option>
                                        <option value="LPAR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPAR' ? 'selected' : ''}}>
                                            Base Aérea de São Jacinto - Aveiro
                                        </option>
                                        <option value="LPAR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPAR' ? 'selected' : ''}}>
                                            Bragança
                                        </option>
                                        <option value="LPAR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPAR' ? 'selected' : ''}}>
                                            Beja
                                        </option>
                                        <option value="LPBR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPBR' ? 'selected' : ''}}>
                                            Braga
                                        </option>
                                        <option value="LPCB" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPCB' ? 'selected' : ''}}>
                                            Castelo Branco
                                        </option>
                                        <option value="LPCH" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPCH' ? 'selected' : ''}}>
                                            Chaves
                                        </option>
                                        <option value="LPCO" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPCO' ? 'selected' : ''}}>
                                            Coimbra - Bissaya Barreto
                                        </option>
                                        <option value="LPCS" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPCS' ? 'selected' : ''}}>
                                            Cascais
                                        </option>
                                        <option value="LPEV" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPEV' ? 'selected' : ''}}>
                                            Évora
                                        </option>
                                        <option value="LPFA" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPFA' ? 'selected' : ''}}>
                                            Ferreira do Alentejo
                                        </option>
                                        <option value="LPFC" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPFC' ? 'selected' : ''}}>
                                            Figueira de Cavaleiros
                                        </option>
                                        <option value="LPFR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPFR' ? 'selected' : ''}}>
                                            Faro
                                        </option>
                                        <option value="LPIN" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPIN' ? 'selected' : ''}}>
                                            Espinho
                                        </option>
                                        <option value="LPJF" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPJF' ? 'selected' : ''}}>
                                            Leiria - José Ferrinho
                                        </option>
                                        <option value="LPLZ" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPLZ' ? 'selected' : ''}}>
                                            Lousã
                                        </option>
                                        <option value="LPMI" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPMI' ? 'selected' : ''}}>
                                            Mirandela
                                        </option>
                                        <option value="LPMN" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPMN' ? 'selected' : ''}}>
                                            Amendoeira - Montemor-o-Novo
                                        </option>
                                        <option value="LPMR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPMR' ? 'selected' : ''}}>
                                            Base Aérea Monte Real
                                        </option>
                                        <option value="Base Aérea Montijo" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'Base Aérea Montijo' ? 'selected' : ''}}>
                                            LPMT
                                        </option>
                                        <option value="LPMU" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPMU' ? 'selected' : ''}}>
                                            Mogadouro
                                        </option>
                                        <option value="LPOT" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPOT' ? 'selected' : ''}}>
                                            Base Aérea Ota
                                        </option>
                                        <option value="LPOV" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPOV' ? 'selected' : ''}}>
                                            Base Aérea Ovar
                                        </option>
                                        <option value="LPPM" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPPM' ? 'selected' : ''}}>
                                            Portimão
                                        </option>
                                        <option value="LPPN" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPPN' ? 'selected' : ''}}>
                                            Proença a Nova
                                        </option>
                                        <option value="LPPR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPPR' ? 'selected' : ''}}>
                                            Porto - Sá Carneiro
                                        </option>
                                        <option value="LPPT" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPPT' ? 'selected' : ''}}>
                                            Lisboa - Humberto Delgado
                                        </option>
                                        <option value="LPSC" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPSC' ? 'selected' : ''}}>
                                            Santa Cruz
                                        </option>
                                        <option value="LPSE" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPSE' ? 'selected' : ''}}>
                                            Seia
                                        </option>
                                        <option value="LPSO" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPSO' ? 'selected' : ''}}>
                                            Ponte de Sôr
                                        </option>
                                        <option value="LPSR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPSR' ? 'selected' : ''}}>
                                            Santarém
                                        </option>
                                        <option value="LPST" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPST' ? 'selected' : ''}}>
                                            Base Aérea Sintra
                                        </option>
                                        <option value="LPTN" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPTN' ? 'selected' : ''}}>
                                            Base Aérea Tancos
                                        </option>
                                        <option value="LPVL" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPVL' ? 'selected' : ''}}>
                                            Maia - Vilar de Luz
                                        </option>
                                        <option value="LPVR" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'LPVR' ? 'selected' : ''}}>
                                            Vila Real
                                        </option>
                                        <option value="viseu" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'viseu' ? 'selected' : ''}}>
                                            Viseu
                                        </option>
                                        <option value="U-AIRPARK" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-AIRPARK' ? 'selected' : ''}}>
                                            Alentejo Air Park
                                        </option>
                                        <option value="U-ALQUEIDAO" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-ALQUEIDAO' ? 'selected' : ''}}>
                                            Alqueidão
                                        </option>
                                        <option value="U-ATOUGUIA" {{old('aerodromo_partida', $movimento->aerodromo_partida) == '"U-ATOUGUIA' ? 'selected' : ''}}>
                                            Atouguia da Baleia
                                        </option>
                                        <option value="U-AZAMBUJA" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-AZAMBUJA' ? 'selected' : ''}}>
                                            Azambuja
                                        </option>
                                        <option value="U-BEJA" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-BEJA' ? 'selected' : ''}}>
                                            Beja UL
                                        </option>
                                        <option value="U-BENAVENTE" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-BENAVENTE' ? 'selected' : ''}}>
                                            Benavente
                                        </option>
                                        <option value="U-CAB_BASTO" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-CAB_BASTO' ? 'selected' : ''}}>
                                            Cabeceiras de Basto
                                        </option>
                                        <option value="U-CAB_VACA" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-CAB_VACA' ? 'selected' : ''}}>
                                            Cabeço de Vaca
                                        </option>
                                        <option value="U-CAMPINHO" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-CAMPINHO' ? 'selected' : ''}}>
                                            Campinho
                                        </option>
                                        <option value="U-CASARAO" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-CASARAO' ? 'selected' : ''}}>
                                            Casarão
                                        </option>
                                        <option value="U-CERVAL" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-CERVAL' ? 'selected' : ''}}>
                                            Cerval
                                        </option>
                                        <option value="U-FAIAS" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-FAIAS' ? 'selected' : ''}}>
                                            Faias
                                        </option>
                                        <option value="U-LAGOS" {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-LAGOS' ? 'selected' : ''}}>
                                            Lagos
                                        </option>
                                        <option value="U-LAMEIRA"
                                                {{old('aerodromo_partida', $movimento->aerodromo_partida) == 'U-LAMEIRA' ? 'selected' : ''}}s>
                                            Herdade da Lameira
                                        </option>
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
                                        <option value="LPAR" {{old('aerodromo_chegada', $movimento->aerodromo_chegada) == 'LPAR' ? 'selected' : ''}}>
                                            Base Aérea Alverca
                                        </option>
                                        <option value="LPAR" {{old('aeroporto_chegada', $movimento->aerodromo_chegada) == 'LPAR' ? 'selected' : ''}}>
                                            Base Aérea de São Jacinto - Aveiro
                                        </option>
                                        <option value="LPAR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPAR' ? 'selected' : ''}}>
                                            Bragança
                                        </option>
                                        <option value="LPAR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPAR' ? 'selected' : ''}}>
                                            Beja
                                        </option>
                                        <option value="LPBR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPBR' ? 'selected' : ''}}>
                                            Braga
                                        </option>
                                        <option value="LPCB" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPCB' ? 'selected' : ''}}>
                                            Castelo Branco
                                        </option>
                                        <option value="LPCH" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPCH' ? 'selected' : ''}}>
                                            Chaves
                                        </option>
                                        <option value="LPCO" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPCO' ? 'selected' : ''}}>
                                            Coimbra - Bissaya Barreto
                                        </option>
                                        <option value="LPCS" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPCS' ? 'selected' : ''}}>
                                            Cascais
                                        </option>
                                        <option value="LPEV" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPEV' ? 'selected' : ''}}>
                                            Évora
                                        </option>
                                        <option value="LPFA" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPFA' ? 'selected' : ''}}>
                                            Ferreira do Alentejo
                                        </option>
                                        <option value="LPFC" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPFC' ? 'selected' : ''}}>
                                            Figueira de Cavaleiros
                                        </option>
                                        <option value="LPFR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPFR' ? 'selected' : ''}}>
                                            Faro
                                        </option>
                                        <option value="LPIN" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPIN' ? 'selected' : ''}}>
                                            Espinho
                                        </option>
                                        <option value="LPJF" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPJF' ? 'selected' : ''}}>
                                            Leiria - José Ferrinho
                                        </option>
                                        <option value="LPLZ" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPLZ' ? 'selected' : ''}}>
                                            Lousã
                                        </option>
                                        <option value="LPMI" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPMI' ? 'selected' : ''}}>
                                            Mirandela
                                        </option>
                                        <option value="LPMN" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPMN' ? 'selected' : ''}}>
                                            Amendoeira - Montemor-o-Novo
                                        </option>
                                        <option value="LPMR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPMR' ? 'selected' : ''}}>
                                            Base Aérea Monte Real
                                        </option>
                                        <option value="Base Aérea Montijo" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'Base Aérea Montijo' ? 'selected' : ''}}>
                                            LPMT
                                        </option>
                                        <option value="LPMU" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPMU' ? 'selected' : ''}}>
                                            Mogadouro
                                        </option>
                                        <option value="LPOT" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPOT' ? 'selected' : ''}}>
                                            Base Aérea Ota
                                        </option>
                                        <option value="LPOV" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPOV' ? 'selected' : ''}}>
                                            Base Aérea Ovar
                                        </option>
                                        <option value="LPPM" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPPM' ? 'selected' : ''}}>
                                            Portimão
                                        </option>
                                        <option value="LPPN" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPPN' ? 'selected' : ''}}>
                                            Proença a Nova
                                        </option>
                                        <option value="LPPR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPPR' ? 'selected' : ''}}>
                                            Porto - Sá Carneiro
                                        </option>
                                        <option value="LPPT" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPPT' ? 'selected' : ''}}>
                                            Lisboa - Humberto Delgado
                                        </option>
                                        <option value="LPSC" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPSC' ? 'selected' : ''}}>
                                            Santa Cruz
                                        </option>
                                        <option value="LPSE" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPSE' ? 'selected' : ''}}>
                                            Seia
                                        </option>
                                        <option value="LPSO" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPSO' ? 'selected' : ''}}>
                                            Ponte de Sôr
                                        </option>
                                        <option value="LPSR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPSR' ? 'selected' : ''}}>
                                            Santarém
                                        </option>
                                        <option value="LPST" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPST' ? 'selected' : ''}}>
                                            Base Aérea Sintra
                                        </option>
                                        <option value="LPTN" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPTN' ? 'selected' : ''}}>
                                            Base Aérea Tancos
                                        </option>
                                        <option value="LPVL" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPVL' ? 'selected' : ''}}>
                                            Maia - Vilar de Luz
                                        </option>
                                        <option value="LPVR" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'LPVR' ? 'selected' : ''}}>
                                            Vila Real
                                        </option>
                                        <option value="viseu" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'viseu' ? 'selected' : ''}}>
                                            Viseu
                                        </option>
                                        <option value="U-AIRPARK" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-AIRPARK' ? 'selected' : ''}}>
                                            Alentejo Air Park
                                        </option>
                                        <option value="U-ALQUEIDAO" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-ALQUEIDAO' ? 'selected' : ''}}>
                                            Alqueidão
                                        </option>
                                        <option value="U-ATOUGUIA" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == '"U-ATOUGUIA' ? 'selected' : ''}}>
                                            Atouguia da Baleia
                                        </option>
                                        <option value="U-AZAMBUJA" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-AZAMBUJA' ? 'selected' : ''}}>
                                            Azambuja
                                        </option>
                                        <option value="U-BEJA" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-BEJA' ? 'selected' : ''}}>
                                            Beja UL
                                        </option>
                                        <option value="U-BENAVENTE" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-BENAVENTE' ? 'selected' : ''}}>
                                            Benavente
                                        </option>
                                        <option value="U-CAB_BASTO" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-CAB_BASTO' ? 'selected' : ''}}>
                                            Cabeceiras de Basto
                                        </option>
                                        <option value="U-CAB_VACA" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-CAB_VACA' ? 'selected' : ''}}>
                                            Cabeço de Vaca
                                        </option>
                                        <option value="U-CAMPINHO" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-CAMPINHO' ? 'selected' : ''}}>
                                            Campinho
                                        </option>
                                        <option value="U-CASARAO" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-CASARAO' ? 'selected' : ''}}>
                                            Casarão
                                        </option>
                                        <option value="U-CERVAL" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-CERVAL' ? 'selected' : ''}}>
                                            Cerval
                                        </option>
                                        <option value="U-FAIAS" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-FAIAS' ? 'selected' : ''}}>
                                            Faias
                                        </option>
                                        <option value="U-LAGOS" {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-LAGOS' ? 'selected' : ''}}>
                                            Lagos
                                        </option>
                                        <option value="U-LAMEIRA"
                                                {{old('aeroporto_chegada', $movimento->aeroporto_chegada) == 'U-LAMEIRA' ? 'selected' : ''}}s>
                                            Herdade da Lameira
                                        </option>
                                    </select>
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
                            <label for="validade_certificado_instrutor" class="col-sm-4 col-form-label">Validade
                                Certificado
                                Médico Instrutor</label>
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
