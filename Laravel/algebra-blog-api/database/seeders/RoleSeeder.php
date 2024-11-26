<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'User'],
            ['name' => 'Author'],
            ['name' => 'Editor'],
        ];
        foreach ($roles as $role) {
            Role::updateOrCreate($role);
        }
    }
}
