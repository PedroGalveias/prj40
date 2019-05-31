<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US17_PermissoesTest extends US16_PermissoesTest
{
    protected $userToSimulate;
    protected $movToSave;   
    protected $insertMov;    
    protected function setUp(): void
    {
        parent::setUp();
        $this->insertMov = false;
        $this->movToSave = $this->getRequestArrayFromMovimento($this->normalMovimento);     
    }

    public function testUpdateMovimentoComoPiloto()
    {
        $requestData = array_merge($this->movToSave, ["num_recibo" => "6675432323"]);
        $response = $this->makeRequest($requestData, $this->pilotoInstrutorUser);
        $response->assertUnauthorized('POST', "/movimentos", 'Piloto está autorizado a alterar movimentos de outros pilotos (não devia ter acesso a essa funcionalidade)');
    }
}
