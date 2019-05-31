<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US28_ATest extends US16_ATest
{
    protected $userToSimulate;
    protected $movToSave;   
    protected $insertMov;    
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDirecaoUser();
        $this->userToSimulate = $this->direcaoUser;
        $this->insertMov = false;
        $this->movToSave = $this->getRequestArrayFromMovimento($this->normalMovimento);     
    }

}
