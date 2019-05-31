<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class US22_BTest extends USTestBase
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

    public function testAlterarAeronaveValoresComSucesso()
    {
        $request = $this->getRequestArrayFromAeronave($this->aeronave);
        $newdata = [
            "matricula" => $this->aeronave->matricula,
            "marca" => "Nova Marca X",
            "modelo" => "Novo Modelo X",
            "num_lugares" => 6,
            "conta_horas" => 23001,
            "preco_hora" => 233.34
        ];
        $request["tempos"][8] = 52;
        $request["precos"][8] = 72;
        $requestData = array_merge($request, $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData);
        $this->assertDatabaseHas('aeronaves', $newdata);
        $this->assertDatabaseHas('aeronaves_valores', [
            'matricula' => $newdata['matricula'],
            'unidade_conta_horas' => 8,
            'minutos' => 52,
            'preco' => 72,
        ]);
        // Confirma se não gravou alterações em todos os valores da aeronave
        $this->assertDatabaseMissing('aeronaves_valores', [
            'matricula' => $newdata['matricula'],
            'unidade_conta_horas' => 3,
            'minutos' => 52,
            'preco' => 72,
        ]);
    }

    public function testCriarAeronaveValoresComSucesso()
    {
        $request = $this->getRequestArrayFromAeronave($this->aeronave);
        $newdata = [
            "matricula" => "Z-NEW-XX",
            "marca" => "Nova Marca ZZ",
            "modelo" => "Novo Modelo ZZ",
            "num_lugares" => 5,
            "conta_horas" => 8392,
            "preco_hora" => 83.99
        ];
        $request["tempos"][9] = 58;
        $request["precos"][9] = 78;
        $requestData = array_merge($request, $newdata);

        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData);
        $this->assertDatabaseHas('aeronaves', $newdata);
        $this->assertDatabaseHas('aeronaves_valores', [
            'matricula' => $newdata['matricula'],
            'unidade_conta_horas' => 9,
            'minutos' => 58,
            'preco' => 78,
        ]);
        // Confirma se não gravou alterações em todos os valores da aeronave
        $this->assertDatabaseMissing('aeronaves_valores', [
            'matricula' => $newdata['matricula'],
            'unidade_conta_horas' => 10,
            'minutos' => 58,
            'preco' => 78,
        ]);
    }
}
