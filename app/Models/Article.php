<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'user_id',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Automatically create slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // RELATIONSHIPS
    
    // An article belongs to one user (author)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An article can have many categories
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // SCOPES (reusable query filters)
    
    // Get only published articles
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Get articles by specific user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}