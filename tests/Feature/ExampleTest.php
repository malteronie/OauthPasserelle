<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\{actingAs};
use function Pest\Laravel\{get};

beforeEach(
    fn () => $this->seed(\Database\Seeders\DatabaseSeeder::class),
);

it('can\'t store a new user if not admin', function () {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post(route('admin.droits.users.store'),
            data: [
                'login' => fake()->name(),
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make(Str::password(12)),
            ]
        )->assertForbidden();
});

it('can store a new user if admin', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.users.store'),
            data: [
                'login' => fake()->name(),
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make(Str::password(12)),
            ]
        )->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t store a new role if user', function () {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post(route('admin.droits.roles.store'),
            data: [
                'name' => fake()->name(),
                'guard_name' => 'web',
            ]
        )->assertForbidden();
});

it('can\'t store a new role if adminmetier', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.roles.store'),
            data: [
                'name' => fake()->name(),
                'guard_name' => 'web',
            ]
        )->assertForbidden();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can store a new role if admin', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.roles.store'),
            data: [
                'name' => fake()->name(),
                'guard_name' => 'web',
            ]
        )->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t store a new permission if user', function () {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post(route('admin.droits.permissions.store'),
            data: [
                'name' => fake()->name(),
                'guard_name' => 'web',
            ]
        )->assertForbidden();
});

it('can\'t store a new permission if adminmetier', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.permissions.store'),
            data: [
                'name' => fake()->name(),
                'guard_name' => 'web',
            ]
        )->assertForbidden();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can store a new permission if admin', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.permissions.store'),
            data: [
                'name' => fake()->name(),
                'guard_name' => 'web',
            ]
        )->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t assign a role to a user if not admin', function () {
    actingAs($user = User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post(route('admin.droits.users.roles', $user))
        ->assertForbidden();
});

it('can assign a role to a user if admin', function (RoleEnum $roleEnum) {
    $user = User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]);
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.users.roles', $user))
        ->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t revoke a role to a user if not admin', function (RoleEnum $roleEnum) {
    actingAs($user = User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post(route('admin.droits.users.roles.revoke', [$user, $roleEnum]))
        ->assertForbidden();
})
    ->with([
        RoleEnum::ADMINDROITS,
    ]);

it('can revoke a role to a user if admin', function (RoleEnum $roleEnum) {
    $user = User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]);
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.users.roles.revoke', $user))
        ->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t assign a permission to a role if not admin', function () {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post(route('admin.droits.roles.permissions'))
        ->assertForbidden();
});

it('can\'t assign a permission to a role if adminmetier', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.roles.permissions'))
        ->assertOk();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can assign a permission to a role if admin', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.roles.permissions', Role::create(['name' => 'roletest', 'guard_name' => 'web'])))
        ->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::SUPER_ADMIN,
    ]);
