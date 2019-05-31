<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US09Test extends USTestBase
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedPilotoUser();
        $this->seedDirecaoUser();
        $this->seedDesativadoUser();

        $this->seedSoftDeletedUser();

        $this->userToSimulate = $this->normalUser;
    }

    public function testExisteRotaSocios()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
            ->assertStatus(200);
    }

    public function testEstruturaDadosFormularioPesquisa()
    {
        $response = $this->actingAs($this->userToSimulate)->get("/socios");
        $response->assertStatus(200);
        $response->assertSeeInOrder_2(['<form', 'method="GET"', '/socios', '>'],
            'Tem que incluir um formulário com o método GET e [action] que acaba em /socios');
        $response->assertSeeInOrder_2(['<input', 'name="num_socio"', '>'],
                'Campo de pesquisa [num_socio] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="nome_informal"', '>'],
                'Campo de pesquisa [nome_informal] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="email"', '>'],
                'Campo de pesquisa [email] não incluido ou inválido');
        $response->assertSeeInOrder_2(['value="A"', 'Aeromodelista'],
                'Formulário de pesquisa não inclui a descrição dos tipos de sócios (Piloto, Não Piloto, Aeromodelista) - em vez de (P, NP e A)');
        $response->assertSeeInOrder_2(['value="P"', 'Piloto'],
                'Formulário de pesquisa não inclui a descrição dos tipos de sócios (Piloto, Não Piloto, Aeromodelista) - em vez de (P, NP e A)');
        $response->assertSeeInOrder_2(['value="NP"', 'Não Piloto'],
                'Formulário de pesquisa não inclui a descrição dos tipos de sócios (Piloto, Não Piloto, Aeromodelista) - em vez de (P, NP e A)');
        $response->assertSeeInOrder_2(['<', 'name="tipo"', '>'],
                'Campo de pesquisa [tipo] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<', 'name="direcao"', '>'],
                'Campo de pesquisa [direcao] não incluido ou inválido');
        if ($this->userToSimulate != $this->direcaoUser) {
            $response->assertDontSeeAll(['name="quotas_pagas"'],
                    'Campo de pesquisa [quotas_pagas] não deveria ser incluido para os utilizadores normais');            
        } else {
            $response->assertSeeAll(['name="quotas_pagas"'],
                    'Campo de pesquisa [quotas_pagas] deveria ser incluido para os utilizadores da direcao');            
        }
        if ($this->userToSimulate != $this->direcaoUser) {
            $response->assertDontSeeAll(['name="ativo"'],
                    'Campo de pesquisa [ativo] não deveria ser incluido para os utilizadores normais');
        } else {
            $response->assertSeeAll(['name="ativo"'],
                    'Campo de pesquisa [ativo] deveria ser incluido para os utilizadores da direcao');   
        }
    }


    public function testSociosFilterNumSocio()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?num_socio='.$this->normalUser2->num_socio)
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser2->num_socio,
                    $this->normalUser2->nome_informal,
                    $this->normalUser2->email
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (não mostra o sócio com o nº de sócio a filtrar)")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->pilotoUser->nome_informal,
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }

    public function testSociosFilterNomeInformal()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?nome_informal=ormal')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser2->num_socio,
                    $this->normalUser2->nome_informal,
                    $this->normalUser2->email
                ], "O filtro 'nome_informal' da lista de sócios não filtra corretamente (exemplo: não mostra os sócios cujo nome inclui 'ormal')")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'nome_informal' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->pilotoUser->nome_informal,
                ], "O filtro 'nome_informal' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }


    public function testSociosFilterEmail()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?email=mal2@user')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser2->num_socio,
                    $this->normalUser2->nome_informal,
                    $this->normalUser2->email
                ], "O filtro 'email' da lista de sócios não filtra corretamente (exemplo: não mostra os sócios cujo nome inclui 'mal2@user')")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'email' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->pilotoUser->nome_informal,
                ], "O filtro 'email' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }    

    public function testSociosTipo()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?tipo=P')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->pilotoUser->num_socio,
                    $this->pilotoUser->nome_informal,
                    $this->pilotoUser->email
                ], "O filtro 'tipo' da lista de sócios não filtra corretamente (exemplo: não mostra os sócios cujo tipo = 'P')")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'tipo' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->normalUser2->nome_informal,
                ], "O filtro 'tipo' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }  

    public function testSociosFilterDirecao()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?direcao=1')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->direcaoUser->num_socio,
                    $this->direcaoUser->nome_informal,
                    $this->direcaoUser->email
                ], "O filtro 'direcao' da lista de sócios não filtra corretamente (não mostra os sócios da direção)")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'direcao' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->pilotoUser->nome_informal,
                ], "O filtro 'direcao' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }

    public function testSociosFilterNumSocioNome()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?num_socio='.$this->normalUser2->num_socio.'&nome_informal=Name')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser2->num_socio,
                    $this->normalUser2->nome_informal,
                    $this->normalUser2->email
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (não mostra o sócio com o nº de sócio a filtrar)")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->pilotoUser->nome_informal,
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                
    }

    public function testSociosFilterNomeTipo()
    {
        $this->actingAs($this->userToSimulate)->get('/socios?nome_informal=ame&tipo=P&direcao=0')
            ->assertStatus(200)
                ->assertSeeAll([
                    $this->pilotoUser->num_socio,
                    $this->pilotoUser->nome_informal,
                    $this->pilotoUser->email
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (não mostra o sócio com o nº de sócio a filtrar)")
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)")
                ->assertDontSeeAll([
                    $this->normalUser2->nome_informal,
                ], "O filtro 'num_socio' da lista de sócios não filtra corretamente (está a mostrar sócios a mais)");                                
    }

}
