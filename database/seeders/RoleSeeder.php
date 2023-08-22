<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('roles')->count() === 0) {
            foreach (RoleEnum::cases() as $roleEnum) {
                Role::create([
                    'name' => $roleEnum->value,
                ]);
            }
        } else {
            echo "\e[31La table roles n'est pas vide.";
        }
    }
}
