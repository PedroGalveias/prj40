<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US06_PermissoesTest extends USTestBase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedDesativadoUser();
        $this->seedEmailNaoVerificadoUser();
    }

    public function testProtecaoGetSociosEditParaAnonimo()
    {
        $this->get("/socios/". $this->normalUser2->id.'/edit')
                ->assertUnauthorized('GET', "/socios/". $this->normalUser2->id.'/edit', 
                    'Anónimos conseguem ver dados de perfil de um sócio!');
    }

    public function testProtecaoGetSociosEditParaUserComEmailNaoVerificado()
    {
        $this->actingAs($this->emailNaoVerificadoUser)->get("/socios/". $this->emailNaoVerificadoUser->id.'/edit')
                ->assertUnauthorized('GET', "/socios/". $this->emailNaoVerificadoUser->id.'/edit',
                'Utilizador sem o e-mail verificado pode ver os seus dados de perfil!');
    }

    public function testProtecaoGetSociosEditParaParaSocioDesativado()
    {
        $this->actingAs($this->desativadoUser)->get("/socios/". $this->desativadoUser->id.'/edit')
                ->assertUnauthorized('GET', "/socios/". $this->desativadoUser->id.'/edit',
                'Utilizador desativado (ativo=0) pode ver os seus dados de perfil!');
    }

    public function testProtecaoGetSociosEditParaOutroSocio()
    {
        $this->actingAs($this->normalUser)->get("/socios/". $this->normalUser2->id.'/edit')
                ->assertUnauthorized('GET', "/socios/". $this->normalUser2->id.'/edit', 
                    'Sócios normais conseguem ver dados de perfil de outros sócios!');
    }

    public function testGetSociosEditAcessivelAoProprio()
    {
        $this->actingAs($this->normalUser)->get("/socios/". $this->normalUser->id.'/edit')
                ->assertAuthorized('GET', "/socios/". $this->normalUser->id.'/edit', 
                    'Um sócio não consegue ver os seus próprios dados de perfil!');
    }
}
