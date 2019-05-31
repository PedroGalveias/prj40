<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class US21_BTest extends USTestBase
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

    public function testAlterarAeronaveSimplesComSucesso()
    {
        $newdata = [
            "matricula" => $this->aeronave->matricula,
            "marca" => "Nova Marca X",
            "modelo" => "Novo Modelo X",
            "num_lugares" => 6,
            "conta_horas" => 23001,
            "preco_hora" => 233.34
        ];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData);
        $this->assertDatabaseHas('aeronaves', $newdata);
    }

    public function testCriarAeronaveSimplesComSucesso()
    {
        $newdata = [
            "matricula" => "Z-NEW",
            "marca" => "Nova Marca ZZ",
            "modelo" => "Novo Modelo ZZ",
            "num_lugares" => 5,
            "conta_horas" => 8392,
            "preco_hora" => 129.99
        ];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData);
        $this->assertDatabaseHas('aeronaves', $newdata);
    }

    public function testApagarAeronaveComMovimentosComSoftdelete()
    {
        $matriculaToDelete = DB::table('movimentos')->first()->aeronave;
        DB::table('aeronaves')->where('matricula',$matriculaToDelete)->update(['deleted_at' => null]);
        $dataToDelete = [
            "matricula" => $matriculaToDelete
        ];        
        $this->actingAs($this->userToSimulate)->delete('/aeronaves/'. $matriculaToDelete);
        $this->assertSoftDeleted('aeronaves', $dataToDelete);
    }

    public function testApagarAeronaveSemMovimentosComSucesso()
    {
        $dataToDelete = [
            "matricula" => $this->aeronave->matricula
        ];        
        $this->actingAs($this->userToSimulate)->delete('/aeronaves/'. $this->aeronave->matricula);
        $this->assertDatabaseMissing('aeronaves', $dataToDelete);
    }
}
