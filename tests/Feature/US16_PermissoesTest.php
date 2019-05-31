<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US16_PermissoesTest extends USTestBase
{
    protected $userToSimulate;
    protected $movToSave;   
    protected $insertMov;    
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedPilotoUser();
        $this->seedPilotoInstrutorUser();
        $this->seedPilotoAlunoUser();
        $this->seedPilotoDesativadoUser();
        $this->seedEmailNaoVerificadoUser();
        $this->seedPasswordInicialUser();
        $this->seedNormalMovimentos($this->pilotoUser->id);
        $this->updateMovimento_confirmado($this->normalMovimento->id, 0);
        $this->normalMovimento->confirmado = 0;
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
        if ($simulateUser) {
            if ($this->insertMov) {
                return $this->actingAs($simulateUser)->post('/movimentos', $requestData);
            } else {
                return $this->actingAs($simulateUser)->put('/movimentos/'. $this->movToSave["id"], $requestData);
            }            
        } else {
            if ($this->insertMov) {
                return $this->post('/movimentos', $requestData);
            } else {
                return $this->put('/movimentos/'. $this->movToSave["id"], $requestData);
            }            
        }
    }

    public function testProtegeCriarOuAlterarMovimentoComoAnonimo()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "23431224"]);
        $response = $this->makeRequest($requestData, null);
        $response->assertUnauthorized('POST', "/movimentos", 'Utilizador anónimo está autorizado a criar ou alterar movimentos (não devia ter acesso a essa funcionalidade)');
    }

    public function testProtegeCriarOuAlterarMovimentoComoUserNormal()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "3123232"]);
        $response = $this->makeRequest($requestData, $this->normalUser);
        $response->assertUnauthorized('POST', "/movimentos", 'Sócio normal (não piloto) está autorizado a criar ou alterar movimentos (não devia ter acesso a essa funcionalidade)');
    }

    public function testProtegeCriarOuAlterarMovimentoComoPilotoDesativado()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "65342335"]);
        $response = $this->makeRequest($requestData, $this->pilotoDesativadoUser);
        $response->assertUnauthorized('POST', "/movimentos", 'Sócio piloto desativado está autorizado a criar ou alterar movimentos (não devia ter acesso a essa funcionalidade)');
    }

    public function testProtegeCriarOuAlterarMovimentoComoUserComoEmailNaoVerificadoUser()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "8765432"]);
        $response = $this->makeRequest($requestData, $this->emailNaoVerificadoUser);
        $response->assertUnauthorized('POST', "/movimentos", 'Sócio sem email varificado está autorizado a criar ou alterar movimentos (não devia ter acesso a essa funcionalidade)');
    }

    public function testProtegeCriarOuAlterarMovimentoComoUserComoPasswordInicialUser()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "87663465678"]);
        $response = $this->makeRequest($requestData, $this->passwordInicialUser);
        $response->assertUnauthorized('POST', "/movimentos", 'Sócio que ainda não alterou a password está autorizado a criar ou alterar movimentos (não devia ter acesso a essa funcionalidade)');
    }

    public function testCriarOuAlterarMovimentoComoPiloto()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "87663465678", "piloto_id" => $this->pilotoUser->id]);
        $response = $this->makeRequest($requestData, $this->pilotoUser);
        $response->assertAuthorized('POST', "/movimentos", 'Piloto não está autorizado a criar ou alterar movimentos (devia ter acesso a essa funcionalidade)');
    }

    public function testCriarOuAlterarMovimentoComoDirecao()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "123452432", "piloto_id" => $this->pilotoUser->id]);
        $response = $this->makeRequest($requestData, $this->direcaoUser);
        $response->assertAuthorized('POST', "/movimentos", 'Elemento da direção não está autorizado a criar ou alterar movimentos (devia ter acesso a essa funcionalidade)');
    }

}
