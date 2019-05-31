<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US08_ATest extends USTestBase
{
    protected $userToSimulate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDesativadoUser();
        $this->seedNormalUserComFoto();
        $this->seedSoftDeletedUser();
        $this->userToSimulate = $this->normalUser;
    }

    public function testExisteRotaSocios()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
            ->assertStatus(200);
    }


    public function testTotalSocios()
    {
        $allNames = DB::table('users')->whereNull('deleted_at')->where('ativo',1)->pluck('nome_informal');
        $total = count($allNames);
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll($allNames, "A lista com os sócios ativos não apresenta todos os sócios. Nota: Podem ocorrer falhas se o tamanho das páginas for inferior a $total");
    }

    public function testMostraInformacaoSocio()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->normalUser->num_socio,
                    $this->normalUser->nome_informal,
                    $this->normalUser->email
                ], "A lista com os sócios não apresenta um sócio normal");
    }

    public function testNaoMostraSocioDesativado()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll([
                    $this->desativadoUser->nome_informal,
                ], "A lista com os sócios ativos apresenta sócios desativados");
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
                ], "A lista com os sócios ativos não apresenta a informação do nº de licença dos pilotos");
    }

    public function testNaoMostraSocioDeleted()
    {
        $this->actingAs($this->userToSimulate)->get('/socios')
                ->assertStatus(200)
                ->assertDontSeeAll([
                    $this->softDeletedUser->nome_informal,
                ], "A lista com os sócios ativos apresenta um sócio que foi apagado com SoftDeleted");
    } 


    public function testMostraFotoSocioAtivo()
    {
        $response = $this->actingAs($this->userToSimulate)->get('/socios');
        $response->assertStatus(200);
        $response->assertSeeInOrder_2(['<img', 'src=', $this->normalUserComFoto->foto_url],
            "A lista com os sócios ativos não apresenta fotografias");
    }       
}
