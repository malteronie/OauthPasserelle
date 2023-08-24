<?php

namespace Database\Seeders;


use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('permissions')->count() === 0) {
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
            ]);
            //$permissions = Permission::pluck('name')->toArray();
            //dd($permissions);
            $role = Role::where('name', 'admindroits')->get();
            //$role->givePermissionTo(Permission::all());


            $permissions = DB::table('permissions')->insert([
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
            $permissions = Permission::where('name', 'like', '%users')->get();
            //dd($permissions);
            //Role::where('name', RoleEnum::ADMINMETIER->value)->givePermissionTo($permissions);
        } else {
            echo "\e[31La table permissions n'est pas vide.";
        }
    }
}
