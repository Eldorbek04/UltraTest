<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Kim yuborganini saqlash uchun shart!
        'message'
    ];

    // Xabar egasini (foydalanuvchini) osongina olish uchun aloqa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
