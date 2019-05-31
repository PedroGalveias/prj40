<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US12Test extends USTestBase
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedPilotoUser();
        $this->seedPilotoInstrutorUser();        
        $this->seedNormalMovimentos($this->pilotoUser->id);
        $this->seedInstrucaoMovimento($this->pilotoUser->id, $this->pilotoInstrutorUser->id);
        $this->userToSimulate = $this->normalUser;
    }

    private $_allMovs = null;
    private function AllMovs()
    {
        if (!$this->_allMovs) {
            $this->_allMovs = DB::table('movimentos')->pluck('id')->toArray(); 
        }
        return $this->_allMovs;
    }

    protected function assertExistemTodosValores($response, $valores, $msg) 
    {
        foreach ($valores as $v) {
            $response->assertSeeInOrder_2([ '<td', $v, '</td>'], $msg);
        }
    }      

    protected function assertNaoExisteNenhumValor($response, $valores, $msg) 
    {
        foreach ($valores as $v) {
            $response->assertDontSeeInOrder_2([ '<td', $v, '</td>'], $msg);
        }
    }      

    public function testExisteRotaMovimentos()
    {
        $this->actingAs($this->userToSimulate)->get('/movimentos')
            ->assertStatus(200);
    }

    public function testEstruturaDadosFormularioPesquisa()
    {
        $response = $this->actingAs($this->userToSimulate)->get("/movimentos");
        $response->assertStatus(200);
        $response->assertSeeInOrder_2(['<form', 'method="GET"', '/movimentos', '>'],
            'Tem que incluir um formulário com o método GET e [action] que acaba em /movimentos');

        $response->assertSeeInOrder_2(['<input', 'name="id"', '>'],
                'Campo de pesquisa [id] não incluido ou inválido');        
        $response->assertSeeInOrder_2(['<input', 'name="aeronave"', '>'],
                'Campo de pesquisa [aeronave] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="data_inf"', '>'],
                'Campo de pesquisa [data_inf] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="data_sup"', '>'],
                'Campo de pesquisa [data_sup] não incluido ou inválido');

        $response->assertSeeInOrder_2(['value="T"', 'Treino'],
                'Formulário de pesquisa não inclui a descrição da natureza do voo (Treino, Instrução, Especial) - em vez de (T, I e E)');
        $response->assertSeeInOrder_2(['value="I"', 'Instrução'],
                'Formulário de pesquisa não inclui a descrição da natureza do voo (Treino, Instrução, Especial) - em vez de (T, I e E)');
        $response->assertSeeInOrder_2(['value="E"', 'Especial'],
                'Formulário de pesquisa não inclui a descrição da natureza do voo (Treino, Instrução, Especial) - em vez de (T, I e E)');
        $response->assertSeeInOrder_2(['<', 'name="confirmado"', '>'],
                'Campo de pesquisa [confirmado] não incluido ou inválido');

        $response->assertSeeInOrder_2(['<', 'name="piloto"', '>'],
                'Campo de pesquisa [piloto] não incluido ou inválido');

        $response->assertSeeInOrder_2(['<', 'name="instrutor"', '>'],
                'Campo de pesquisa [instrutor] não incluido ou inválido');

        if ($this->userToSimulate->tipo_socio != "P") {
            $response->assertDontSeeInOrder_2(['<', 'name="meus_movimentos"', '>'],
                    'Campo de pesquisa [meus_movimentos] não deveria ser incluido para os utilizadores normais');            
        } else {
            $response->assertSeeInOrder_2(['<', 'name="meus_movimentos"', '>'],
                    'Campo de pesquisa [meus_movimentos] deveria ser incluido para os utilizadores pilotos');            
        }
    }


    public function testMovimentosFilterIdMovimento()
    {
        $result = DB::table('movimentos')->where('id',$this->normalMovimento2->id)->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 

        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?id=' . $this->normalMovimento2->id)
                ->assertStatus(200);         
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'id' da lista de movimentos não filtra corretamente (não mostra o id escolhido no filtro)");
        }
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'id' da lista de movimentos não filtra corretamente (mostra um id que não foi escolhido no filtro)");
        }
    }

    public function testMovimentosFilterAeronave()
    {
        $result = DB::table('movimentos')->where('aeronave','D-EAYV')->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?aeronave=D-EAYV')
                ->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'aeronaves' da lista de movimentos não filtra    corretamente (não mostra os movimentos da aeronave escolhida)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'aeronaves' da lista de movimentos não filtra corretamente (mostra movimentos de outras aeronaves)");
        }
    }

    public function testMovimentosFilterPiloto()
    {
        $result = DB::table('movimentos')->where('piloto_id', $this->pilotoUser->id)->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray();  
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?piloto='.$this->pilotoUser->id)
                ->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'piloto' da lista de movimentos não filtra    corretamente (não mostra os movimentos do piloto escolhido)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'piloto' da lista de movimentos não filtra corretamente (mostra movimentos de outros pilotos)");
        }
    }

    public function testMovimentosFilterInstrutor()
    {
        $result = DB::table('movimentos')->where('instrutor_id', $this->pilotoInstrutorUser->id)->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray();  
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?instrutor='.$this->pilotoInstrutorUser->id)
                ->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'instrutor' da lista de movimentos não filtra    corretamente (não mostra os movimentos do instrutor escolhido)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'instrutor' da lista de movimentos não filtra corretamente (mostra movimentos sem o instrutor escolhido)");
        }
    }

    public function testMovimentosFilterDataInf()
    {
        $this->updateMovimento_data($this->normalMovimento->id, "2028-11-20");
        $result = DB::table('movimentos')->where('data', '>=', "2027-11-20")->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?data_inf=' . $this->format_date_input('2027-11-20'))
                ->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'data_inf' da lista de movimentos não filtra    corretamente (não mostra os movimentos cuja data é superior à data_inf)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'data_inf' da lista de movimentos não filtra    corretamente (mostra movimentos cuja data é menor que a data_inf)");            
        }
    }

    public function testMovimentosFilterDataInfIgual()
    {
        $this->updateMovimento_data($this->normalMovimento->id, "2028-11-20");
        $result = DB::table('movimentos')->where('data', '>=', "2028-11-20")->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?data_inf=' . $this->format_date_input('2028-11-20'))
                ->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'data_inf' da lista de movimentos não filtra    corretamente (não mostra os movimentos cuja data é igual à data_inf - deve mostrar datas de movimentos iguais ou superiores à data_inf)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'data_inf' da lista de movimentos não filtra    corretamente (mostra movimentos cuja data é menor que a data_inf)");            
        }
    }

    public function testMovimentosFilterDataSup()
    {
        $this->updateMovimento_data($this->normalMovimento->id, "1935-11-20");
        $result = DB::table('movimentos')->where('data', '<=', "1936-11-20")->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?data_sup=' . $this->format_date_input('1936-11-20'))
                ->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'data_sup' da lista de movimentos não filtra    corretamente (não mostra os movimentos cuja data é inferior à data_sup)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'data_sup' da lista de movimentos não filtra    corretamente (mostra movimentos cuja data é maior que a data_sup)");  
        }
    }


    public function testMovimentosFilterDataSupIgual()
    {
        $this->updateMovimento_data($this->normalMovimento->id, "1935-11-20");
        $result = DB::table('movimentos')->where('data', '<=', "1935-11-20")->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?data_sup=' . $this->format_date_input('1935-11-20'))
                ->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'data_sup' da lista de movimentos não filtra    corretamente (não mostra os movimentos cuja data é igual à data_sup - deve mostrar datas de movimentos iguais ou inferiores à data_sup)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'data_sup' da lista de movimentos não filtra    corretamente (mostra movimentos cuja data é maior que a data_sup)");  
        }
    }

    public function testMovimentosFilterDuasDatas()
    {
        $this->updateMovimento_data($this->normalMovimento->id, "2028-11-20");
        $result = DB::table('movimentos')->where('data', '>=', "2027-11-20")->where('data', '<=', "2029-11-20")->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?data_inf=' . $this->format_date_input('2027-11-20') . '&data_sup=' . $this->format_date_input('2029-11-20'))->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'data_inf' conjugado com 'data_sup' da lista de movimentos não filtra corretamente (não mostra os movimentos de um intervalo)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'data_inf' conjugado com 'data_sup' da lista de movimentos não filtra corretamente (mostra movimentos cuja data não pertence ao intervalo)");            
        }
    }

    public function testMovimentosFilterDuasIguais()
    {
        $this->updateMovimento_data($this->normalMovimento->id, "2028-11-20");
        $result = DB::table('movimentos')->where('data', '>=', "2028-11-20")->where('data', '<=', "2028-11-20")->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?data_inf=' . $this->format_date_input('2028-11-20') . '&data_sup=' . $this->format_date_input('2028-11-20'))->assertStatus(200);   
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'data_inf' conjugado com 'data_sup' da lista de movimentos, quando ambos têm a mesma data, não filtra corretamente (não mostra os movimentos do intervalo - data unica)");            
        }              
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'data_inf' conjugado com 'data_sup' da lista de movimentos, quando ambos têm a mesma data, não filtra corretamente (mostra movimentos cuja data não pertence ao intervalo - data unica)");            
        }
    }

    public function testMovimentosFilterNatureza()
    {
        $result = DB::table('movimentos')->where('natureza', 'T')->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 

        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?natureza=T')
                ->assertStatus(200);         
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'natureza' da lista de movimentos não filtra corretamente (não mostra os movimentos da natureza escolhida no filtro)");
        }
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'natureza' da lista de movimentos não filtra corretamente (mostra os movimentos de outras naturezas)");
        }
    }


    public function testMovimentosFilterConfirmado()
    {
        $result = DB::table('movimentos')->where('confirmado', 1)->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 

        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?confirmado=1')
                ->assertStatus(200);         
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'confirmado' da lista de movimentos não filtra corretamente (não mostra os movimentos confirmados - valor confirmado = 1)");
        }
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'confirmado' da lista de movimentos não filtra corretamente (mostra os movimentos confirmados - valor confirmado = 1)");
        }
    }

    public function testMovimentosFilterConjugaVarios()
    {
        $result = DB::table('movimentos')
                    ->where('natureza', 'I')
                    ->where('piloto_id', $this->pilotoUser->id)
                    ->where('instrutor_id', $this->pilotoInstrutorUser->id)
                    ->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 

        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?natureza=I&piloto='.$this->pilotoUser->id.'&instrutor='.$this->pilotoInstrutorUser->id)
                ->assertStatus(200);         
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "A conjugacao dos filtros 'natureza', 'piloto' e 'instrutor' da lista de movimentos não filtra corretamente (não mostra os movimentos escolhidos no filtro)");
        }
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "A conjugacao dos filtros 'natureza', 'piloto' e 'instrutor' da lista de movimentos não filtra corretamente (mostra os movimentos não escolhidos no filtro)");
        }
    }    
}
