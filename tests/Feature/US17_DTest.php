<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US17_DTest extends USTestBase
{
    protected $userToSimulate;
    protected $movToSave; 
    protected $movInstrucaoToSave;  
    protected $insertMov;    
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
        $this->updateMovimento_confirmado($this->normalMovimento->id, 1);
        $this->normalMovimento->confirmado = 1;
        $this->updateMovimento_confirmado($this->instrucaoMovimento->id, 1);
        $this->instrucaoMovimento->confirmado = 1;

        $this->userToSimulate = $this->pilotoUser;
        $this->insertMov = false;

        $this->movToSave = $this->getRequestArrayFromMovimento($this->normalMovimento);     
        $this->movInstrucaoToSave = $this->getRequestArrayFromMovimento($this->instrucaoMovimento);        

        //$this->movToSave["id"] = -1;
        //dump($this->movToSave);
        // Se $this->insertMov = False, então:
        //$this->movToSave = $this->getRequestArrayFromMovimento($this->normalMovimento);        
    }

    protected function makeRequest($requestData, $simulateUser = null)  
    {
        $simulateUser = $simulateUser ? $simulateUser : $this->userToSimulate;
        if ($this->insertMov) {
            return $this->actingAs($simulateUser)->post('/movimentos', $requestData);
        } else {
            return $this->actingAs($simulateUser)->put('/movimentos/'. $requestData["id"], $requestData);
        }
    }

    public function testAlterarMovimentoConfirmadoNaoAltera()
    {
        $newdata = [
            "num_recibo" => "23431224",
            "observacoes" => "Teste XPTO",
            "conta_horas_fim" => $this->movToSave['conta_horas_fim']+4
        ];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $this->assertDatabaseMissing('movimentos', $newdata);
    }

    public function testAlterarMovimentoInstrucaoConfirmadoNaoAltera()
    {        
        $newdata = [
            "num_recibo" => "4657698675",
            "observacoes" => "Teste XPTO sdsds",
            "conta_horas_fim" => $this->movInstrucaoToSave['conta_horas_fim']+8,
            "natureza" => "I",
            "tipo_instrucao" => "D",
            "piloto_id" => $this->pilotoAlunoUser->id, 
            "instrutor_id" => $this->pilotoInstrutorUser->id,
        ];
        $requestData = array_merge($this->movInstrucaoToSave, $newdata);
        if ($this->userToSimulate != $this->direcaoUser) {
            $response = $this->makeRequest($requestData, $this->pilotoAlunoUser);
        } else {
            $response = $this->makeRequest($requestData, $this->direcaoUser);
        }
        $this->assertDatabaseMissing('movimentos', $newdata);
    }

    public function testApagarMovimentoConfirmadoNaoApaga()
    {
        $response = $this->actingAs($this->userToSimulate)->delete('/movimentos/'. $this->movToSave["id"]);
        $this->assertDatabaseHas('movimentos', ["id" => $this->movToSave["id"]]);
    }

    public function testApagarMovimentoInstrucaoConfirmadoNaoApaga()
    {
        if ($this->userToSimulate != $this->direcaoUser) {
            $response = $this->actingAs($this->pilotoAlunoUser)->delete('/movimentos/'. $this->movInstrucaoToSave["id"]);
        } else {
            $response = $this->actingAs($this->direcaoUser)->delete('/movimentos/'. $this->movInstrucaoToSave["id"]);
        }
        $this->assertDatabaseHas('movimentos', ["id" => $this->movInstrucaoToSave["id"]]);
    }

}
