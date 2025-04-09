<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocialiteAuthController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard/clients', function(Request $request) {
    return view('proxy.clients', [
        'clients' => $request->user()->clients
    ]);
})->middleware(['auth'])->name('dashboard.clients');

/**Connexion / Déconnexion */
Route::controller(AuthenticationController::class)->group(function () {
    Route::get('login', 'form')->middleware('guest')->name('login');
    Route::post('login', 'authenticate')->middleware('guest')->name('login.submit');
    Route::any('logout', 'logout')->middleware('auth:web')->name('logout');
    Route::get('forgotpwd', 'forgotpwd')->middleware('guest')->name('forgotpwd');
    Route::post('forgotpwd', 'sendpwd')->middleware('guest')->name('forgotpwd.submit');
});

/**Impersonnate */
Route::impersonate();

Route::controller(SocialiteAuthController::class)->group(function(){
    Route::get('/oauth/callback', 'authenticate')->name('oauth.callback');
    Route::get('/oauth/redirect', 'redirect')->name('oauth.redirect');
});


/**Users functionnalities */
Route::controller(UserController::class)->middleware(['auth', 'useractive'])->group(function () {
    Route::get('/changepwd', 'check')->name('change.pwd');
    Route::post('pwd', 'changePassword')->name('pwd');
    Route::post('reinitpwd/{user}', 'reinit')->name('reinit.pwd')->middleware('permission:update_droits');
    Route::get('profile/{user}', 'profile')->name('profile');
});

// /**MindefConnect */
// Route::controller(SocialiteAuthController::class)->group(function () {
//     Route::get('oauth/keycloak/redirect', 'redirect')->name('oauth.redirect');
//     Route::get('oauth/keycloak/callback', 'authenticate');
// });

/** Administration des utilisateurs, roles et permissions */
Route::prefix('admin/droits')->middleware(['auth', 'check', 'useractive'])->name('admin.droits.')->group(function () {
    Route::controller(UserController::class)->group(function () {
        /** Utilisateurs */
        Route::get('', 'index')->name('users.index')->middleware('permission:read_droits|read_users');
        Route::get('/users', 'index')->name('users.index')->middleware('permission:read_droits|read_users');
        Route::post('/users', 'store')->name('users.store')->middleware('permission:create_droits|create_users');
        Route::get('/users/create', 'create')->name('users.create')->middleware('permission:create_droits|create_users');
        Route::patch('/users/{id}', 'activate')->name('users.activate')->where('id', '[0-9]+')->middleware('permission:update_droits|update_users');
        Route::get('/users/{user}', 'show')->name('users.show')->where('user', '[0-9]+')->middleware('permission:read_droits|read_users');
        Route::delete('/users/{user}', 'destroy')->name('users.destroy')->where('user', '[0-9]+')->middleware('permission:delete_droits|delete_users');
        Route::patch('/users/{user}', 'update')->name('users.update')->where('user', '[0-9]+')->middleware('permission:update_droits|update_users');
        Route::post('/users/{user}/roles', 'giveRole')->name('users.roles')->middleware('permission:update_droits|update_users');
        Route::delete('/users/{user}/roles/{role}', 'revokeRole')->name('users.roles.revoke')->middleware('permission:update_droits|update_users');
    });
    Route::controller(RoleController::class)->group(function () {
        /** Rôles */
        Route::get('/roles', 'index')->name('roles.index')->middleware('permission:read_droits');
        Route::post('/roles', 'store')->name('roles.store')->middleware('permission:create_droits');
        Route::get('/roles/{id}', 'show')->name('roles.show')->where('id', '[0-9]+')->middleware('permission:read_droits');
        Route::patch('/roles/{id}', 'update')->name('roles.update')->where('id', '[0-9]+')->middleware('permission:update_droits');
        route::get('/roles/create', 'create')->name('roles.create')->middleware('permission:create_droits');
        Route::post('/roles/{role}/permissions', 'givePermission')->name('roles.permissions')->middleware('permission:update_droits');
        Route::delete('/roles/{role}/permissions/{permission}', 'revokePermission')->name('roles.permissions.revoke')->middleware('permission:update_droits');
    });
    Route::controller(PermissionController::class)->group(function () {
        /** Permissions */
        Route::get('/permissions', 'index')->name('permissions.index')->middleware('permission:read_droits');
        Route::post('/permissions', 'store')->name('permissions.store')->middleware('permission:create_droits');
        Route::get('/permissions/{id}', 'show')->name('permissions.show')->where('id', '[0-9]+')->middleware('permission:read_droits');
        Route::patch('/permissions/{id}', 'update')->name('permissions.update')->where('id', '[0-9]+')->middleware('permission:update_droits');
        route::get('/permissions/create', 'create')->name('permissions.create')->middleware('permission:create_droits');
        Route::post('/permissions/{permission}/roles', 'giveRole')->name('permissions.roles')->middleware('permission:update_droits');
        Route::delete('/permissions/{permission}/roles/{role}', 'revokeRole')->name('permissions.roles.revoke')->middleware('permission:update_droits');
    });
});

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth', 'check']);

Route::get('/contact', function () {
    return view('contact');
})->name('contact')->middleware(['auth', 'check']);

Route::post('/contact', [HomeController::class, 'contact'])->name('postcontact');

Route::get('/add_client', function(){
    return view('proxy.add_client');
})->name('add.client');

Route::get('/params_proxy', function(){
    return view('proxy.params');
})->name('param.proxy');

Route::post('/changeParams/{param}', [SocialiteAuthController::class, 'changeParams']);

Route::delete('/delete/{id}',[ SocialiteAuthController::class, 'destroyClient']);