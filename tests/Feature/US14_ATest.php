<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class US14_ATest extends USTestBase
{
    protected $userToSimulate;


    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->seedDirecaoUser();
        $this->seedPilotoUser();
        $this->userToSimulate = $this->pilotoUser;
    }

    public function testExisteRotaGetSociosEdit()
    {
        $this->actingAs($this->pilotoUser)->get('/socios/'. $this->pilotoUser->id.'/edit')
            ->assertStatus(200);
        $this->actingAs($this->direcaoUser)->get("/socios/". $this->pilotoUser->id.'/edit')
            ->assertStatus(200);
    }

    public function testDadosPerfilPiloto()
    {
        $allTiposCode = DB::table('tipos_licencas')->pluck('code');
        $allClassesCode = DB::table('classes_certificados')->pluck('code');

        $response = $this->actingAs($this->userToSimulate)->get("/socios/". $this->pilotoUser->id.'/edit');
        $response->assertStatus(200);
        $response->assertSeeInOrder_2(['<form', 'method="POST"', '/socios/'. $this->pilotoUser->id, 'enctype="multipart/form-data"', '>'],
            'Tem que incluir um formulário com o método POST e [action] que acaba em /socios/'. $this->pilotoUser->id . ' e que permita fazer upload de ficheiros');
        $response->assertSeeAll([
                '<input type="hidden" name="_method" value="PUT">',
                '<input type="hidden" name="_token"',
                $this->pilotoUser->num_socio,
                $this->pilotoUser->sexo == 'M' ? 'Masculino' : 'Feminino',
                $this->pilotoUser->tipo_socio == 'P' ? 'Piloto' : ($this->pilotoUser->tipo_socio == 'NP' ? 'Não Piloto' : 'Aeromodelista')
            ]);
        $response->assertSeeInOrder_2(['<input', 'name="nome_informal"', 'value="'.$this->pilotoUser->nome_informal.'"', '>'],
                'Campo [nome_informal] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input',' name="name"', 'value="'.$this->pilotoUser->name.'"', '>'],
                'Campo [name] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input',' name="email"', 'value="'.$this->pilotoUser->email.'"', '>'],
                'Campo [email] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input',' name="nif"', 'value="'.$this->pilotoUser->nif.'"', '>'],
                'Campo [nif] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input',' name="telefone"', 'value="'.$this->pilotoUser->telefone.'"', '>'],
                'Campo [telefone] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input',' type="file"',' name="file_foto"', '>'],
                'Campo [file_foto] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<textarea', 'name="endereco"', '>', $this->pilotoUser->endereco, '</textarea>'],
                'Campo [endereco] não incluido ou inválido');
        $response->assertSeeInOrder_2(['<input', 'name="data_nascimento"', 'value="'.$this->format_date_input($this->pilotoUser->data_nascimento).'"', '>'],
                'Campo [data_nascimento] não incluido ou inválido');
        
        // Especificos do pilot (e da User Story 14)
        $response->assertSeeInOrder_2(['<input',' name="num_licenca"', 'value="'.$this->pilotoUser->num_licenca.'"', '>'],
                'Campo [num_licenca] não incluido ou inválido');
        $response->assertSeeInOrder_2(['name="tipo_licenca"', 'value="'.$this->pilotoUser->tipo_licenca.'"', '>'],
                'Campo [tipo_licenca] não incluido ou inválido');
        $response->assertSeeAll($allTiposCode, "No perfil do piloto não há nenhum campo que apresente a lista de valores possíveis para o tipo de licença, com os códigos (campo code) obtidos a partir da base de dados");
        $response->assertSeeInOrder_2(['<input', 'name="validade_licenca"', 'value="'.$this->format_date_input($this->pilotoUser->validade_licenca).'"', '>'],
                'Campo [validade_licenca] não incluido ou inválido');

        $response->assertSeeInOrder_2(['<input',' name="num_certificado"', 'value="'.$this->pilotoUser->num_certificado.'"'],
                'Campo [num_certificado] não incluido ou inválido');
        $response->assertSeeInOrder_2(['name="classe_certificado"', 'value="'.$this->pilotoUser->classe_certificado.'"'],
                'Campo [classe_certificado] não incluido ou inválido');
        $response->assertSeeAll($allClassesCode, "No perfil do piloto não há nenhum campo que apresente a lista de valores possíveis para a classe do certificado, com os códigos (campo code) obtidos a partir da base de dados");
        $response->assertSeeInOrder_2(['<input', 'name="validade_certificado"', 'value="'.$this->format_date_input($this->pilotoUser->validade_certificado).'"', '>'],
                'Campo [validade_certificado] não incluido ou inválido');
    }

    public function testPerfilPilotoReferenciasPdf()
    {     
        $this->createLicencaPDF($this->pilotoUser->id);
        $this->createCertificadoPDF($this->pilotoUser->id);
        try {
            $response = $this->actingAs($this->userToSimulate)->get("/socios/". $this->pilotoUser->id.'/edit');
            $response->assertStatus(200);
            $response->assertDontSeeAll(['licenca_'.$this->pilotoUser->id.'.pdf'],
                    'Referência para o ficheiro PDF com a licença de piloto utiliza diretamente o nome do ficheiro (deveria utilizar o URL "pilotos/'.$this->pilotoUser->id.'/licenca"');
            $response->assertDontSeeAll(['certificado_'.$this->pilotoUser->id.'.pdf'],
                    'Referência para o ficheiro PDF com o certificado médico do piloto utiliza diretamente o nome do ficheiro (deveria utilizar o URL "pilotos/'.$this->pilotoUser->id.'/certificado"');

            $response->assertSeeAll(['pilotos/'.$this->pilotoUser->id.'/licenca'],
                    'Referência para o ficheiro PDF com a licença do piloto não incluida ou inválida');
            $response->assertSeeAll(['pilotos/'.$this->pilotoUser->id.'/certificado'],
                    'Referência para o ficheiro PDF com o certificado médico do piloto não incluido ou inválido');
        } finally {
            $this->deleteLicencaPDF($this->pilotoUser->id);
            $this->deleteCertificadoPDF($this->pilotoUser->id);
        }
    }    

    public function testDownloadLicencaCertificadoPdf()
    {     
        $this->createLicencaPDF($this->pilotoUser->id);
        $this->createCertificadoPDF($this->pilotoUser->id);
        try {
            $response = $this->actingAs($this->userToSimulate)->get("pilotos/{$this->pilotoUser->id}/licenca");
            $response->assertStatus(200);
            $response->assertHeader('Content-Length', 3028);
            $response->assertHeader('Content-Type', 'application/pdf');

            $response = $this->actingAs($this->userToSimulate)->get("pilotos/{$this->pilotoUser->id}/certificado");
            $response->assertStatus(200);
            $response->assertHeader('Content-Length', 3028);
            $response->assertHeader('Content-Type', 'application/pdf');
        } finally {
            $this->deleteLicencaPDF($this->pilotoUser->id);
            $this->deleteCertificadoPDF($this->pilotoUser->id);
        }
    }    

}
