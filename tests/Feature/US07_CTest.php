<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US07_CTest extends USTestBase
{
    protected $userToSimulate;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedNormalUsers();
        $this->userToSimulate = $this->normalUser;
    }

    public function testValidacaoPhoto()
    {
        $newdata = ["file_foto" => UploadedFile::fake()->image('foto.jpg', 50, 50)->size(100)];
        $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertValid("file_foto", "Não aceita ficheiro upload (file_foto) com ficheiro de imagem válido");

        $newdata = ["file_foto" => UploadedFile::fake()->create('document.pdf', 4)];
        $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertInvalid('file_foto', "Aceita ficheiro upload (file_foto) sem um ficheiro de imagem válido");


        $requestData = $this->getRequestArrayFromUser($this->normalUser);
        unset($requestData['file_foto']); 
        $this->actingAs($this->userToSimulate)->put('/socios/'. $this->normalUser->id, $requestData)
            ->assertValid("file_foto", "Não aceita um pedido PUT (para alterar sócio) sem o campo 'file_foto' - devia aceitar");
    }


    public function checkUploadFoto()
    {
        try {
            $oldFotoUrl = DB::table('users')->where('id', $this->normalUser->id)->first()->foto_url;
            $newdata = ["file_foto" => UploadedFile::fake()->image('foto.jpg', 50, 50)->size(100)];
            $requestData = array_merge($this->getRequestArrayFromUser($this->normalUser), $newdata);
            $response = $this->actingAs($this->userToSimulate)->put('/socios/'. $this->normalUser->id, $requestData)
                ->assertAllValid()
                ->assertSuccessfulOrRedirect();
            $newFotoUrl = DB::table('users')->where('id', $this->normalUser->id)->first()->foto_url;
            $this->assertTrue($oldFotoUrl != $newFotoUrl, 'Após o upload da foto, o url da foto não foi alterado na Base de Dados');

            $response->assertFileExists("public/fotos/".$newFotoUrl,'Após o upload da foto o ficheiro não existe no storage');
            if ($oldFotoUrl) {
                $response->assertFileDoesNotExists("public/fotos/".$oldFotoUrl,'Após o upload da foto o ficheiro antigo não foi apagado do storage');
            }            
        } finally {
            $this->deletePhotoByName($newFotoUrl);
            $this->deletePhotoByName($oldFotoUrl);
        }
    }

    public function testUploadFotoPrimeiraVez()
    {
        $this->checkUploadFoto();
    }

    public function testUploadFotoAlteraFoto()
    {
        $name = $this->createPhoto($this->normalUser->id);
        try {
            $this->checkUploadFoto();
        } finally {
            $this->deletePhotoByName($name);
        }
    }    


}
