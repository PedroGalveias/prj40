<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US17_CTest extends USTestBase
{
    protected $userToSimulate;
    protected $movToDelete; 
    protected $movInstrucaoToDelete;  

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedPilotoUser();
        $this->seedPilotoInstrutorUser();
        $this->seedPilotoAlunoUser();
        $this->seedNormalMovimentos($this->pilotoUser->id);
        $this->seedInstrucaoMovimento($this->pilotoAlunoUser->id, $this->pilotoInstrutorUser->id);
        $this->updateMovimento_confirmado($this->normalMovimento->id, 0);
        $this->normalMovimento->confirmado = 0;
        $this->updateMovimento_confirmado($this->instrucaoMovimento->id, 0);
        $this->instrucaoMovimento->confirmado = 0;

        $this->userToSimulate = $this->pilotoUser;

        $this->movToDelete = $this->getRequestArrayFromMovimento($this->normalMovimento);     
        $this->movInstrucaoToDelete = $this->getRequestArrayFromMovimento($this->instrucaoMovimento);        
    }

    protected function makeRequest($requestData, $simulateUser = null)  
    {
        $simulateUser = $simulateUser ? $simulateUser : $this->userToSimulate;
        return $this->actingAs($simulateUser)->delete('/movimentos/'. $requestData["id"]);
    }

    public function testApagarMovimentoSimplesComSucesso()
    {
        $response = $this->makeRequest($this->movToDelete);
        $this->assertDatabaseMissing('movimentos', ["id" => $this->movToDelete["id"]]);
    }

    public function testApagarMovimentoSimplesFalhaSeOutroPiloto()
    {
        $response = $this->makeRequest($this->movToDelete, $this->pilotoInstrutorUser);
        $this->assertDatabaseHas('movimentos', ["id" => $this->movToDelete["id"]]);
    }

    public function testApagarMovimentoInstrucaoComSucesso()
    {
        if ($this->userToSimulate != $this->direcaoUser) {
            $response = $this->makeRequest($this->movInstrucaoToDelete, $this->pilotoAlunoUser);
        } else {
            $response = $this->makeRequest($this->movInstrucaoToDelete, $this->direcaoUser);
        }
        $this->assertDatabaseMissing('movimentos', ["id" => $this->movInstrucaoToDelete["id"]]);
    }

    public function testApagarMovimentoInstrucaoFalhaSeOutroPiloto()
    {
        $response = $this->makeRequest($this->movInstrucaoToDelete, $this->pilotoUser);
        $this->assertDatabaseHas('movimentos', ["id" => $this->movInstrucaoToDelete["id"]]);
    }
}
