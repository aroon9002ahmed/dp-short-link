<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Developer',
            'email' => 'developer@dubaiphone.net',
            'password' => bcrypt('password'),
        ]);

        //give this user a super_admin role
        $user = \App\Models\User::where('email', 'developer@dubaiphone.net')->first();
        $user->assignRole('super_admin');
    }
}
