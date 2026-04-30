<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create super_admin role
        $superAdminRole = \Spatie\Permission\Models\Role::create(['name' => 'Super Admin']);

        //Create admin role
        $adminRole = \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
    }
}
