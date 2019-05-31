<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US20Test extends US12Test
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userToSimulate = $this->pilotoUser;
    }

    public function testMovimentosFilterMeusMovimentos()
    {
        $result = DB::table('movimentos')->where('piloto_id', $this->pilotoUser->id)->pluck('id')->toArray(); 
        $notResult = DB::table('movimentos')->whereNotIn('id', $result)->pluck('id')->toArray(); 

        $response = $this->actingAs($this->userToSimulate)->get('/movimentos?meus_movimentos=1')
                ->assertStatus(200);         
        if ($result) {
            $this->assertExistemTodosValores($response, $result, "O filtro 'meus_movimentos' da lista de movimentos não filtra corretamente (não mostra todos os meus movimentos)");
        }
        if ($notResult) {        
            $this->assertNaoExisteNenhumValor($response, $notResult, "O filtro 'meus_movimentos' da lista de movimentos não filtra corretamente (mostra movimentos de outros pilotos)");
        }
    }

}
