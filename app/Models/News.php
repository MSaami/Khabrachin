<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopeCategory(Builder $query, $categories)
    {
        if ($categories) {
            return $query->whereIn('category_id', $categories);
        }
        return $query;
    }

    public function scopeSource(Builder $query, $sources)
    {
        if ($sources) {
            return $query->whereIn('source', $sources);
        }
        return $query;
    }

    public function scopeSearch(Builder $query, $search)
    {
        if ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        }
        return $query;
    }

    public function scopeDateFrom(Builder $query, $date_from)
    {
        if ($date_from) {
            return $query->where('published_at', '>=', $date_from);
        }
        return $query;
    }

    public function scopeDateTo(Builder $query, $date_to)
    {
        if ($date_to) {
            return $query->where('published_at', '<=', $date_to);
        }
        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
