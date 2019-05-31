<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US28_PermissoesTest extends US16_PermissoesTest
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
}
