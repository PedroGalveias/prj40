<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US15_ATest extends US07_ATest
{
    protected $userToSimulate;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedPilotoUser();
        $this->userToSimulate = $this->pilotoUser;
        $this->userToUpdate = $this->pilotoUser;
    }

    public function testValidacaoNumLicenca()
    {
        $newdata = ["num_licenca" => "1234567890123456789012345678901"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('num_licenca', 'Aceita um nº de licenca com mais de 30 caracteres');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->pilotoUser->id], $newdata));
    }

    public function testValidacaoTipoLicenca()
    {
        $newdata = ["tipo_licenca" => "ZZAZZZAZ"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('tipo_licenca', 'Aceita um tipo de licenca que não existe na base de dados');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["tipo_licenca" => DB::table('tipos_licencas')->first()->code];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('tipo_licenca', 'Não aceita um tipo de licenca que existe na base de dados');
    }

    public function testValidacaoValidadeLicenca()
    {
        $newdata = ["validade_licenca" => "123456"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('validade_licenca', 'A data de validade da licença aceita um formato inválido');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["validade_licenca" =>  $this->format_date_input("2022-08-23")];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('validade_licenca', 'A data de validade da licença não aceita um formato válido');
    }


    public function testValidacaoNumCertificado()
    {
        $newdata = ["num_certificado" => "1234567890123456789012345678901"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('num_certificado', 'Aceita um nº de certificado com mais de 30 caracteres');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoClasseCertificado()
    {
        $newdata = ["classe_certificado" => "ZZAZZZAZ"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('classe_certificado', 'Aceita uma classe de certificado médico que não existe na base de dados');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["classe_certificado" => DB::table('classes_certificados')->first()->code];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('classe_certificado', 'Não aceita uma classe de certificado médico que existe na base de dados');
    }


    public function testValidacaoValidadeCertificado()
    {
        $newdata = ["validade_certificado" => "123456"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('validade_certificado', 'A data de validade do certificado aceita um formato inválido');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["validade_certificado" =>  $this->format_date_input("2022-08-23")];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('validade_certificado', 'A data de validade do certificado não aceita um formato válido');
    }

}
