<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US16_ATest extends USTestBase
{
    protected $userToSimulate;
    protected $movToSave;   
    protected $insertMov;    
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedPilotoUser();
        $this->seedPilotoInstrutorUser();
        $this->seedNormalMovimentos($this->pilotoUser->id);
        $this->updateMovimento_confirmado($this->normalMovimento->id, 0);
        $this->normalMovimento->confirmado = 0;
        $this->userToSimulate = $this->pilotoUser;
        $this->insertMov = true;
        $this->movToSave = $this->standardMovimentoComFormatoInput($this->pilotoUser->id);

        //$this->movToSave["id"] = -1;
        //dump($this->movToSave);
        // Se $this->insertMov = False, então:
        //$this->movToSave = $this->getRequestArrayFromMovimento($this->normalMovimento);        
    }

    protected function makeRequest($requestData) 
    {
        if ($this->insertMov) {
            return $this->actingAs($this->userToSimulate)->post('/movimentos', $requestData);
        } else {
            return $this->actingAs($this->userToSimulate)->put('/movimentos/'. $this->movToSave["id"], $requestData);
        }
    }

    protected function assertFieldInput($response, $fieldName) 
    {
        if ($this->insertMov) {
            $response->assertSeeInOrder_2(['<input', 'name="' .$fieldName. '"', '>'], 'Campo ['.$fieldName.'] não incluido ou inválido');
        } else {            
            $response->assertSeeInOrder_2(['<input', 'name="' .$fieldName. '"', 'value="'. $this->movToSave[$fieldName] .'"', '>'],'Campo ['.$fieldName.'] não incluido ou inválido');
        }
    }

    protected function assertFieldLookup($response, $fieldName, $keys = null, $descriptions = null) 
    {
        $response->assertSeeInOrder_2(['<', 'name="' .$fieldName. '"', '>'], 'Campo ['.$fieldName.'] não incluido ou inválido');
        if ($keys) {
            $response->assertSeeAll($keys, 'Valores (chaves) para selecionar o campo ['.$fieldName.'] não estão disponíveis');
        }
        if ($descriptions) {
            $response->assertSeeAll($descriptions, 'Valores de texto (descrição, nomes, ...) para selecionar o campo ['.$fieldName.'] não estão disponíveis');
        }
    }

    protected function assertFieldTextarea($response, $fieldName) 
    {
        if ($this->insertMov) {
            $response->assertSeeInOrder_2(['<textarea', 'name="' .$fieldName. '"', '>'], 'Campo ['.$fieldName.'] não incluido ou inválido');
        } else {            
            $response->assertSeeInOrder_2(['<textarea', 'name="' .$fieldName. '"', '>', $this->movToSave[$fieldName], '</textarea>'],'Campo ['.$fieldName.'] não incluido ou inválido');
        }
    }

    public function testEstruturaFormulario()
    {
        if ($this->insertMov) {
            $response = $this->actingAs($this->userToSimulate)->get("/movimentos/create");
        } else {
            $response = $this->actingAs($this->userToSimulate)->get("/movimentos/" . $this->movToSave["id"] . "/edit");
        }
        $response->assertStatus(200);
        if ($this->insertMov) {
            $response->assertSeeInOrder_2(['<form', 'method="POST"', '/movimentos', '>'],
            'Tem que incluir um formulário com o método POST e [action] que acaba em /movimentos');
        } else {
            $response->assertSeeInOrder_2(['<form', 'method="POST"', '/movimentos/' . $this->movToSave["id"] , '>'],
                'Tem que incluir um formulário com o método POST (PUT) e [action] que acaba em /movimentos/'. $this->movToSave["id"]);
            $response->assertSeeInOrder_2(['<input type="hidden" name="_method" value="PUT">'],'Formulário não inclui o campo _method com o valor PUT');
        }
        $response->assertSeeInOrder_2(['<input type="hidden" name="_token"'],'Formulário não inclui o _token');

        $this->assertFieldInput($response, 'data');
        $this->assertFieldInput($response, 'hora_descolagem');
        $this->assertFieldInput($response, 'hora_aterragem');
        $this->assertFieldInput($response, 'num_diario');
        $this->assertFieldInput($response, 'num_servico');
        $this->assertFieldInput($response, 'num_aterragens');
        $this->assertFieldInput($response, 'num_descolagens');
        $this->assertFieldInput($response, 'num_pessoas');
        $this->assertFieldInput($response, 'conta_horas_inicio');
        $this->assertFieldInput($response, 'conta_horas_fim');
        $this->assertFieldInput($response, 'tempo_voo');
        $this->assertFieldInput($response, 'preco_voo');
        $this->assertFieldInput($response, 'num_recibo');        
        $this->assertFieldTextarea($response, 'observacoes');

        $matriculas = DB::table('aeronaves')->whereNull('deleted_at')->pluck('matricula');
        $this->assertFieldLookup($response, 'aeronave', $matriculas);
        // Desativei esta verificação porque poderá ser possível implementar o movimento sem lista de pilotos (assumindo o user loggado)
        // $idPilotos = DB::table('users')->whereNull('deleted_at')->where('tipo_socio','P')->where('ativo',1)->pluck('id');        
        // $NomesPilotos = DB::table('users')->whereNull('deleted_at')->where('tipo_socio','P')->where('ativo',1)->pluck('nome_informal');        
        // $this->assertFieldLookup($response, 'piloto_id', $idPilotos, $NomesPilotos);
        $this->assertFieldLookup($response, 'piloto_id');

        // Desativei esta verificação porque poderá ser possível implementar o movimento sem lista de instrutores (assumindo de alguma forma o user loggado)
        // $idInstrutores = DB::table('users')->whereNull('deleted_at')->where('tipo_socio','P')->where('ativo',1)->where('instrutor',1)->pluck('id');        
        // $NomesInstrutores = DB::table('users')->whereNull('deleted_at')->where('tipo_socio','P')->where('ativo',1)->where('instrutor',1)->pluck('nome_informal');        
        // $this->assertFieldLookup($response, 'instrutor_id', $idInstrutores, $NomesInstrutores);
        $this->assertFieldLookup($response, 'instrutor_id');

        $naturezas = ['T', 'I', 'E'];
        $naturezasDesc = ['Treino', 'Instrução', 'Especial'];
        $this->assertFieldInput($response, 'natureza', $naturezas, $naturezasDesc);

        $aerodromos = DB::table('aerodromos')->pluck('code');
        $this->assertFieldInput($response, 'aerodromo_partida', $aerodromos);
        $this->assertFieldInput($response, 'aerodromo_chegada', $aerodromos);

        $modos = ['N', 'M', 'T', 'P'];
        $modosDesc = ['Numerário', 'Multibanco', 'Transferência', 'Pacote de horas'];
        $this->assertFieldInput($response, 'modo_pagamento', $modos, $modosDesc);

        $tipos = ['D', 'S'];
        $tiposDesc = ['Duplo Comando', 'Solo'];
        $this->assertFieldInput($response, 'tipo_instrucao', $tipos, $tiposDesc);
    }

    public function testValidacaoData()
    {
        $newdata = ["data" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('data', "O campo [data] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["data" =>  "123"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('data', "O campo [data] não é uma data");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["data" =>  "2-3-2019"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('data', "O formato do campo [data] é errado");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }
            
        $newdata = ["data" => $this->format_date_input("2019-01-20")];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('data', 'Não aceita o valor de data = ' . $this->format_date_input("2019-01-20"). ' (devia aceitar)');
    }

    public function testValidacaoHoraDescolagem()
    {
        $newdata = ["hora_descolagem" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('hora_descolagem', "O campo [hora_descolagem] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["hora_descolagem" =>  "123"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('hora_descolagem', "O campo [hora_descolagem] não é uma data");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["hora_descolagem" =>  "23-23"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('hora_descolagem', "O formato do campo [hora_descolagem] é errado");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }
            
        $newdata = ["hora_descolagem" => $this->format_time_input("2019-01-20 15:10:00")];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('hora_descolagem', 'Não aceita o valor de hora_descolagem = ' . $this->format_time_input("2019-01-20 15:10:00"). ' (devia aceitar)');
    }

    public function testValidacaoHoraAterragem()
    {
        $newdata = ["hora_aterragem" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('hora_aterragem', "O campo [hora_aterragem] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["hora_aterragem" =>  "123"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('hora_aterragem', "O campo [hora_aterragem] não é uma data");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["hora_aterragem" =>  "23-23"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('hora_aterragem', "O formato do campo [hora_aterragem] é errado");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }
            
        $newdata = ["hora_aterragem" => $this->format_time_input("2019-01-20 16:10:00")];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('hora_aterragem', 'Não aceita o valor de hora_aterragem = ' . $this->format_time_input("2019-01-20 16:10:00"). ' (devia aceitar)');
    }

    public function testValidacaoAeronave()
    {
        $newdata = ["aeronave" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('aeronave', "O campo [aeronave] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["aeronave" =>  "_1223_"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('aeronave', "O campo [aeronave] aceita valores que não existem na base de dados");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["aeronave" =>  "D-EAYV"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('aeronave', 'Não aceita o valor de aeronave = D-EAYV (devia aceitar)');
    }

    public function testValidacaoNumDiario()
    {
        $newdata = ["num_diario" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_diario', "O campo [num_diario] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_diario" =>  "324.32"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_diario', "O campo [num_diario] aceita números reais (só devia aceitar inteiros)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }


        $newdata = ["num_diario" =>  "4"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('num_diario', 'Não aceita o valor de num_diario = 4 (devia aceitar)');
    }

    public function testValidacaoNumServico()
    {
        $newdata = ["num_servico" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_servico', "O campo [num_servico] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_servico" =>  "324.32"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_servico', "O campo [num_servico] aceita números reais (só devia aceitar inteiros)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_servico" =>  "54000"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('num_servico', 'Não aceita o valor de num_servico = 54000 (devia aceitar)');
    }

    public function testValidacaoPiloto()
    {
        $newdata = ["piloto_id" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('piloto_id', "O campo [piloto_id] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["piloto_id" =>  "897328746"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('piloto_id', "O campo [piloto_id] aceita valores que não existem na base de dados");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["piloto_id" =>  $this->normalUser->id];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('piloto_id', "O campo [piloto_id] aceita um ID relativo a um sócio que não é piloto");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["piloto_id" =>  $this->pilotoUser->id];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('piloto_id', 'Não aceita o valor de piloto_id = ' . $this->pilotoUser->id . ' (devia aceitar)');
    }

    public function testValidacaoNatureza()
    {
        $newdata = ["natureza" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('natureza', "O campo [natureza] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["natureza" =>  "D"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('natureza', "O campo [natureza] aceita um valor inválido (ex: D) - só deveria aceita T, I ou E");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["natureza" =>  "E"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('natureza', 'Não aceita o valor de natureza = E (devia aceitar)');
    }

    public function testValidacaoAerodromoPartida()
    {
        $newdata = ["aerodromo_partida" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('aerodromo_partida', "O campo [aerodromo_partida] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["aerodromo_partida" =>  "XXZWDKOPAXASD"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('aerodromo_partida', "O campo [aerodromo_partida] aceita valores que não existem na base de dados");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $primeiroAerodromo= DB::table('aerodromos')->first()->code;
        $newdata = ["aerodromo_partida" =>  $primeiroAerodromo];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('aerodromo_partida', 'Não aceita o valor de aerodromo = ' . $primeiroAerodromo . ' (devia aceitar)');
    }


    public function testValidacaoAerodromoChegada()
    {
        $newdata = ["aerodromo_chegada" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('aerodromo_chegada', "O campo [aerodromo_chegada] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["aerodromo_chegada" =>  "XXZWDKOPAXASD"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('aerodromo_chegada', "O campo [aerodromo_chegada] aceita valores que não existem na base de dados");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $primeiroAerodromo= DB::table('aerodromos')->first()->code;
        $newdata = ["aerodromo_chegada" =>  $primeiroAerodromo];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('aerodromo_chegada', 'Não aceita o valor de aerodromo = ' . $primeiroAerodromo . ' (devia aceitar)');
    }

    public function testValidacaoNumAterragens()
    {
        $newdata = ["num_aterragens" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_aterragens', "O campo [num_aterragens] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_aterragens" =>  "34.32"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_aterragens', "O campo [num_aterragens] aceita números reais (só devia aceitar inteiros)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_aterragens" =>  "-1"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_aterragens', "O campo [num_aterragens] aceita valores negativos (só devia aceitar valores positivos)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_aterragens" =>  "2"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('num_aterragens', 'Não aceita o valor de num_aterragens = 2 (devia aceitar)');
    }

    public function testValidacaoNumDescolagens()
    {
        $newdata = ["num_descolagens" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_descolagens', "O campo [num_descolagens] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_descolagens" =>  "34.32"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_descolagens', "O campo [num_descolagens] aceita números reais (só devia aceitar inteiros)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_descolagens" =>  "-1"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_descolagens', "O campo [num_descolagens] aceita valores negativos (só devia aceitar valores positivos)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_descolagens" =>  "3"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('num_descolagens', 'Não aceita o valor de num_descolagens = 3 (devia aceitar)');
    }


    public function testValidacaoNumPessoas()
    {
        $newdata = ["num_pessoas" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_pessoas', "O campo [num_pessoas] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_pessoas" =>  "2.32"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_pessoas', "O campo [num_pessoas] aceita números reais (só devia aceitar inteiros)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_pessoas" =>  "-1"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_pessoas', "O campo [num_pessoas] aceita valores negativos (só devia aceitar valores positivos)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_pessoas" =>  "0"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_pessoas', "O campo [num_pessoas] aceita valor zero (só devia aceitar valores positivos)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_pessoas" =>  "2"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('num_pessoas', 'Não aceita o valor de num_pessoas = 2 (devia aceitar)');
    }

    // Os testes de validação dos conta_horas_inicio e conta_horas_fim são diferentes,
    // porque, como os dois devem ser interdependentes, quando um deles não tem o mesmo
    // tipo que o outro, a aplicação devolve status code 500 (The values under comparison must be of the same type)
    // em vez de devolver erros de validação
    // Assim sendo, não vou verificar os valores errados nestes campos individualmente.

    public function testValidacaoContaHorasInicioContaHorasFim()
    {
        $newdata = [
            "conta_horas_inicio" =>  null,
            "conta_horas_fim" =>  null,
        ];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('conta_horas_inicio', "O campo [conta_horas_inicio] é obrigatório");
        $response->assertInvalid('conta_horas_fim', "O campo [conta_horas_fim] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }        

        $newdata = [
            "conta_horas_inicio" =>  132.32,
            "conta_horas_fim" =>  156.43,
        ];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('conta_horas_inicio', "O campo [conta_horas_inicio] está a aceitar nºs reais - só devia aceitar inteiros");
        $response->assertInvalid('conta_horas_inicio', "O campo [conta_horas_fim]  está a aceitar nºs reais - só devia aceitar inteiros");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }        

        $newdata = [
            "conta_horas_inicio" =>  -2,
            "conta_horas_fim" =>  -1,
        ];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('conta_horas_inicio', "O campo [conta_horas_inicio] está a aceitar valores negativos - só devia aceitar valores positivos");
        $response->assertInvalid('conta_horas_inicio', "O campo [conta_horas_fim] está a aceitar valores negativos - só devia aceitar valores positivos");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }   

        $newdata = [
            "conta_horas_inicio" =>  "232423",
            "conta_horas_fim" =>  "232422",
        ];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('conta_horas_fim', "O campo [conta_horas_fim] não pode ser menor que o campo conta_horas_inicio");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = [
            //"conta_horas_inicio" =>  "232422",
            "conta_horas_fim" =>  $this->movToSave["conta_horas_inicio"] + 23
        ];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('conta_horas_fim', 'Não aceita o valor de conta_horas_fim > conta_horas_inicio (devia aceitar)');
    }

    public function testValidacaoTempoVoo()
    {
        $newdata = ["tempo_voo" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('tempo_voo', "O campo [tempo_voo] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["tempo_voo" =>  "34.32"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('tempo_voo', "O campo [tempo_voo] aceita números reais (só devia aceitar inteiros)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["tempo_voo" =>  "-1"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('tempo_voo', "O campo [tempo_voo] aceita números negativos (só devia aceitar positivos)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["tempo_voo" =>  "80"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('tempo_voo', 'Não aceita o valor de tempo_voo = 80 (devia aceitar)');
    }    

    public function testValidacaoPrecoVoo()
    {
        $newdata = ["preco_voo" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('preco_voo', "O campo [preco_voo] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["preco_voo" =>  "-1"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('preco_voo', "O campo [preco_voo] aceita números negativos (só devia aceitar positivos)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["preco_voo" =>  "124.5"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('preco_voo', 'Não aceita o valor de preco_voo = 124.5 (devia aceitar)');
    }   

    public function testValidacaoModoPagamento()
    {
        $newdata = ["modo_pagamento" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('modo_pagamento', "O campo [modo_pagamento] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["modo_pagamento" =>  "B"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('modo_pagamento', "O campo [modo_pagamento] aceita um valor inválido (ex: B) - só deveria aceitar N, M, T ou P");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["modo_pagamento" =>  "N"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('modo_pagamento', 'Não aceita o valor de modo_pagamento = N (devia aceitar)');
    }    

    public function testValidacaoNumRecibo()
    {
        $newdata = ["num_recibo" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_recibo', "O campo [num_recibo] é obrigatório");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_recibo" =>  "123456789012345678901"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('num_recibo', "O campo [num_recibo] aceita valores com 21 caracteres (tamanho máximo deveria ser 20 caracteres)");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["num_recibo" =>  "12345678901234567890"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('num_recibo', 'Não aceita o valor de num_recibo = 12345678901234567890 (devia aceitar)');
    }

    public function testValidacaoTipoInstrucao()
    {
        $newdata = [
            "natureza" => "I",
            "tipo_instrucao" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('tipo_instrucao', "O campo [tipo_instrucao] é obrigatório se a natureza do voo for = I");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = [
            "natureza" => "I",
            "tipo_instrucao" =>  "A"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('tipo_instrucao', "O campo [tipo_instrucao] aceita um valor inválido (ex: A) quando a natureza do voo for = I - só deveria aceita D ou S");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = [
            "natureza" => "T",
            "tipo_instrucao" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('tipo_instrucao', 'Não aceita o valor de tipo_instrucao = NULL (devia aceitar quando a natureza do voo é diferente de I)');

        $newdata = [
            "natureza" => "I",
            "tipo_instrucao" =>  "D"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('tipo_instrucao', 'Não aceita o valor de tipo_instrucao = D (devia aceitar quando a natureza do voo é igual a I)');
    }

    public function testValidacaoInstrutorId()
    {
        $newdata = [
            "natureza" => "I",
            "instrutor_id" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('instrutor_id', "O campo [instrutor_id] é obrigatório se a natureza do voo for = I");
        if(array_key_exists("id", $this->movToSave)) {
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = [
            "natureza" => "T",
            "instrutor_id" =>  null];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('instrutor_id', 'Não aceita o valor de instrutor_id = NULL (devia aceitar quando a natureza do voo é diferente de I)');

        $newdata = ["instrutor_id" =>  "897328746"];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('instrutor_id', "O campo [instrutor_id] aceita valores que não existem na base de dados");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["instrutor_id" =>  $this->normalUser->id];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('instrutor_id', "O campo [instrutor_id] aceita um ID relativo a um sócio que não é piloto");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["instrutor_id" =>  $this->pilotoUser->id];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertInvalid('instrutor_id', "O campo [instrutor_id] aceita um ID relativo a um sócio que é piloto mas que não é instrutor");
        if(array_key_exists("id", $this->movToSave)) { 
            $this->assertDatabaseMissing('movimentos', array_merge(["id" => $this->movToSave["id"]], $newdata));    
        }

        $newdata = ["instrutor_id" =>  $this->pilotoInstrutorUser->id];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertValid('instrutor_id', 'Não aceita o valor de instrutor_id = ' . $this->pilotoInstrutorUser->id . ' (devia aceitar)');
    }
}

// Para verificar os mensagens de erro:
// dump(app('session.store')->get('errors'));


