<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US11_PermissoesTest extends USTestBase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDesativadoUser();
        $this->seedEmailNaoVerificadoUser();
    }

    public function testProtecaoMovimentosParaAnonimo()
    {
        $this->get('/movimentos')
                ->assertUnauthorized('GET', '/movimentos',
                'Utilizadores anónimos podem ver a lista de movimentos!');
    }

    public function testProtecaoMovimentosParaUserComEmailNaoVerificado()
    {
        $this->actingAs($this->emailNaoVerificadoUser)->get('/movimentos')
                ->assertUnauthorized('GET', '/movimentos',
                'Utilizador sem o e-mail verificado pode ver a lista de movimentos!');
    }

    public function testProtecaoMovimentosParaSocioDesativado()
    {
        $this->actingAs($this->desativadoUser)->get('/movimentos')
                ->assertUnauthorized('GET', '/movimentos',
                'Utilizador desativado (ativo=0) pode ver a lista de movimentos!');
    }
}
    
