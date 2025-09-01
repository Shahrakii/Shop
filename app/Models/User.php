<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // -----------------------
    // Spatie Role Helpers
    // -----------------------

    /**
     * Check if user has a role
     */
    public function hasRoleName(string $roleName): bool
    {
        return $this->hasRole($roleName);
    }

    /**
     * Assign a role to the user
     */
    public function assignRoleByName(string $roleName)
    {
        $this->assignRole($roleName);
    }

    /**
     * Remove a role from the user
     */
    public function removeRoleByName(string $roleName)
    {
        $this->removeRole($roleName);
    }
}
