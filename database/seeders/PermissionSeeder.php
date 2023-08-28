<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('permissions')->count() === 0) {
            Permission::create([
                'name' => 'create_droits',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINDROITS->value),
            );
            Permission::create([
                'name' => 'read_droits',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINDROITS->value),
            );
            Permission::create([
                'name' => 'update_droits',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINDROITS->value),
            );
            Permission::create([
                'name' => 'delete_droits',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINDROITS->value),
            );
            Permission::create([
                'name' => 'create_users',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINMETIER->value),
            );
            Permission::create([
                'name' => 'read_users',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINMETIER->value),
            );
            Permission::create([
                'name' => 'update_users',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINMETIER->value),
            );
            Permission::create([
                'name' => 'delete_users',
                'guard_name' => 'web',
            ])->assignRole(
                Role::firstWhere('name', RoleEnum::ADMINMETIER->value),
            );
        } else {
            echo "\e[31La table permissions n'est pas vide.";
        }
    }
}
