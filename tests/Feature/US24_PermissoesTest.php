<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US24_PermissoesTest extends USTestBase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
    }


    public function testProtecaoAlterarSociosParaAnonimos()
    {
        $newdata = ["nome_informal" => "Valor Válido"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
        $this->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertUnauthorized('PUT', "/socios/". $this->normalUser->id, 'Anónimos conseguem alterar dados de perfil de um sócio!');
    }

    public function testProtecaoAlterarSociosParaOutroSocio()
    {
        $newdata = ["nome_informal" => "Valor Válido"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
        $this->actingAs($this->normalUser2)->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertUnauthorized('PUT', "/socios/". $this->normalUser->id, 'Sócios normais conseguem alterar dados de perfil de outro sócio!');
    }

    public function testProtecaoCriarSocio()
    {
        $uniqueNum = 3584943;
        $originalData = $this->getRequestArrayFromUser($this->normalUser);
        $newdata = [
            "name" => "Novo Nome Para Normal User XX",
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

        $this->actingAs($this->normalUser)
            ->post('/socios', $requestData)
            ->assertUnauthorized('POST', "/socios", 'Sócios normais conseguem criar novos sócios!');
    }



}
