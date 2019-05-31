<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US24_BTest extends USTestBase
{
    protected $userToSimulate;
    protected $userToUpdate;
    protected function setUp(): void 
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedPilotoUser();
        $this->userToSimulate = $this->direcaoUser;
        $this->userToUpdate = $this->normalUser;
    }    

    public function testAlterarPerfilSimplesComSucesso()
    {
        $newdata = [
            "id" => $this->userToUpdate->id,
            "name" => "Novo Nome Para Normal User",
            "nome_informal" => "Novo Informal 123",
            "email" => "xptxxop@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
            "nif" => "999999999",
            "telefone" => "999999999",
            "endereco" => "Rua para testes",
        ];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();
        $dbData = array_merge($newdata, ["data_nascimento" => $this->format_date_db($newdata["data_nascimento"]) ]);   
        $this->assertDatabaseHas('users', $dbData);
    }

    public function testAlterarPerfilSimplesSemCamposNullablesComSucesso()
    {
        $newdata = [
            "id" => $this->userToUpdate->id,
            "name" => "Novo Nome Para Normal User",
            "nome_informal" => "Novo Informal 123",
            "email" => "xptop@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
        ];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();
        $dbData = array_merge($newdata, ["data_nascimento" => $this->format_date_db($newdata["data_nascimento"]) ]);   
        $this->assertDatabaseHas('users', $dbData);
    }

    public function testAlterarPerfilComoDirecaoAlteraBaseDados()
    {
        $originalData = $this->getRequestArrayFromUser($this->userToUpdate);
        $newdata = [
            "id" => $this->userToUpdate->id,
            "name" => "Novo Nome Para Normal User",
            "nome_informal" => "Novo Informal 123",
            "email" => "xptop@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
            "nif" => "999999999",
            "telefone" => "999999999",
            "endereco" => "Rua para testes",
            "num_socio" => "9238473",         
            "ativo" => 0,
            "quota_paga" => 0,
            "sexo" => "F",
            "tipo_socio" => "P",
            "direcao" => 1,
            "instrutor" => 0,
            "aluno" => 0,
            "certificado_confirmado" => 1,
            "licenca_confirmada" => 1,
        ];

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();

        $dbData = array_merge($newdata, ["data_nascimento" => $this->format_date_db($newdata["data_nascimento"]) ]);   
        $this->assertDatabaseHas('users', $dbData);
    }    

    public function testAlterarPerfilPilotoComoDirecaoAlteraBaseDados()
    {
        $originalData = $this->getRequestArrayFromUser($this->pilotoUser);
        $newdata = [
            "id" => $this->pilotoUser->id,
            "name" => "Novo Nome Para Piloto User",
            "nome_informal" => "Novo Informal 123",
            "email" => "xptop@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
            "nif" => "999999999",
            "telefone" => "999999999",
            "endereco" => "Rua para testes",
            "num_socio" => "534231",         
            "ativo" => 1,
            "quota_paga" => 1,
            "sexo" => "F",
            "tipo_socio" => "P",
            "direcao" => 1,
            "instrutor" => 0,
            "aluno" => 0,
            "certificado_confirmado" => 1,
            "licenca_confirmada" => 1,
            "num_licenca" => "23423",         
            "tipo_licenca" => "PPL(A)",
            "validade_licenca" => $this->format_date_input("2022-08-23"),
            "num_certificado" => "54332",
            "classe_certificado" => "Class 2",
            "validade_certificado" => $this->format_date_input("2022-08-23"),
        ];

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->put('/socios/'. $this->pilotoUser->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();            

        $dbData = array_merge($newdata, [
            "data_nascimento" => $this->format_date_db($newdata["data_nascimento"]),
            "validade_licenca" => $this->format_date_db($newdata["validade_licenca"]), 
            "validade_certificado" => $this->format_date_db($newdata["validade_certificado"]) 
        ]);   

        $this->assertDatabaseHas('users', $dbData);
    }    

    public function testCriarSocioComoDirecao()
    {
        $uniqueNum = 4780128;
        $originalData = $this->getRequestArrayFromUser($this->userToUpdate);
        $newdata = [
            "name" => "Novo Nome Para Normal User A",
            "nome_informal" => "Novo Informal " . $uniqueNum,
            "email" => $uniqueNum . "@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
            "nif" => "999999999",
            "telefone" => "999999999",
            "endereco" => "Rua para testes",
            "num_socio" => $uniqueNum,         
            "ativo" => 1,
            "quota_paga" => 1,
            "sexo" => "M",
            "tipo_socio" => "NP",
            "direcao" => 1,
            "instrutor" => 0,
            "aluno" => 0
        ];

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->post('/socios', $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();

        $dbData = array_merge($newdata, [
            "data_nascimento" => $this->format_date_db($newdata["data_nascimento"]) 
        ]);   

        // Remover ID da comparação - novo registo vai ter novo id
        unset($dbData["id"]);

        $this->assertDatabaseHas('users', $dbData);
    }    


    public function testCriarSocioPilotoComoDirecao()
    {
        $uniqueNum = 453948;
        $originalData = $this->getRequestArrayFromUser($this->pilotoUser);
        $newdata = [
            "name" => "Novo Nome Para Normal User B",
            "nome_informal" => "Novo Informal " . $uniqueNum,
            "email" => $uniqueNum . "@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
            "nif" => "999999999",
            "telefone" => "999999999",
            "endereco" => "Rua para testes",
            "num_socio" => $uniqueNum,         
            "ativo" => 1,
            "quota_paga" => 1,
            "sexo" => "M",
            "tipo_socio" => "P",
            "direcao" => 1,
            "instrutor" => 0,
            "aluno" => 0,
            "certificado_confirmado" => 1,
            "licenca_confirmada" => 1,
            "num_licenca" => $uniqueNum . " XS",         
            "tipo_licenca" => "PPL(A)",
            "validade_licenca" => $this->format_date_input("2022-08-23"),
            "num_certificado" => $uniqueNum . " CCX",
            "classe_certificado" => "Class 2",
            "validade_certificado" => $this->format_date_input("2022-08-23"),
        ];

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->post('/socios', $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();

        $dbData = array_merge($newdata, [
            "data_nascimento" => $this->format_date_db($newdata["data_nascimento"]), 
            "validade_licenca" => $this->format_date_db($newdata["validade_licenca"]), 
            "validade_certificado" => $this->format_date_db($newdata["validade_certificado"]) 
        ]);   
        $this->assertDatabaseHas('users', $dbData);
    } 

    public function testPasswordAoCriarSocio()
    {
        $uniqueNum = 56367889;
        $originalData = $this->getRequestArrayFromUser($this->userToUpdate);
        $newdata = [
            "name" => "Novo Nome Para Normal User C",
            "nome_informal" => "Novo Informal " . $uniqueNum,
            "email" => $uniqueNum . "@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
            "nif" => "999999999",
            "telefone" => "999999999",
            "endereco" => "Rua para testes",
            "num_socio" => $uniqueNum,         
            "ativo" => 1,
            "quota_paga" => 1,
            "sexo" => "M",
            "tipo_socio" => "NP",
            "direcao" => 1,
            "instrutor" => 0,
            "aluno" => 0
        ];

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->post('/socios', $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();

        $dbData = array_merge($newdata, [
            "data_nascimento" => $this->format_date_db($newdata["data_nascimento"]) 
        ]);   

        // Remover ID da comparação - novo registo vai ter novo id
        unset($dbData["id"]);

        $this->assertDatabaseHas('users', $dbData);

        $newUser = DB::table('users')->where('email', $dbData["email"])->first();
        $this->assertTrue($newUser->password_inicial == 1, 'O campo password_inicial de um novo sócio não é 1 (true) - e deveria ser');
        $this->assertTrue(password_verify("1965-08-23", $newUser->password), 'Password de um novo sócio não é igual à sua data de nascimento (ex: 1990-07-23)');
    }    

    public function testApagarSocioSemMovimentos()
    {
        $uniqueNum = 874804378;
        $originalData = $this->getRequestArrayFromUser($this->userToUpdate);
        $newdata = [
            "name" => "Novo Nome Para Normal User E",
            "nome_informal" => "Novo Informal " . $uniqueNum,
            "email" => $uniqueNum . "@nanaemail.pt",
            "data_nascimento" => $this->format_date_input("1965-08-23"),
            "nif" => "999999999",
            "telefone" => "999999999",
            "endereco" => "Rua para testes",
            "num_socio" => $uniqueNum,         
            "ativo" => 1,
            "quota_paga" => 1,
            "sexo" => "M",
            "tipo_socio" => "NP",
            "direcao" => 1,
            "instrutor" => 0,
            "aluno" => 0
        ];

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->post('/socios', $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();

        $dbData = array_merge($newdata, [
            "data_nascimento" => $this->format_date_db($newdata["data_nascimento"]) 
        ]);   

        // Remover ID da comparação - novo registo vai ter novo id
        unset($dbData["id"]);

        $this->assertDatabaseHas('users', $dbData);

        $newID = DB::table('users')->where('email', $dbData["email"])->first()->id;

        $this->actingAs($this->userToSimulate)
            ->delete('/socios/'. $newID)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();

        $this->assertDatabaseMissing('users', ["id" => $newID]);
    }    

    public function testApagarSocioComMovimentosSoftdeleted()
    {
        $user = DB::table('users')
            ->whereNull('users.deleted_at')
            ->join('movimentos', 'users.id', '=', 'movimentos.piloto_id')
            ->select('users.id')
            ->first();
        if ($user) {
            $this->actingAs($this->userToSimulate)
                ->delete('/socios/'. $user->id)
                ->assertAllValid()
                ->assertSuccessfulOrRedirect();

            $this->assertSoftDeleted('users', ["id" => $user->id]);
            DB::table('users')->where('id', $user->id)->update(['deleted_at' => null]);
        }
    }    
}
