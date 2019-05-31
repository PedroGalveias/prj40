<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US28_BTest extends US16_BTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->userToSimulate = $this->direcaoUser;
        $this->insertMov = false;
        $this->movToSave = $this->getRequestArrayFromMovimento($this->normalMovimento);     
        $this->movInstrucaoToSave = $this->getRequestArrayFromMovimento($this->instrucaoMovimento);        
    }

}
