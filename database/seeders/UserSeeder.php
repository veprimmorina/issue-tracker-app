<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\Project;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Veprim Morina',
            'email' => 'veprim@morina.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'John Champion',
            'email' => 'john@champion.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'James Valde',
            'email' => 'james@valde.com',
            'password' => Hash::make('password'),
        ]);

        User::factory(10)->create();

        Project::create([
            'name' => 'Test Project',
            'description' => 'Project owned by Veprim',
            'user_id' => $user1->id,
        ]);
    }
}
