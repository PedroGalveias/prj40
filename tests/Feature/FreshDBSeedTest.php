<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FreshDBSeedTest extends USTestBase
{
    protected function setUp(): void
    {
        USTestBase::$forceSeedWithinTest = true;
        parent::setUp();
    }

   public function testRebuildInitialDataOnDataBase()
    {
	        $this->assertTrue(true);
    }
}
