<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_seller',
        'is_approved',
        'is_admin',
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
            'is_seller' => 'boolean',
            'is_approved' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Check if user is a seller
     */
    public function isSeller()
    {
        // First check if user is admin (admins can access seller dashboard)
        if ($this->isAdmin()) {
            return true;
        }
        
        // Check based on role column
        if ($this->role === 'seller') {
            return true;
        }
        
        // Or check based on is_seller column
        return $this->is_seller == true;
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        if ($this->role === 'admin') {
            return true;
        }
        
        return $this->is_admin == true;
    }

    /**
     * Check if user has any role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if seller is approved
     */
    public function isApprovedSeller()
    {
        return $this->isSeller() && ($this->is_approved == true);
    }
}