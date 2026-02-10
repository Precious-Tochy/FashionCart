<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent_id', 'status'];

    // Relationship for subcategories
    public function subcategories() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relationship for parent category
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    // App\Models\Category.php
public function images()
{
    return $this->hasMany(CategoryImage::class);
}

}
