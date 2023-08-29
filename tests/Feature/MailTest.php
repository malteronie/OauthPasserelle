<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Mail\NewUserMail;
use App\Mail\ReinitPwdMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use function Pest\Laravel\{actingAs};
use function Pest\Laravel\{get};

beforeEach(
    fn () => $this->seed(\Database\Seeders\DatabaseSeeder::class),
);

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
