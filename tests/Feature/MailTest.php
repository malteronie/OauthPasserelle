<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\RoleEnum;
use App\Mail\NewUserMail;
use App\Mail\ReinitPwdMail;
use Illuminate\Support\Str;
use App\Mail\ActiveUserMail;
use App\Mail\ContactMail;
use App\Mail\DestroyUserMail;

use function Pest\Laravel\{get};

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\{actingAs};

beforeEach(
    fn () => $this->seed(\Database\Seeders\DatabaseSeeder::class),
);

if (env('APP_ONLINE'))
    {

it('send a mail when register new user if online\'s APP', function (RoleEnum $roleEnum) {
    Mail::fake();
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.users.store'),
            data: [
                'login' => fake()->name(),
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make(Str::password(12)),
            ]);
    Mail::assertSent(NewUserMail::class);
})
    ->with([
        RoleEnum::SUPER_ADMIN,
    ]);

it('send a mail when reinit password if online\'s APP', function (RoleEnum $roleEnum) {
    Mail::fake();
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('reinit.pwd', 1));
    Mail::assertSent(ReinitPwdMail::class);
})
    ->with([
        RoleEnum::SUPER_ADMIN,
    ]);

it('send a mail when active user if online\'s APP', function(RoleEnum $roleEnum) {
    Mail::fake();
    $user = User::factory()->create(['id' => 22, 'active' => 0]);
    actingAs(User::factory()->create(['id' => 57, 'password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.users.activate',['id' => 22]));
        //->assertSessionHasNoErrors()
        //->assertRedirectToRoute('admin.droits.users.show', $user);
    Mail::assertSent(ActiveUserMail::class);
})
    ->with([
        RoleEnum::SUPER_ADMIN,
    ]);

it('send a mail when delete user if online\'s APP', function(RoleEnum $roleEnum) {
    Mail::fake();
    $user = User::factory()->create(['id' => 50]);
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1])->assignRole($roleEnum->value))
        ->post(route('admin.droits.users.destroy', ['user' => $user, 'content' => 'test suppr']))
        ->assertSessionHasNoErrors();
        //->assertRedirectToRoute('admin.droits.users.index');
    Mail::assertSent(DestroyUserMail::class);
})
->with([
    RoleEnum::SUPER_ADMIN,
]);

it('send a mail when using contact\'s form if online\'s APP', function() {
    Mail::fake();
    actingAs(User::factory()->create(['password' => Hash::make(Str::password(12)), 'active' => 1]))
        ->post('/contact');
    Mail::assertSent(ContactMail::class);
});

    }