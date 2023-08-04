<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->count() === 0) {
            DB::table('users')->insert([
                [
                    'login' => 'administrateur',
                    'email' => 'administrateur@application.com',
                    'password' => Hash::make('password'),
                    'active' => true,
                ],
            ]);
        } else {
            echo "\e[31La table users n'est pas vide.";
        }

        if (DB::table('role_has_permissions')->count() === 0) {
            DB::table('role_has_permissions')->insert([
                [
                    'permission_id' => 1,
                    'role_id' => 1,
                ],
                [
                    'permission_id' => 2,
                    'role_id' => 1,
                ],
                [
                    'permission_id' => 3,
                    'role_id' => 1,
                ],
                [
                    'permission_id' => 4,
                    'role_id' => 1,
                ],
                [
                    'permission_id' => 5,
                    'role_id' => 2,
                ],
                [
                    'permission_id' => 6,
                    'role_id' => 2,
                ],
                [
                    'permission_id' => 7,
                    'role_id' => 2,
                ],
                [
                    'permission_id' => 8,
                    'role_id' => 2,
                ],
            ]);
        } else {
            echo "\e[31La table role_has_permissions n'est pas vide.";
        }

        if (DB::table('model_has_roles')->count() === 0) {
            DB::table('model_has_roles')->insert([
                [
                    'role_id' => 1,
                    'model_type' => 'App\Models\User',
                    'model_id' => 1,
                ],
                [
                    'role_id' => 2,
                    'model_type' => 'App\Models\User',
                    'model_id' => 1,
                ],
            ]);
        } else {
            echo "\e[31La table model_has_roles n'est pas vide.";
        }
    }
}
