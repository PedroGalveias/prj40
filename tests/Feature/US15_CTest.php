<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US15_CTest extends USTestBase
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

    public function testAlterarPerfilUploadLicenca()
    {
        $originalData = $this->getRequestArrayFromUser($this->userToUpdate);
        $newdata = ["file_licenca" =>  UploadedFile::fake()->create('document.pdf', 4)];
        $requestData = array_merge($originalData, $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect()
           	->assertFileExists('docs_piloto/licenca_' . $this->userToUpdate->id . '.pdf', 'Após o upload da cópia digital da licença o ficheiro não existe no storage');
    }    

    public function testAlterarPerfilUploadCertificado()
    {
        $originalData = $this->getRequestArrayFromUser($this->userToUpdate);
        $newdata = ["file_certificado" =>  UploadedFile::fake()->create('document.pdf', 4)];
        $requestData = array_merge($originalData, $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect()
           	->assertFileExists('docs_piloto/certificado_' . $this->userToUpdate->id . '.pdf','Após o upload da cópia digital do certificado o ficheiro não existe no storage');
    }    

    public function testAlterarPerfilUploadLicencaCertificado()
    {
        $originalData = $this->getRequestArrayFromUser($this->userToUpdate);
        $newdata = [
        	"file_licenca" =>  UploadedFile::fake()->create('document.pdf', 4),
    		"file_certificado" =>  UploadedFile::fake()->create('document.pdf', 4)
    	];
        $requestData = array_merge($originalData, $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->userToUpdate->id, $requestData)
            ->assertAllValid()
            ->assertSuccessfulOrRedirect()
           	->assertFileExists('docs_piloto/licenca_' . $this->userToUpdate->id . '.pdf','Após o upload da cópia digital da licença o ficheiro não existe no storage')
           	->assertFileExists('docs_piloto/certificado_' . $this->userToUpdate->id . '.pdf','Após o upload da cópia digital do certificado o ficheiro não existe no storage');
    }  
}
