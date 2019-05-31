<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class US28_DTest extends US17_DTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->userToSimulate = $this->direcaoUser;
    }

}
