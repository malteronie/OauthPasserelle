<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('permissions')->count() === 0)
        {
            DB::table('permissions')->insert([
                [
                    'name' => 'create_droits',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'read_droits',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'update_droits',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete_droits',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create_users',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'read_users',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'update_users',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete_users',
                    'guard_name' => 'web',
                ],
                ]);
        }
        else
        {
            echo "\e[31La table permissions n'est pas vide.";
        }
    }
}
