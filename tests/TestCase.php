<?php

namespace Tests;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $baseUrl = 'http://localhost/projects/web/12_laravel_course_for_beginners_and_intermediate_piotr_jura/mid_blog/public';
    protected function user(){
        return User::factory()->create();
    }

    protected function adminUser(){
        return User::factory()->adminUser()->create();
    }
}
