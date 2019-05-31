<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US07_BTest extends USTestBase
{
    protected $userToSimulate;
    protected $userToUpdate;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->userToSimulate = $this->normalUser;
        $this->userToUpdate = $this->normalUser;
    }    

    public function testAlterarPerfilSimplesComSucesso()
    {
        $newdata = [
            "id" => $this->userToUpdate->id,
            "name" => "Novo Nome Para Normal User",
            "nome_informal" => "Novo Informal 123",
            "email" => "xptop@nanaemail.pt",
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

    public function testAlterarPerfilComCamposNaoAutorizadosNaoAlteraBaseDados()
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
            // campos que não pode alterar (só elementos da direcao é que podem)
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

        //$dbUnchangedData = array com os dados da BD relativos aos campos que não podem ser alterados
        $dbUnchangedData = array_intersect_key($originalData, [
            // Chave dos elementos do array $originalData que serão copiados para o novo array
            // Valores não interessam (são usados os valores de $originalData)
            "id" => null,
            "num_socio" => null,
            "ativo" => null,
            "quota_paga" => null,
            "sexo" => null,
            "tipo_socio" => null,
            "direcao" => null,
            "instrutor" => null,
            "aluno" => null,
            "certificado_confirmado" => null,
            "licenca_confirmada" => null,
        ]);

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->put('/socios/'. $this->userToUpdate->id, $requestData);

        $this->assertDatabaseHas('users', $dbUnchangedData);
    }    

    public function testAlterarPerfilComCamposPilotoNaoAlteraBaseDados()
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
            // campos que não pode alterar (só pilotos é que podem)
            "num_licenca" => "34DG2",         
            "tipo_licenca" => "PPL(A)",
            "validade_licenca" => $this->format_date_input("2022-08-23"),
            "num_certificado" => "O9238R",
            "classe_certificado" => "Class 2",
            "validade_certificado" => $this->format_date_input("2022-08-23"),
        ];

        //$dbUnchangedData = array com os dados da BD relativos aos campos que não podem ser alterados
        $dbUnchangedData = array_intersect_key($originalData, [
            // Chave dos elementos do array $originalData que serão copiados para o novo array
            // Valores não interessam (são usados os valores de $originalData)
            "id" => null,
            "num_licenca" => null,
            "tipo_licenca" => null,
            "validade_licenca" => null,
            "num_certificado" => null,
            "classe_certificado" => null,
            "validade_certificado" => null,
        ]);

        $requestData = array_merge($originalData, $newdata);

        $this->actingAs($this->userToSimulate)
            ->put('/socios/'. $this->userToUpdate->id, $requestData);

        $this->assertDatabaseHas('users', $dbUnchangedData);
    }    
}
