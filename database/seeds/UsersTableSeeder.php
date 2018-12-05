<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'email' => 'test@octopuslabs.com',
            'name' => 'testuser',
            'api_token' => 'TkpJe8qr9hjbqPwCHi0n'
        ]);
    }
}