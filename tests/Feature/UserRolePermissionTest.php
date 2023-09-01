<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
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
        ->post(route('admin.droits.users.roles', [$user, 'role' => RoleEnum::ADMINMETIER->value]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('dashboard');        
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t revoke a role to a user if not admin', function (RoleEnum $roleEnum) {
    $user = User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value);
    $role = Role::where('name', $roleEnum->value)->pluck('id');
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->delete(route('admin.droits.users.roles.revoke', [$user, $role[0]]))
        ->assertForbidden();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can revoke a role to a user if admin', function (RoleEnum $roleEnum) {
    $user = User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]);
    $role = Role::where('name', $roleEnum->value)->pluck('id');
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->delete(route('admin.droits.users.roles.revoke', [$user, $role[0]]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('dashboard');
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t assign a permission to a role if not admin', function (RoleEnum $roleEnum) {
    $role = Role::where('name', $roleEnum->value)->first();
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post(route('admin.droits.roles.permissions', [$role]))
        ->assertForbidden();
})
->with([
    RoleEnum::ADMINMETIER,
]);

it('can\'t assign a permission to a role if adminmetier', function (RoleEnum $roleEnum) {
    $role = Role::where('name', $roleEnum->value)->first();
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.roles.permissions', [$role]))
        ->assertForbidden();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can assign a permission to a role if admin', function (RoleEnum $roleEnum) {
    $role = Role::where('name', $roleEnum->value)->first();
    $permission = Permission::first()->pluck('name');
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.roles.permissions', ['permission' => $permission[0], $role]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('dashboard');
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t revoke a permission to a role if not admin', function (RoleEnum $roleEnum) {
    $role = Role::where('name', $roleEnum->value)->first();
    $permission = Permission::first()->pluck('id');
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->delete(route('admin.droits.roles.permissions.revoke', [$role, $permission[0]]))
        ->assertForbidden();
})
->with([
    RoleEnum::ADMINMETIER,
]);

it('can\'t revoke a permission to a role if adminmetier', function (RoleEnum $roleEnum) {
    $role = Role::where('name', $roleEnum->value)->first();
    $permission = Permission::first()->get();
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->delete(route('admin.droits.roles.permissions.revoke', [$role, $permission[0]]))
        ->assertForbidden();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can revoke a permission to a role if admin', function (RoleEnum $roleEnum) {
    $role = Role::where('name', $roleEnum->value)->first();
    $permission = Permission::first()->get();
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->delete(route('admin.droits.roles.permissions.revoke', [$permission[0], $role]))
        ->assertSessionHasNoErrors()
        ->assertRedirectToRoute('dashboard');
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t add role SUPER_ADMIN if not SUPER_ADMIN', function(RoleEnum $roleEnum) {

})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t add role ADMINDROITS if not SUPER_ADMIN or ADMINDROITS', function(RoleEnum $roleEnum) {

})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);
