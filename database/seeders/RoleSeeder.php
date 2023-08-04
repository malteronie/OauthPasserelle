<?php

namespace Database\Seeders;

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
            DB::table('roles')->insert([
                [
                    'name' => 'admindroits',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'adminmetier',
                    'guard_name' => 'web',
                ],
            ]);
        } else {
            echo "\e[31La table roles n'est pas vide.";
        }
    }
}
