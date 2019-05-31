<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US16_BTest extends USTestBase
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
        $this->updateMovimento_confirmado($this->normalMovimento->id, 0);
        $this->normalMovimento->confirmado = 0;
        $this->updateMovimento_confirmado($this->instrucaoMovimento->id, 0);
        $this->instrucaoMovimento->confirmado = 0;

        $this->userToSimulate = $this->pilotoUser;
        $this->insertMov = true;

        $this->movToSave = $this->standardMovimentoComFormatoInput($this->pilotoUser->id);
        $this->movInstrucaoToSave = $this->instrucaoMovimentoComFormatoInput($this->pilotoAlunoUser->id, $this->pilotoInstrutorUser->id);

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

    public function testCriarOuAlterarMovimentoSimplesComSucesso()
    {
        $newdata = [
            "num_recibo" => "23431224",
            "observacoes" => "Teste XPTO",
            "conta_horas_fim" => $this->movToSave['conta_horas_inicio']+4
        ];
        $requestData = array_merge($this->movToSave, $newdata);

        $response = $this->makeRequest($requestData);
        $response->assertAllValid();
        $response->assertSuccessfulOrRedirect();
        $this->assertDatabaseHas('movimentos', $newdata);
    }

    public function testNaoPermiteCriarOuAlterarMovimentoComoOutroPiloto()
    {
        $newdata = [
            "num_recibo" => "645757456",
            "num_aterragens" => "4",
            "num_descolagens" => "4",
            "piloto_id" => $this->pilotoInstrutorUser->id
        ];
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData, $this->pilotoUser);
        $this->assertDatabaseMissing('movimentos', $newdata);
    }

    public function testCriarOuAlterarMovimentoPreencheInfoPilotoAutomaticamente()
    {
        $newdata = [
            "num_recibo" => "23431224",
            "observacoes" => "Teste XPTO",
            "conta_horas_fim" => $this->movToSave['conta_horas_inicio']+4,
            "piloto_id" => $this->pilotoUser->id,
        ];
        if (!$this->insertMov) {
            DB::table('movimentos')->where('id',$this->movToSave["id"])->update([
                "num_licenca_piloto" => "12",
                "num_certificado_piloto" => "13",
            ]);
        } else {
             $newdata["num_licenca_piloto"] = "12";
             $newdata["num_certificado_piloto"] = "13";
        }
        $requestData = array_merge($this->movToSave, $newdata);
        $response = $this->makeRequest($requestData);
        $response->assertAllValid();
        $response->assertSuccessfulOrRedirect();
        $infoPiloto = $this->getPilotInfo($this->pilotoUser->id);
        $dbData = array_merge($newdata, [
            "num_licenca_piloto" => $infoPiloto["num_licenca"],
            "validade_licenca_piloto" => $infoPiloto["validade_licenca"],
            "num_certificado_piloto" => $infoPiloto["num_certificado"],
            "classe_certificado_piloto" => $infoPiloto["classe_certificado"],
            "validade_certificado_piloto" => $infoPiloto["validade_certificado"],
        ]);   
        $this->assertDatabaseHas('movimentos', $dbData);
    }   

    public function testCriarOuAlterarMovimentoInstrucaoComSucesso()
    {        
        $newdata = [
            "num_recibo" => "4657698675",
            "observacoes" => "Teste XPTO sdsds",
            "conta_horas_fim" => $this->movInstrucaoToSave['conta_horas_inicio']+8,
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
        $response->assertAllValid();
        $response->assertSuccessfulOrRedirect();
        $this->assertDatabaseHas('movimentos', $newdata);
    }

    public function testNaoPermiteCriarOuAlterarMovimentoInstrucaoComoOutroPiloto()
    {
        // Transformar pilotoUser em aluno, só para o caso de alguem fazer essa validação 
        DB::table('users')->where('id', $this->pilotoUser->id)->update(['aluno'=>1]);
        $newdata = [
            "num_recibo" => "764545456",
            "observacoes" => "Teste XPTdfsdO sdsds",
            "conta_horas_fim" => $this->movInstrucaoToSave['conta_horas_inicio']+1,
            "natureza" => "I",
            "tipo_instrucao" => "D",
            "piloto_id" => $this->pilotoUser->id,
            "instrutor_id" => $this->pilotoInstrutorUser->id,
        ];
        $requestData = array_merge($this->movInstrucaoToSave, $newdata);
        $response = $this->makeRequest($requestData, $this->pilotoAlunoUser);
        $this->assertDatabaseMissing('movimentos', $newdata);
        DB::table('users')->where('id', $this->pilotoUser->id)->update(['aluno'=>0]);
    }

    public function testCriarOuAlterarMovimentoInstrucaoPreencheInfoPilotoAutomaticamente()
    {
        $newdata = [
            "num_recibo" => "67442356",
            "observacoes" => "fdgh hsfg ",
            "conta_horas_fim" => $this->movInstrucaoToSave['conta_horas_inicio']+6,
            "natureza" => "I",
            "tipo_instrucao" => "D",
            "piloto_id" => $this->pilotoAlunoUser->id, 
            "instrutor_id" => $this->pilotoInstrutorUser->id,
        ];
        if (!$this->insertMov) {
            DB::table('movimentos')->where('id',$this->movInstrucaoToSave["id"])->update([
                "num_licenca_piloto" => "12",
                "num_certificado_piloto" => "13",
                "num_licenca_instrutor" => "12",
                "num_certificado_instrutor" => "13",
            ]);
        } else {
             $newdata["num_licenca_piloto"] = "12";
             $newdata["num_certificado_piloto"] = "13";
             $newdata["num_licenca_instrutor"] = "12";
             $newdata["num_certificado_instrutor"] = "13";
        }        
        $requestData = array_merge($this->movInstrucaoToSave, $newdata);
        if ($this->userToSimulate != $this->direcaoUser) {
            $response = $this->makeRequest($requestData, $this->pilotoAlunoUser);
        } else {
            $response = $this->makeRequest($requestData, $this->direcaoUser);
        }
        $response->assertAllValid();
        $response->assertSuccessfulOrRedirect();
        $infoPiloto = $this->getPilotInfo($this->pilotoAlunoUser->id);
        $infoPilotoInstrutor = $this->getPilotInfo($this->pilotoInstrutorUser->id);
        $dbData = array_merge($newdata, [
            "num_licenca_piloto" => $infoPiloto["num_licenca"],
            "validade_licenca_piloto" => $infoPiloto["validade_licenca"],
            "num_certificado_piloto" => $infoPiloto["num_certificado"],
            "classe_certificado_piloto" => $infoPiloto["classe_certificado"],
            "validade_certificado_piloto" => $infoPiloto["validade_certificado"],
            "num_licenca_instrutor" => $infoPilotoInstrutor["num_licenca"],
            "validade_licenca_instrutor" => $infoPilotoInstrutor["validade_licenca"],
            "num_certificado_instrutor" => $infoPilotoInstrutor["num_certificado"],
            "classe_certificado_instrutor" => $infoPilotoInstrutor["classe_certificado"],
            "validade_certificado_instrutor" => $infoPilotoInstrutor["validade_certificado"],
        ]);       
        $this->assertDatabaseHas('movimentos', $dbData);
    }


}
