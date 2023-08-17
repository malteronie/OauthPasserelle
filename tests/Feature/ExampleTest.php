<?php

namespace Tests\Feature;

use function Pest\Laravel\{get};
use function Pest\Laravel\{actingAs};
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


it('redirect to login page when anonymous', function(){
    get('/')->assertRedirect('/login');
});

it('redirect to home when authenticated users', function(){
    $user = User::factory()->create();
    $response = actingAs($user)->get('/login');
    $response->assertRedirect('/');
   
});

it('can\'t see admin page if not admin', function() {
    $user = User::factory()->create(['active' => 1]);
    $response = actingAs($user)->get('/admin/droits/users');
    $response->assertForbidden();
});

it('can see admin page if admin', function() {
    $user = User::factory()->create(['active' => 1])->assignRole('admindroits');
    $response = actingAs($user)->get('/admin/droits/users');
    $response->assertOk();
});