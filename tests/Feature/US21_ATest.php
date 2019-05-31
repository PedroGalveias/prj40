<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US21_ATest extends USTestBase
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

    public function testExisteEValidaRotaGetAeronaveEdit()
    {
        $this->actingAs($this->userToSimulate)->get($this->urlGet)
            ->assertSuccessfulOrRedirect();
        $this->actingAs($this->userToSimulate)->get('/aeronaves/'. $this->aeronaveDeleted->matricula.'/edit')
            ->assertStatus(404);
        $this->actingAs($this->userToSimulate)->get('/aeronaves/XK-SWQW34/edit')
            ->assertStatus(404);
    }


    public function testExisteEValidaRotaGetAeronaveCreate()
    {
        $this->actingAs($this->userToSimulate)->get("/aeronaves/create")
            ->assertSuccessfulOrRedirect();
    }

    public function testEstruturaDadosAeronaveEdit()
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
        $response->assertSeeInOrder_2(['<input', 'name="marca"', 'value="'. $this->aeronave->marca .'"', '>'],
                'Campo [marca] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="modelo"', 'value="'. $this->aeronave->modelo .'"', '>'],
                'Campo [modelo] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="num_lugares"', 'value="'. $this->aeronave->num_lugares .'"', '>'],
                'Campo [num_lugares] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="conta_horas"', 'value="'. $this->aeronave->conta_horas .'"', '>'],
                'Campo [conta_horas] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="preco_hora"', 'value="', (integer)$this->aeronave->preco_hora, '>'],
                'Campo [preco_hora] não incluido ou inválido');
    }

    public function testEstruturaDadosAeronaveCreate()
    {
        $response = $this->actingAs($this->userToSimulate)->get('/aeronaves/create');
        $response->assertStatus(200);
        $response->assertSeeInOrder_2(['<form', 'method="POST"', '/aeronaves', '>', '<input'],
            'Tem que incluir um formulário com o método POST e [action] que acaba em /aeronaves');
        $response->assertSeeAll([
                '<input type="hidden" name="_token"'
            ]);
        $response->assertSeeInOrder_2(['<input', 'name="marca"', '>'],
                'Campo [marca] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="modelo"', '>'],
                'Campo [modelo] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="num_lugares"', '>'],
                'Campo [num_lugares] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="conta_horas"', '>'],
                'Campo [conta_horas] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="preco_hora"', '>'],
                'Campo [preco_hora] não incluido ou inválido');
    }

    public function testValidacaoMatricula()
    {
        // Update
        $newdata = ["matricula" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('matricula', 'Update Aeronaves: aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', $newdata);

        $newdata = ["matricula" => "N12345678"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('matricula', 'Update Aeronaves: Matricula aceita valores com mais de 8 caracteres');
        $this->assertDatabaseMissing('aeronaves', $newdata);        

        // Create
        $newdata = ["matricula" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('matricula', 'Create Aeronaves: Aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', $newdata);

        $newdata = ["matricula" => "N12345678"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('matricula', 'Create Aeronaves: Matricula aceita valores com mais de 8 caracteres');
        $this->assertDatabaseMissing('aeronaves', $newdata);        
    }

    public function testMatriculaNaoPodeSerAlterada()
    {
        $newdata = ["matricula" => "CS-AZX"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData);
        $this->assertDatabaseMissing('aeronaves', $newdata);
    }

    public function testValidacaoMarca()
    {
        // Update
        $newdata = ["marca" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('marca', 'Update Aeronaves: Marca de Aeronave aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["marca" => "X1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('marca', 'Update Aeronaves: Marca de Aeronave aceita valores com mais de 40 caracteres');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["marca" => "1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertValid('marca', 'Update Aeronaves: Marca de Aeronave não aceita valor válido com 40 ou menos caracteres');

        // Create    
        $newdata = ["marca" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('marca', 'Create Aeronaves: Marca de Aeronave aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["marca" => "X1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('marca', 'Create Aeronaves: Marca de Aeronave aceita valores com mais de 40 caracteres');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["marca" => "1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertValid('marca', 'Create Aeronaves: Marca de Aeronave não aceita valor válido com 40 ou menos caracteres');
    }


    public function testValidacaoModelo()
    {
        // Update
        $newdata = ["modelo" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('modelo', 'Update Aeronaves: Modelo de Aeronave aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["modelo" => "X1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('modelo', 'Update Aeronaves: Modelo de Aeronave aceita valores com mais de 40 caracteres');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["modelo" => "1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertValid('modelo', 'Update Aeronaves: Modelo de Aeronave não aceita valor válido com 40 ou menos caracteres');

        // Create    
        $newdata = ["modelo" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('modelo', 'CreateAeronaves: Modelo de Aeronave aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["modelo" => "X1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('modelo', 'Create Aeronaves: Modelo de Aeronave aceita valores com mais de 40 caracteres');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["modelo" => "1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertValid('modelo', 'Create Aeronaves: Modelo de Aeronave não aceita valor válido com 40 ou menos caracteres');
    }

    public function testValidacaoNumLugares()
    {
        // Update
        $newdata = ["num_lugares" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('num_lugares', 'Update Aeronaves: Nº de lugares (num_lugares) aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "A1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('num_lugares', 'Update Aeronaves: Nº de lugares (num_lugares) aceita valores não inteiros (exemplo: A1)');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "12.23"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('num_lugares', 'Update Aeronaves: Nº de lugares (num_lugares) aceita valores não inteiros (exemplo: 12.23)');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "-1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('num_lugares', 'Update Aeronaves: Nº de lugares (num_lugares) aceita valores negativos  (exemplo: -1)');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "0"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('num_lugares', 'Update Aeronaves: Nº de lugares (num_lugares) aceita valor zero');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "4"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertValid('num_lugares', 'Update Aeronaves: Numero de lugares da Aeronave não aceita valor válido (exemplo: 4)');

        // Create
        $newdata = ["num_lugares" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('num_lugares', 'Create Aeronaves: Nº de lugares (num_lugares) aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "A1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('num_lugares', 'Create Aeronaves: Nº de lugares (num_lugares) aceita valores não inteiros (exemplo: A1)');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "12.23"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('num_lugares', 'Create Aeronaves: Nº de lugares (num_lugares) aceita valores não inteiros (exemplo: 12.23)');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "-1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('num_lugares', 'Create Aeronaves: Nº de lugares (num_lugares) aceita valores negativos  (exemplo: -1)');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "0"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('num_lugares', 'Create Aeronaves: Nº de lugares (num_lugares) aceita valor zero');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["num_lugares" => "4"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertValid('num_lugares', 'Create Aeronaves: Numero de lugares da Aeronave não aceita valor válido (exemplo: 4)');

    }

    public function testValidacaoContaHoras()
    {
        // Update
        $newdata = ["conta_horas" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('conta_horas', 'Update Aeronaves: Conta-horas aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "A1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('conta_horas', 'Update Aeronaves: Conta-horas aceita valores não inteiros');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "12.23"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('conta_horas', 'Update Aeronaves: Conta-horas aceita valores não inteiros');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "-1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('conta_horas', 'Update Aeronaves: Conta-horas aceita valores negativos');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "41233"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertValid('conta_horas', 'Update Aeronaves: Conta-Horas da Aeronave não aceita valor válido (exemplo: 41233)');

        // Create
        $newdata = ["conta_horas" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('conta_horas', 'Create Aeronaves: Conta-horas aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "A1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('conta_horas', 'Create Aeronaves: Conta-horas aceita valores não inteiros');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "12.23"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('conta_horas', 'Create Aeronaves: Conta-horas aceita valores não inteiros');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "-1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('conta_horas', 'Create Aeronaves: Conta-horas aceita valores negativos');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["conta_horas" => "41233"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertValid('conta_horas', 'Create Aeronaves: Conta-Horas da Aeronave não aceita valor válido (exemplo: 41233)');
    }

   public function testValidacaoPrecoHora()
    {
        // Update
        $newdata = ["preco_hora" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('preco_hora', 'Update Aeronaves: Aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["preco_hora" => "A1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('preco_hora', 'Update Aeronaves: Aceita valores não númericos');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["preco_hora" => "-1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertInvalid('preco_hora', 'Update Aeronaves: Aceita valores negativos');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["preco_hora" => "125.34"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->put($this->urlPut, $requestData)
            ->assertValid('preco_hora', 'Update Aeronaves: Preço/Hora da Aeronave não aceita valor válido (exemplo: 125.34)');


        // Create
        $newdata = ["preco_hora" => null];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('preco_hora', 'Create Aeronaves: Aceita valores vazios');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["preco_hora" => "A1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('preco_hora', 'Create Aeronaves: Aceita valores não númericos');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["preco_hora" => "-1"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertInvalid('preco_hora', 'Create Aeronaves: Aceita valores negativos');
        $this->assertDatabaseMissing('aeronaves', array_merge(["matricula" => $this->aeronave->matricula], $newdata));

        $newdata = ["preco_hora" => "125.34"];
        $requestData = array_merge($this->getRequestArrayFromAeronave($this->aeronave), $newdata);
        $this->actingAs($this->userToSimulate)->post('/aeronaves', $requestData)
            ->assertValid('preco_hora', 'Create Aeronaves: Preço/Hora da Aeronave não aceita valor válido (exemplo: 125.34)');
    }    
}
