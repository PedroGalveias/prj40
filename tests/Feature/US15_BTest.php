<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US15_BTest extends USTestBase
{
    protected $userToSimulate;
    protected $userToUpdate;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedPilotoUser();
        $this->userToSimulate = $this->pilotoUser;
        $this->userToUpdate = $this->pilotoUser;
    }

    public function testAlterarPerfilCamposPiloto()
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
            // campos que o piloto pode alterar
            "num_licenca" => "34DG2",         
            "tipo_licenca" => DB::table('tipos_licencas')->first()->code,
            "validade_licenca" => $this->format_date_input("2022-08-23"),
            "num_certificado" => "O9238R",
            "classe_certificado" => DB::table('classes_certificados')->first()->code,
            "validade_certificado" => $this->format_date_input("2022-08-23"),
        ];

        $requestData = array_merge($originalData, $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();
        $dbData = array_merge($newdata, [
            "data_nascimento" => $this->format_date_db($newdata["data_nascimento"]),
            "validade_licenca" => $this->format_date_db($newdata["validade_licenca"]),
            "validade_certificado" => $this->format_date_db($newdata["validade_certificado"]) ]);   

        $this->assertDatabaseHas('users', $dbData);
    }    

    public function testAlterarLicencaComoPilotoDeveColocarLicencaComoNaoConfirmada()
    {
        DB::table('users')->where('id', $this->pilotoUser->id)
                ->update(['licenca_confirmada' => true]);
        $originalData = $this->getRequestArrayFromUser($this->pilotoUser);
        $newdata = [
            "id" => $this->pilotoUser->id,
            "num_licenca" => "XD231",         
            "tipo_licenca" => DB::table('tipos_licencas')->first()->code,
            "validade_licenca" => $this->format_date_input("2022-08-15")
        ];

        $requestData = array_merge($originalData, $newdata);
        $this->actingAs($this->pilotoUser)->put('/socios/'. $this->pilotoUser->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();            
        $dbData = array_merge($newdata, [
            "validade_licenca" => $this->format_date_db($newdata["validade_licenca"]),
            "licenca_confirmada" => false ]);   

        $this->assertDatabaseHas('users', $dbData);
    }    

    public function testAlterarCertificadoComoPilotoDeveColocarCertificadoComoNaoConfirmado()
    {
        DB::table('users')->where('id', $this->pilotoUser->id)
                ->update(['certificado_confirmado' => true]);
        $originalData = $this->getRequestArrayFromUser($this->pilotoUser);
        $newdata = [
            "id" => $this->pilotoUser->id,
            "num_certificado" => "435323",
            "classe_certificado" => DB::table('classes_certificados')->first()->code,
            "validade_certificado" => $this->format_date_input("2022-08-13"),
        ];

        $requestData = array_merge($originalData, $newdata);
        $this->actingAs($this->pilotoUser)->put('/socios/'. $this->pilotoUser->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect();            
        $dbData = array_merge($newdata, [
            "validade_certificado" => $this->format_date_db($newdata["validade_certificado"]),
            "certificado_confirmado" => false ]);   

        $this->assertDatabaseHas('users', $dbData);
    }    

}
