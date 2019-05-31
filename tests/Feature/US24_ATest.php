<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class US24_ATest extends US07_ATest
{
    protected $userToSimulate;
    protected $userToUpdate;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDirecaoUser();
        $this->userToSimulate = $this->direcaoUser;
        $this->userToUpdate = $this->normalUser;
    }

    public function testValidacaoNumSocio()
    {
        $newdata = ["num_socio" => "xxxx"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('num_socio', 'Aceita o nº sócio inválido "xxxx"');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));


        $newdata = ["num_socio" => "-1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('num_socio', 'Aceita o nº sócio negativo "-1"');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["num_socio" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('num_socio', 'Aceita nº sócio vazio');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["num_socio" => "8374853"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("num_socio", "Não aceita nº sócio válido (8374853)");

        $newdata = ["num_socio" => $this->normalUser2->num_socio];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('num_socio', 'Nº sócio "'.$this->normalUser2->num_socio.'" não é unico - já está a ser usado por outro sócio');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["num_socio" => $this->userToUpdate->num_socio];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("num_socio", 'Não aceita Nº sócio "'.$this->userToUpdate->num_socio.'" que já era o nº de sócio do próprio');
    }


    public function testValidacaoSexo()
    {
        $newdata = ["sexo" => "M"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('sexo', 'Não aceita o valor de sexo = "M"');

        $newdata = ["sexo" => "F"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('sexo', 'Não aceita o valor de sexo = "F"');

        $newdata = ["sexo" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('sexo', "O campo [Sexo] é obrigatório");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["sexo" => "C"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('sexo', "Valor (C) inválido para o campo [Sexo]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoDataNascimento()
    {
        $newdata = ["data_nascimento" =>  $this->format_date_input("2020-10-20")];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('data_nascimento', "O campo [data_nascimento] tem que ser anterior à data de hoje");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["data_nascimento" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('data_nascimento', "O campo [data_nascimento] é obrigatório");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["data_nascimento" => "123"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('data_nascimento', "O campo [data_nascimento] não é uma data");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["data_nascimento" => "2-3-2000"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('data_nascimento', "O formato do campo [data_nascimento] é errado");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["data_nascimento" => $this->format_date_input("1999-09-20")];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('data_nascimento', 'Não aceita o valor de data_nascimento = ' . $this->format_date_input("1999-09-20"));
    }

    public function testValidacaoTipoSocio()
    {
        $newdata = ["tipo_socio" => "A"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('tipo_socio', 'Não aceita o valor de tipo_socio = "A"');

        $newdata = ["tipo_socio" => "P"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('tipo_socio', 'Não aceita o valor de tipo_socio = "P"');

        $newdata = ["tipo_socio" => "NP"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('tipo_socio', 'Não aceita o valor de tipo_socio = "NP"');

        $newdata = ["tipo_socio" => ""];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('tipo_socio', "O campo [tipo_socio] é obrigatório");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["tipo_socio" => "B"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('tipo_socio',  "Valor (B) inválido para o campo [tipo_socio]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoQuotaPaga()
    {
        $newdata = ["quota_paga" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('quota_paga', 'Não aceita o valor de quota_paga = "0"');

        $newdata = ["quota_paga" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('quota_paga', 'Não aceita o valor de quota_paga = "1"');

        $newdata = ["quota_paga" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('quota_paga', "O campo [quota_paga] é obrigatório");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["quota_paga" => "2"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('quota_paga', "Valor (2) inválido para o campo [quota_paga]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoAtivo()
    {
        $newdata = ["ativo" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('ativo', 'Não aceita o valor de ativo = "0"');

        $newdata = ["ativo" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('ativo', 'Não aceita o valor de ativo = "1"');

        $newdata = ["ativo" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('ativo', "O campo [ativo] é obrigatório");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["ativo" => "2"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('ativo', "Valor (2) inválido para o campo [ativo]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoDirecao()
    {
        $newdata = ["direcao" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('direcao', 'Não aceita o valor de direcao = "0"');

        $newdata = ["direcao" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('direcao', 'Não aceita o valor de direcao = "1"');

        $newdata = ["direcao" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('direcao', "O campo [direcao] é obrigatório");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["direcao" => "2"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('direcao', "Valor (2) inválido para o campo [direcao]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoLicencaConfirmada()
    {
        $newdata = ["licenca_confirmada" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('licenca_confirmada', 'Não aceita valor de licenca_confirmada = "0"');

        $newdata = ["licenca_confirmada" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('licenca_confirmada', 'Não aceita o valor de licenca_confirmada = "1"');

        $newdata = ["licenca_confirmada" => "2"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('licenca_confirmada', "Valor (2) inválido para o campo [licenca_confirmada]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoCertificadoConfirmado()
    {
        $newdata = ["certificado_confirmado" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('certificado_confirmado', 'Não aceita o valor de certificado_confirmado = "0"');

        $newdata = ["certificado_confirmado" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('certificado_confirmado', 'Não aceita o valor de certificado_confirmado = "1"');

        $newdata = ["certificado_confirmado" => "2"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('certificado_confirmado', "Valor (2) inválido para o campo [certificado_confirmado]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoNumLicenca()
    {
        $newdata = ["num_licenca" => "123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("num_licenca", "Não aceita num_licenca com 30 caracteres");

        $newdata = ["num_licenca" => "0123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid("num_licenca", "Aceita num_licenca com mais do que 30 caracteres");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoTipoLicenca()
    {
        $newdata = ["tipo_licenca" => "NEWTYPE"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("tipo_licenca", "Não aceita tipo_licenca com valor válido (NEWTYPE)");

        $newdata = ["tipo_licenca" => "XIBDAS"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid("tipo_licenca", "Aceita tipo_licenca inexistente na BD (XIBDAS)");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoNumCertificado()
    {
        $newdata = ["num_certificado" => "123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("num_certificado", "Não aceita num_certificado com 30 caracteres");

        $newdata = ["num_certificado" => "0123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid("num_certificado", "Aceita num_certificado com mais do que 30 caracteres");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoClasseCertificado()
    {
        $newdata = ["classe_certificado" => "NEWCLS"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("classe_certificado", "Não aceita classe_certificado com valor válido (NEWCLS)");

        $newdata = ["classe_certificado" => "KSWNFJS"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid("classe_certificado", "Aceita classe_certificado inexistente na BD (KSWNFJS)");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoValidadeLicenca()
    {
        $newdata = ["validade_licenca" => "123"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('validade_licenca', "O campo [validade_licenca] não é uma data");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["validade_licenca" => "2-3-2000"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('validade_licenca', "O formato do campo [validade_licenca] é errado");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["validade_licenca" => $this->format_date_input("2020-10-20")];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('validade_licenca', 'Não aceita o valor de validade_licenca = ' . $this->format_date_input("2020-10-20"));
    }

    public function testValidacaoValidadeCertificado()
    {
        $newdata = ["validade_certificado" => "123"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('validade_certificado', "O campo [validade_certificado] não é uma data");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["validade_certificado" => "2-3-2000"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('validade_certificado', "O formato do campo [validade_certificado] é errado");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["validade_certificado" => $this->format_date_input("2020-10-20")];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('validade_certificado', 'Não aceita o valor de validade_certificado = ' . $this->format_date_input("2020-10-20"));
    }

    public function testValidacaoAluno()
    {
        $newdata = ["aluno" => "0", "instrutor" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('aluno', 'Não aceita o valor de aluno = "0"');

        $newdata = ["aluno" => "1", "instrutor" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('aluno', 'Não aceita o valor de aluno = "1"');

        $newdata = ["aluno" => "2", "instrutor" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('aluno', "Valor (2) inválido para o campo [aluno]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["aluno" => "1", "instrutor" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('aluno', "Não é possível ser [aluno] e [instrutor] em simultâneo (aluno=1 e instrutor=1)");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoInstrutor()
    {
        $newdata = ["aluno" => "0", "instrutor" => "0"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('instrutor', 'Não aceita o valor de instrutor = "0"');

        $newdata = ["aluno" => "0", "instrutor" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid('instrutor', 'Não aceita o valor de instrutor = "1"');

        $newdata = ["aluno" => "0", "instrutor" => "2"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('instrutor', "Valor (2) inválido para o campo [instrutor]");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["aluno" => "1", "instrutor" => "1"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('instrutor', "Não é possível ser [aluno] e [instrutor] em simultâneo (aluno=1 e instrutor=1)");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }
}
