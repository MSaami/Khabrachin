<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreferences extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_ids',
        'sources',
        'authors'
    ];

    protected $casts = [
        'category_ids' => 'array',
        'sources' => 'array',
        'authors' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
