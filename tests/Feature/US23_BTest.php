<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US23_BTest extends US09Test
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedQuotaNaoPagaUser();
        $this->userToSimulate = $this->direcaoUser;
    }  

    public function testSociosQuotasPagas()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?quotas_pagas=0')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->semQuotaUser->num_socio,
                    $this->semQuotaUser->nome_informal,
                    $this->semQuotaUser->email
                ], "O filtro 'quotas_pagas' da lista de sócios não filtra corretamente (exemplo: não mostra os sócios sem as quotas pagas")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'quotas_pagas' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->normalUser2->nome_informal,
                ], "O filtro 'quotas_pagas' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }      

    public function testSociosAtivo()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?ativo=0')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->desativadoUser->num_socio,
                    $this->desativadoUser->nome_informal,
                    $this->desativadoUser->email
                ], "O filtro 'ativo' da lista de sócios não filtra corretamente (exemplo: não mostra os sócios desativados")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'ativo' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->normalUser2->nome_informal,
                ], "O filtro 'ativo' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }      
}


