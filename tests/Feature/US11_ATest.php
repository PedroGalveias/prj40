<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US11_ATest extends USTestBase
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedPilotoUser();
        $this->seedNormalMovimentos($this->pilotoUser->id);
        $this->userToSimulate = $this->normalUser;
    }

    private function assertExistemTodosMovimentos($response, $movs, $msg) 
    {
        foreach ($movs as $m) {
            $response->assertSeeInOrder_2([ '<td', $m, '</td>'], $msg);
        }
    }  

    public function testExisteRotaMovimentos()
    {
        $this->actingAs($this->userToSimulate)->get('/movimentos')
            ->assertStatus(200);
    }

    public function testMostraInformacaoMovimento()
    {
        $this->actingAs($this->userToSimulate)->get('/movimentos')
                ->assertStatus(200)
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->id,
                    '</td>'
                ], "A lista com os movimentos não inclui o ID do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->aeronave,
                    '</td>'
                ], "A lista com os movimentos não inclui a matricula do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->format_date_input($this->normalMovimento->data),
                    '</td>'
                ], "A lista com os movimentos não inclui a data do movimento de testes (criado para efeitos de testes) - ou a data não tem o formato correto (".$this->format_date_input($this->normalMovimento->data).")")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->format_time_input($this->normalMovimento->hora_descolagem),
                    '</td>'
                ], "A lista com os movimentos não inclui a hora de descolagem do movimento de testes (criado para efeitos de testes) - ou a hora de descolagem não tem o formato correto (".$this->format_time_input($this->normalMovimento->hora_descolagem).")")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->format_time_input($this->normalMovimento->hora_aterragem),
                    '</td>'
                ], "A lista com os movimentos não inclui a hora de aterragem do movimento de testes (criado para efeitos de testes) - ou a hora de aterragem não tem o formato correto (".$this->format_time_input($this->normalMovimento->hora_aterragem).")")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->pilotoUser->nome_informal,
                    '</td>'
                ], "A lista com os movimentos não inclui o nome informal do piloto do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->aerodromo_partida,
                    '</td>'
                ], "A lista com os movimentos não inclui o código do aerodromo de partida do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->aerodromo_chegada,
                    '</td>'
                ], "A lista com os movimentos não inclui o código do aerodromo de chegada do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->num_aterragens,
                    '</td>'
                ], "A lista com os movimentos não inclui o nº de aterragens do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->num_descolagens,
                    '</td>'
                ], "A lista com os movimentos não inclui o nº de descolagens do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->num_diario,
                    '</td>'
                ], "A lista com os movimentos não inclui o nº do diário do movimento de testes (criado para efeitos de testes)")
                ->assertSeeInOrder_2([
                    '<td',
                    $this->normalMovimento->num_servico,
                    '</td>'
                ], "A lista com os movimentos não inclui o nº do serviço do movimento de testes (criado para efeitos de testes)");
                // Não foram verificados todos os campos
    }

    public function testTotalMovimentos()
    {
        $allIDs = DB::table('movimentos')->pluck('id')->toArray(); 
        $total = count($allIDs);       
        $response = $this->actingAs($this->userToSimulate)->get('/movimentos')
                ->assertStatus(200);
        $this->assertExistemTodosMovimentos($response, $allIDs, "A lista com todos os movimentos ativos não apresenta todos os ID de movimentos. Nota: Podem ocorrer falhas se o tamanho das páginas for inferior a $total");
    }


}
