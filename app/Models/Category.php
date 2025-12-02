<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id'];

    // 1. Quan hệ: Một danh mục con thuộc về một danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 2. Quan hệ: Một danh mục cha có nhiều danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // 3. Quan hệ: Một danh mục có nhiều văn bản
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}