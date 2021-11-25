<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function testHomePage()
   {
       $this->actingAs($this->user());
       $response = $this->get('home');
//       $response->assertSeeText('You are logged in!');
     $response->assertStatus(200);
    }
}

