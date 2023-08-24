<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'short_rank',
        'rank',
        'first_name',
        'last_name',
        'name',
        'login',
        'email',
        'affectation_annudef',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public User $user;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canImpersonate(): bool
    {
        $canImpersonnate = [\App\Enums\RoleEnum::SUPER_ADMIN->value, 'admindroits', 'adminmetier'];

        return $this->hasanyrole($canImpersonnate);
    }

    public function canBeImpersonated(): bool
    {
        $notImpersonnatable = [\App\Enums\RoleEnum::SUPER_ADMIN->value, 'admindroits'];

        return ! $this->hasanyrole($notImpersonnatable);
    }
}
