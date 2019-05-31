<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class US07_ATest extends USTestBase
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

    public function testValidacaoNome()
    {
        $newdata = ["name" => "Abc 123"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('name', 'Aceita números');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["name" => "Abc '#€$&/^|\\±"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('name', 'Aceita simbolos');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["name" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('name', 'Aceita valores vazios');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoNomeAceitaLetrasPortugues()
    {
        $newdata = ["name" => "Abc çÇ áÁéÉíÍóÓúÚ àÀèÈìÌòÒùÙ ãÃõÕ âÂêÊîÎôÔûÛ"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("data", "Não aceita letras do alfabeto 'Português' (por exemplo, á, ç ou ã)");
    }

    public function testValidacaoNomeInformal()
    {
        $newdata = ["nome_informal" => "1234567890123456789012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("nome_informal", "Não aceita nome_informal com 40 caracteres e com números (nome_informal deve aceitar número)");

        $newdata = ["nome_informal" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('nome_informal', 'Aceita valores vazios');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["nome_informal" => "1234567890123456789012345678901234567890Z"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('nome_informal');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoNif()
    {
        $newdata = ["nif" => "888888888"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("nif", "Não aceita NIF com 9 caracteres");

        $requestData = $this->getRequestArrayFromUser($this->userToUpdate);
        unset($requestData['nif']);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("nif", "Não aceita um pedido PUT (para alterar sócio) sem o campo 'nif' - devia aceitar");

        $newdata = ["nif" => "8888888889"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('nif', 'Aceita nif com mais do que 9 caracteres');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoTelefone()
    {
        $newdata = ["telefone" => "12345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("telefone", "Não aceita telefone com 20 caracteres");

        $requestData = $this->getRequestArrayFromUser($this->userToUpdate);
        unset($requestData['telefone']);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("telefone", "Não aceita um pedido PUT (para alterar sócio) sem o campo 'telefone' - devia aceitar");

        $newdata = ["telefone" => "012345678901234567890"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid("telefone", "Aceita telefone com mais do que 20 caracteres");
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));
    }

    public function testValidacaoEndereco()
    {
        $newdata = ["endereco" => "Rua para testes"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("endereco", "Não aceita endereço com texto simples");

        $newdata = ["endereco" => ""];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("endereco", "Não aceita o campo 'endereco' vazio (sem texto)");

        $requestData = $this->getRequestArrayFromUser($this->userToUpdate);
        unset($requestData['endereco']);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("endereco", "Não aceita um pedido PUT (para alterar sócio) sem o campo 'endereco' - devia aceitar");
    }

    public function testValidacaoEmail()
    {
        $newdata = ["email" => "xxxx"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('email', 'Aceita o email "xxxx"');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["email" => null];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('email', 'Aceita email vazio');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["email" => "asddsfgd@asas.pt"];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("email", "Não aceita e-mail válido (asddsfgd@asas.pt)");

        $newdata = ["email" => $this->normalUser2->email];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertInvalid('email', 'Email "'.$this->normalUser2->email.'" não é unico - já está a ser usado por outro sócio');
        $this->assertDatabaseMissing('users', array_merge(["id" => $this->userToUpdate->id], $newdata));

        $newdata = ["email" => $this->userToUpdate->email];
        $requestData = array_merge($this->getRequestArrayFromUser($this->userToUpdate), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertValid("email", 'Email "'.$this->userToUpdate->email.'" já estava a ser usado pelo próprio');
    }
}
