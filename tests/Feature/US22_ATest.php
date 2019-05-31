<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US22_ATest extends USTestBase
{
    protected $userToSimulate;
    protected $urlGet;
    protected $urlPut;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDirecaoUser();
        $this->seedAeronaves();        
        $this->urlGet = '/aeronaves/'. $this->aeronave->matricula.'/edit';
        $this->urlPut = '/aeronaves/'. $this->aeronave->matricula;
        $this->userToSimulate = $this->direcaoUser;
    }

    public function testEstruturaDadosAeronaveValoresMultiplos()
    {
        $response = $this->actingAs($this->userToSimulate)->get($this->urlGet);
        $response->assertStatus(200);
        $response->assertSeeInOrder_2(['<form', 'method="POST"', '/aeronaves/'. $this->aeronave->matricula],
            'Tem que incluir um formulário com o método POST e [action] que acaba em /aeronaves/'. $this->aeronave->matricula);
        $response->assertSeeAll([
                '<input type="hidden" name="_method" value="PUT">',
                '<input type="hidden" name="_token"',
                $this->aeronave->matricula
            ]);

        $response->assertSeeCount('precos[', 10, 'O formulário para alterar a aeronave deverá incluir 10 campos relativos ao preço (campo precos[])');
        $response->assertSeeCount('tempos[', 10, 'O formulário para alterar a aeronave deverá incluir 10 campos relativos ao tempo (campo tempos[])');
//        $response->assertPatternCount('/tempos\\[/', 10, 'O formulário para alterar a aeronave deverá incluir 10 campos relativos ao tempo (campo tempos[])');
    }


   // CONSIDERA-SE QUE O ARRAY PRECOS e TEMPOS:
   // têm 10 elementos com as chaves 1, 2, 3, 4, 5, 6, 7, 8, 9, 10.  (chave representa a unidade no conta-horas)
   public function testValidacaoPrecos()
    {        
        $request = $this->getRequestArrayFromAeronave($this->aeronave);
        $precos_original = $request["precos"];
        $request["precos"][3] = null;
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('precos.3', 'Preços aceitam valores vazios!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 3,
            "preco" => null]);

        $request["precos"] = $precos_original;
        $request["precos"][1] = "X2";
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('precos.1', 'Preços aceitam valores não númericos (exemplo: X2)!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 1,
            "preco" => "X2"]);

        $request["precos"] = $precos_original;
        $request["precos"][10] = "12,23";
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('precos.10', 'Preços aceitam valores númericos com formato inválido (exemplo: 12,23)!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 10,
            "preco" => "12,23"]);

        $request["precos"] = $precos_original;
        $request["precos"][8] = -1;
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('precos.8', 'Preços aceitam valores negativos  (exemplo: -1)!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 8,
            "preco" => -1]);

        $request["precos"] = $precos_original;
        $request["precos"][2] = "24.5";
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertValid('precos.2', 'Preços não aceitam valores válidos (exemplo: 24.5)!');

    }    

   public function testValidacaoTempos()
    {        
        $request = $this->getRequestArrayFromAeronave($this->aeronave);
        $tempos_original = $request["tempos"];
        $request["tempos"][3] = null;
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('tempos.3', 'Tempos aceitam valores vazios!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 3,
            "minutos" => null]);

        $request["tempos"] = $tempos_original;
        $request["tempos"][1] = "Z3";
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('tempos.1', 'Tempos aceitam valores não inteiros (exemplo: Z3)!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 1,
            "minutos" => "Z3"]);

        $request["tempos"] = $tempos_original;
        $request["tempos"][10] = "12.23";
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('tempos.10', 'Tempos aceitam valores não inteiros (exemplo: 12.23)!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 10,
            "minutos" => "12.23"]);

        $request["tempos"] = $tempos_original;
        $request["tempos"][8] = -1;
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertInvalid('tempos.8', 'Tempos aceitam valores negativos  (exemplo: -1)!');
        $this->assertDatabaseMissing('aeronaves_valores', [
            "matricula" => $this->aeronave->matricula,
            "unidade_conta_horas" => 8,
            "minutos" => -1]);

        $request["tempos"] = $tempos_original;
        $request["tempos"][2] = "12";
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $request)
            ->assertValid('tempos.2', 'Tempos não aceitam valores válidos (exemplo: 12)!');
    }    
}
