<?php

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
        $password = 'yoga1234';
        \App\Models\User::query()->create([
            'id' => Webpatser\Uuid\Uuid::generate(4),
            'name' => 'Yoga Revy Setiadi',
            'email' => 'yoga@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'status' => 1,
            'is_admin' => 1
        ]);
    }
}
