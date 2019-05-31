<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US10_ATest extends USTestBase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedAeronaves();
    }

    public function testExisteRotaAeronaves()
    {
        $this->actingAs($this->normalUser)->get('/aeronaves')
            ->assertStatus(200);
    }

    public function testTotalAeronaves()
    {
        $allMatriculas = DB::table('aeronaves')->whereNull('deleted_at')->pluck('matricula');
        $total = count($allMatriculas);
        $this->actingAs($this->normalUser)->get('/aeronaves')
                ->assertStatus(200)
                ->assertSeeAll($allMatriculas, "A lista de aeronaves não apresenta todas as aeronaves (total = $total)");        
    }


    public function testMostraCamposAeronave()
    {
        $this->actingAs($this->normalUser)->get('/aeronaves')
                ->assertStatus(200)
                ->assertSeeAll([
                    $this->aeronave->matricula,
                    $this->aeronave->marca,
                    $this->aeronave->modelo,
                    $this->aeronave->num_lugares,
                    (integer)$this->aeronave->preco_hora,
                ]);
        // Total de horas não é verificados, porque o formato pode (deve) ser ajustado.
        // Exemplo: 11 254,4 horas
        // O mesmo se aplica ao preço hora, mas como este não tem mais de 3 digitos, há sempre uma parte da string que é igual
        // Exemplo: 130 €
    }

    public function testNaoMostraAeronaveSoftdeleted()
    {
        $this->actingAs($this->normalUser)->get('/aeronaves')
                ->assertStatus(200)
                ->assertDontSeeAll([
                    $this->aeronaveDeleted->matricula
                ]);

    }
}
