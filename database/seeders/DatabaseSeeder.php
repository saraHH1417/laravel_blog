<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comments;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($this->command->confirm("Do you want to refresh database?" , 'yes')){
            $this->command->call('migrate:refresh');
            $this->command->info('Database has refreshed successfully.');
        }


        Cache::tags(['blog-posts'])->flush();
        $this->call([UsersTableSeeder::class ,
            BlogPostsTableSeeder::class ,
            CommentsTableSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
            ]);
    }
}
