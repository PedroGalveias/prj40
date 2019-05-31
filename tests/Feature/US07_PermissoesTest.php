<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US07_PermissoesTest extends USTestBase
{
    protected $userToSimulate;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedDesativadoUser();
        $this->seedEmailNaoVerificadoUser();
        $this->userToSimulate = $this->normalUser;
    }


    public function testProtecaoAlterarSociosParaAnonimos()
    {
        $newdata = ["nome_informal" => "Valor Válido"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
        $this->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertUnauthorized('PUT', "/socios/". $this->normalUser->id, 'Anónimos conseguem alterar dados de perfil de um sócio!');
    }

    public function testProtecaoGetSociosEditParaUserComEmailNaoVerificado()
    {
        $newdata = ["nome_informal" => "Valor Válido"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->emailNaoVerificadoUser), $newdata);
        $this->actingAs($this->emailNaoVerificadoUser)->put('/socios/'. $this->emailNaoVerificadoUser->id, $requestData)
            ->assertUnauthorized('PUT', "/socios/". $this->emailNaoVerificadoUser->id, 'Utilizador sem o e-mail verificado consegue alterar os seus dados de perfil!');        
    }

    public function testProtecaoGetSociosEditParaParaSocioDesativado()
    {
        $newdata = ["nome_informal" => "Valor Válido"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->desativadoUser), $newdata);
        $this->actingAs($this->desativadoUser)->put('/socios/'. $this->desativadoUser->id, $requestData)
            ->assertUnauthorized('PUT', "/socios/". $this->desativadoUser->id, 'Utilizador desativado (ativo=0) consegue alterar os seus dados de perfil!');        
    }

    public function testProtecaoAlterarSociosParaOutroSocio()
    {
        $newdata = ["nome_informal" => "Valor Válido"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
        $this->actingAs($this->normalUser2)->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertUnauthorized('PUT', "/socios/". $this->normalUser->id, 'Sócios normais conseguem alterar dados de perfil de outro sócio!');
    }

    public function testProtecaoAlterarSocioAoProprio()
    {
        $newdata = ["nome_informal" => "Valor Válido"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
        $this->actingAs($this->normalUser)->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertAuthorized('PUT', "/socios/". $this->normalUser->id, 'Um sócio não consegue alterar os seus próprios dados de perfil!');
    }
}
