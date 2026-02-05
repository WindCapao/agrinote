<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_path',
        'width',
        'height',
        'file_size',
        'license',
        'photographer',
        'user_id',
        'status'
    ];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Automatically create slug from title when saving
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($image) {
            if (empty($image->slug)) {
                $image->slug = Str::slug($image->title);
            }
        });
    }

    // RELATIONSHIPS
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        // Explicitly defining 'category_image' table to match your migration
        return $this->belongsToMany(Category::class, 'category_image');
    }

    // SCOPES
    
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // HELPER METHODS

    public function getFileSizeFormatted()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}