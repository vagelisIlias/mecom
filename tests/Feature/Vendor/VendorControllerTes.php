<?php

namespace Tests\Feature\Vendor;

use Tests\TestCase;

class VendorControllerTes extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
