<?php

namespace Tests;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user(){
        return User::factory()->create();
    }

    protected function adminUser(){
        return User::factory()->adminUser()->create();
    }
}
