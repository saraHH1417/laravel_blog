<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\BlogPost;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->paragraphs(5, true)
        ];
    }

    public function newTitle()
    {
        return $this->state([
            'title' => 'New Title'
        ]);
    }

}

