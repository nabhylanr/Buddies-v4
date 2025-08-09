<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isImplementor()
    {
        return $this->role === 'implementor';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole($roles)
    {
        return in_array($this->role, $roles);
    }

    public function canAccessDashboard()
    {
        return $this->isAdmin() || $this->isImplementor();
    }

    public function canAccessMeetings()
    {
        return $this->isAdmin() || $this->isUser();
    }

    public function canAccessTasks()
    {
        return $this->isAdmin() || $this->isImplementor();
    }

    public function canAccessRecaps()
    {
        return $this->isAdmin() || $this->isImplementor();
    }
}