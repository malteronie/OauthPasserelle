<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Pest\Laravel\{actingAs};
use function Pest\Laravel\{get};

beforeEach(
    fn () => $this->seed(\Database\Seeders\DatabaseSeeder::class),
);

it('redirect to login page when anonymous', function () {
    get('/')->assertRedirect('/login');
});

it('redirect to home when authenticated users', function () {
    actingAs(User::factory()->create())->get('/login')
        ->assertRedirect('/');
});

it('has a waiting message when not activated', function () {
    actingAs($user = User::factory()->create(['password' => Hash::make(Str::password(12))]))->get('/')
        ->assertOk()
        ->assertSeeText($user->name)
        ->assertSeeText('pas encore activé');
});

it('redirects to dashboard if Socialite\'s auth', function () {

});

it('can\'t see users admin page if not admin', function () {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->get('/admin/droits/users')
        ->assertForbidden();
});

it('can see users admin page if admin', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->get('/admin/droits/users')
        ->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::ADMINMETIER,
        RoleEnum::SUPER_ADMIN,
    ]);
it('can\'t see roles admin page if not admin', function () {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->get('/admin/droits/roles')
        ->assertForbidden();
});

it('can\'t see roles admin page if adminmetier', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->get('/admin/droits/roles')
        ->assertForbidden();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can see roles admin page if admin', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->get('/admin/droits/roles')
        ->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::SUPER_ADMIN,
    ]);

it('can\'t see permissions admin page if not admin', function () {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->get('/admin/droits/permissions')
        ->assertForbidden();
});

it('can\'t see permissions admin page if adminmetier', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->get('/admin/droits/permissions')
        ->assertForbidden();
})
    ->with([
        RoleEnum::ADMINMETIER,
    ]);

it('can see permissions admin page if admin', function (RoleEnum $roleEnum) {
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->get('/admin/droits/permissions')
        ->assertOk();
})
    ->with([
        RoleEnum::ADMINDROITS,
        RoleEnum::SUPER_ADMIN,
    ]);
