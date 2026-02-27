<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hisob extends Model
{
    // Agar jadvalingiz nomi 'hisobs' bo'lsa, buni yozish shart emas, 
    // lekin xatolik chiqsa aniqlashtirib qo'ygan ma'qul:
    protected $table = 'hisobs';

    protected $fillable = [
        'user_id',
        'many',
        'image',
        'status',
    ];

    /**
     * Hisob qaysi foydalanuvchiga tegishli ekanligini bog'lash
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}