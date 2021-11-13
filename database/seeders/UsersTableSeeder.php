<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //        DB::table('users')->insert([
//                'name' => 'sarahh',
//                'email' => 'sara@laravelmaset.com',
//                'email_verified_at' => now(),
//                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//                'remember_token' => Str::random(10),
//            ]);
        $users_count = max((int) $this->command->ask('How many users would you like to create?', 20), 1);
        \App\Models\User::factory()->saraName()->create();
        \App\Models\User::factory($users_count)->create();


    }
}
