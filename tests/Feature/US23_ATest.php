<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US23_ATest extends USTestBase
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDesativadoUser();
        $this->seedNormalUserComFoto();
        $this->seedSoftDeletedUser();
        $this->seedDirecaoUser();
        $this->userToSimulate = $this->direcaoUser;
    }

    public function testExisteRotaSocios()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
            ->assertStatus(200);
    }


    public function testTotalSociosParaDirecao()
    {
        $allNames = DB::table('users')->whereNull('deleted_at')->pluck('nome_informal');
        $total = count($allNames);        
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll($allNames, "A lista com os sócios não apresenta todos os sócios para a direção (deverá incluir os sócios não ativos). Nota: Podem ocorrer falhas se o tamanho das páginas for inferior a $total");
    }

    public function testTotalSociosParaUtilizadorNormal()
    {
        $allNames = DB::table('users')->whereNull('deleted_at')->where('ativo',0)->pluck('nome_informal');
        $total = count($allNames);
        $this->actingAs($this->normalUser)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll($allNames, "A lista com os sócios para um utilizador normal, inclui os desativados. Nota: Podem ocorrer falhas se o tamanho das páginas for inferior a $total");
    }

    public function testMostraInformacaoSocio()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser->num_socio,
                    $this->normalUser->nome_informal,
                    $this->normalUser->email,
                ], "A lista com os sócios não apresenta um sócio normal");
    }

    public function testMostraSocioDesativado()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->desativadoUser->num_socio,
                ], "A lista com os sócios para a direção não apresenta sócios desativados");
    }

    public function testMostraCamposIncluindoLicenca()
    {
        $this->seedPilotoUser();
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->pilotoUser->nome_informal,
                    $this->pilotoUser->email,
                    $this->pilotoUser->telefone,
                    $this->pilotoUser->num_socio,
                    $this->pilotoUser->num_licenca
                ], "A lista com os sócios não apresenta a informação do nº de licença dos pilotos");
    }

    public function testNaoMostraSocioDeleted()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "A lista com os sócios ativos apresenta um sócio que foi apagado com SoftDeleted");
    } 


    public function testMostraFotoSocio()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeInOrder_2(['<img', 'src=', $this->normalUserComFoto->foto_url],
            "A lista com os sócios ativos não apresenta fotografias");
    }       

    public function testIncluiLinkAbrirPerfil()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser->num_socio,
                    $this->normalUser->nome_informal,
                    $this->normalUser->email,
                ], "A lista com os sócios não apresenta um sócio normal")
                ->assertSeeInOrder_2(['<a', 'href=', "/socios/{$this->normalUser->id}/edit", '>'],
                    'A lista de sócios para a direção, tem que incluir uma hiperligação para abrir o perfil de qualquer utilizador');
    }

    public function testIncluiAtivarDesativarSocio()
    {
        $result = $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser->num_socio,
                    $this->normalUser->nome_informal,
                    $this->normalUser->email,
                ], "A lista com os sócios não apresenta um sócio normal")
                ->assertSeeInOrder_2(['<form', 'method="POST"', "/socios/{$this->normalUser->id}/ativo", '>',
                    '<input type="hidden" name="_method" value="patch">',
                    'name="ativo"',
                    '</form>'],
                    "Para o sócio 'normal com id = {$this->normalUser->id}' tem que incluir um formulário com o método POST / PATCH e [action] que acaba em /socios/{$this->normalUser->id}/ativo. O formulário deverá incluir o campo escondido 'ativo'");
    }

    public function testIncluiPagarQuotaSocio()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser->num_socio,
                    $this->normalUser->nome_informal,
                    $this->normalUser->email,
                ], "A lista com os sócios não apresenta um sócio normal")
                ->assertSeeInOrder_2(['<form', 'method="POST"', "/socios/{$this->normalUser->id}/quota", '>',
                    '<input type="hidden" name="_method" value="patch">',
                    'name="quota_paga"',
                    '</form>'],
                    "Para o sócio 'normal com id = {$this->normalUser->id}' tem que incluir um formulário com o método POST / PATCH e [action] que acaba em /socios/{$this->normalUser->id}/quota. O formulário deverá incluir o campo escondido 'quota_paga'");
    }
}


