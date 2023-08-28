<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
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

        if (DB::table('model_has_roles')->count() === 0) {
            $user = User::first();
            $user->assignRole(RoleEnum::SUPER_ADMIN->value);
        } else {
            echo "\e[31La table model_has_roles n'est pas vide.";
        }
    }
}
