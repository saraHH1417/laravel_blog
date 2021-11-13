<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts_count = (int) $this->command->ask('How many users would you like to create?', 50);
        $all_users = User::all();

        BlogPost::factory($posts_count)->make()->each(function($post) use($all_users) {
            $post->user_id = $all_users->random()->id;
            $post->save();
        });

    }
}
