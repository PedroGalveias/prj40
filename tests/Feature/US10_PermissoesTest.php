<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US10_PermissoesTest extends USTestBase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDesativadoUser();
        $this->seedEmailNaoVerificadoUser();
    }

    public function testProtecaoGetAeronavesParaAnonimo()
    {
        $this->get('/aeronaves')
                ->assertUnauthorized('GET', '/aeronaves',
                'Utilizador anónimo pode ver a lista de aeronaves!');
    }

    public function testProtecaoGetAeronavesParaUserComEmailNaoVerificado()
    {
        $this->actingAs($this->emailNaoVerificadoUser)->get('/socios')
                ->assertUnauthorized('GET', '/aeronaves',
                'Utilizador sem o e-mail verificado pode ver a lista de aeronaves!');
    }

    public function testProtecaoGetAeronavesParaSocioDesativado()
    {
        $this->actingAs($this->desativadoUser)->get('/socios')
                ->assertUnauthorized('GET', '/aeronaves',
                'Utilizador desativado (ativo=0) pode ver a lista de aeronaves!');
    }
}
