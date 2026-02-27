<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'referral_code',
        'referrer_id',
        'expires_at', // Faqat ustun nomi bo'lishi shart
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'expires_at' => 'datetime', // Sanani to'g'ri ishlashi uchun shu yerda qoladi
    ];

    // --- Munosabatlar (Relationships) ---

    public function results()
    {
        return $this->hasMany(Result::class); 
    }

    public function tests()
    {
        return $this->belongsToMany(Quiz::class)->withTimestamps();
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    // --- Boot metodi (Referral code yaratish) ---

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = strtoupper(Str::random(8));
            }
        });
    }

    public function purchases()
{
    return $this->hasMany(Purchase::class);
}

// Foydalanuvchi sotib olgan testlar ro'yxatini to'g'ridan-to'g'ri olish uchun
public function purchasedQuizzes()
{
    return $this->belongsToMany(Quiz::class, 'purchases');
}

// app/Models/User.php
public function quizzes()
{
    // User va Quiz o'rtasidagi ko'pga-ko'p bog'lanish (purchases jadvali orqali)
    return $this->belongsToMany(Quiz::class, 'purchases', 'user_id', 'quiz_id');
}

public function addMoney($amount)
{
    // Balansni oshiramiz
    $this->increment('balance', $amount);
    
    // Bu yerda xohlasangiz Transaction (tarix) jadvaliga yozishni ham qo'shishingiz mumkin
}

public function hisoblar()
{
    return $this->hasMany(Hisob::class, 'user_id');
}

}