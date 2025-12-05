<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title','type','author_id','published_at',
        'original_name','drive_path','mime','size',
        'category_id',
        'privacy',
        'cover_image'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}