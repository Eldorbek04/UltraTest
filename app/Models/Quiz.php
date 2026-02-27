<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'is_paid', 'price', 'duration', 'user_id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'quiz_id');
    }

    

}
