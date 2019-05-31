<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class US21_PermissoesTest extends USTestBase
{
    protected $urlGet;
    protected $urlPut;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedPilotoUser();
        $this->seedEmailNaoVerificadoUser();
        $this->seedDesativadoUser();
        $this->seedDirecaoUser();
        $this->seedAeronaves();        
        $this->urlGet = '/aeronaves/'. $this->aeronave->matricula.'/edit';
        $this->urlPut = '/aeronaves/'. $this->aeronave->matricula;
    }

    private function checkUpdate($userToSimulate, $msgErro) 
    {
        $newdata = [
            "matricula" => $this->aeronave->matricula,
            "marca" => "Nova Marca X",
            "modelo" => "Novo Modelo X",
            "num_lugares" => 6,
            "conta_horas" => 23001,
            "preco_hora" => 233.34
        ];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        if ($userToSimulate) {
            $this->actingAs($userToSimulate)->put($this->urlPut, $requestData)
                ->assertUnauthorized('PUT', $this->urlPut, $msgErro);
        } else {
            $this->put($this->urlPut, $requestData)
                ->assertUnauthorized('PUT', $this->urlPut, $msgErro);
        }
    }

    private function checkInsert($userToSimulate, $msgErro) 
    {
        $newdata = [
            "matricula" => "X-NEW-Z",
            "marca" => "Nova Marca Z",
            "modelo" => "Novo Modelo Z",
            "num_lugares" => 4,
            "conta_horas" => 77001,
            "preco_hora" => 433.34
        ];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        if ($userToSimulate) {
            $this->actingAs($userToSimulate)->post("/aeronaves", $requestData)
                ->assertUnauthorized('POST', "/aeronaves", $msgErro);
        } else {
            $this->post("/aeronaves", $requestData)
                ->assertUnauthorized('POST', "/aeronaves", $msgErro);
        }
    }

    private function checkDelete($userToSimulate, $msgErro) 
    {
        $dataToDelete = [
            "matricula" => $this->aeronave->matricula
        ];        
        if ($userToSimulate) {
            $this->actingAs($userToSimulate)->delete('/aeronaves/'. $this->aeronave->matricula)
                ->assertUnauthorized('DELETE', '/aeronaves/'. $this->aeronave->matricula, $msgErro);
        } else {
            $this->delete('/aeronaves/'. $this->aeronave->matricula)
                ->assertUnauthorized('DELETE', '/aeronaves/'. $this->aeronave->matricula, $msgErro);
        }
    }

    public function testProtecaoUpdateAeronaveParaAnonimo()
    {
        $this->checkUpdate(null, 'Utilizador anónimo pode alterar uma aeronave!');
    }

    public function testProtecaoUpdateAeronaveParaUserNormal()
    {
        $this->checkUpdate($this->normalUser, 'Utilizador normal pode alterar uma aeronave!');
    }

    public function testProtecaoUpdateAeronaveParaPiloto()
    {
        $this->checkUpdate($this->pilotoUser, 'Utilizador piloto pode alterar uma aeronave!');
    }

    public function testProtecaoUpdateAeronaveParaDirecaoComEmailNaoVerificado()
    {
        $this->direcaoUser->email_verified_at = null;
        $this->direcaoUser->ativo = 1;
        $this->checkUpdate($this->direcaoUser, 'Utilizador da direcao com email não verificado pode alterar uma aeronave!');
    }

    public function testProtecaoUpdateAeronaveParaDirecaoDesativado()
    {
        $this->direcaoUser->email_verified_at = $this->direcaoUser->created_at;
        $this->direcaoUser->ativo = 0;
        $this->checkUpdate($this->direcaoUser, 'Utilizador da direcao desactivado pode alterar uma aeronave!');
    }


    public function testProtecaoCreateAeronaveParaAnonimo()
    {
        $this->checkInsert(null, 'Utilizador anónimo pode criar uma aeronave!');
    }

    public function testProtecaoCreateAeronaveParaUserNormal()
    {
        $this->checkInsert($this->normalUser, 'Utilizador normal pode criar uma aeronave!');
    }

    public function testProtecaoCreateAeronaveParaPiloto()
    {
        $this->checkInsert($this->pilotoUser, 'Utilizador piloto pode criar uma aeronave!');
    }

    public function testProtecaoCreateAeronaveParaDirecaoComEmailNaoVerificado()
    {
        $this->direcaoUser->email_verified_at = null;
        $this->direcaoUser->ativo = 1;
        $this->checkInsert($this->direcaoUser, 'Utilizador da direcao com email não verificado pode criar uma aeronave!');
    }

    public function testProtecaoCreateAeronaveParaDirecaoDesativado()
    {
        $this->direcaoUser->email_verified_at = $this->direcaoUser->created_at;
        $this->direcaoUser->ativo = 0;
        $this->checkInsert($this->direcaoUser, 'Utilizador da direcao desactivado pode criar uma aeronave!');
    }


    public function testProtecaoDeleteAeronaveParaAnonimo()
    {
        $this->checkDelete(null, 'Utilizador anónimo pode apagar uma aeronave!');
    }

    public function testProtecaoDeleteAeronaveParaUserNormal()
    {
        $this->checkDelete($this->normalUser, 'Utilizador normal pode apagar uma aeronave!');
    }

    public function testProtecaoDeleteAeronaveParaPiloto()
    {
        $this->checkDelete($this->pilotoUser, 'Utilizador piloto pode apagar uma aeronave!');
    }

    public function testProtecaoDeleteAeronaveParaDirecaoComEmailNaoVerificado()
    {
        $this->direcaoUser->email_verified_at = null;
        $this->direcaoUser->ativo = 1;
        $this->checkDelete($this->direcaoUser, 'Utilizador da direcao com email não verificado pode apagar uma aeronave!');
    }

    public function testProtecaoDeleteAeronaveParaDirecaoDesativado()
    {
        $this->direcaoUser->email_verified_at = $this->direcaoUser->created_at;
        $this->direcaoUser->ativo = 0;
        $this->checkDelete($this->direcaoUser, 'Utilizador da direcao desactivado pode apagar uma aeronave!');
    }


}
