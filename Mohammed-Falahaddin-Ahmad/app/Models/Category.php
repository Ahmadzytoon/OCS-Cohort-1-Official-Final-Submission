<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'parent_id'];

    // Relationship to parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship to child categories (subcategories)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Alias for children
    public function subcategories()
    {
        return $this->children();
    }

    // Get all books including from subcategories
    public function allBooks()
    {
        $bookIds = $this->books()->pluck('id');
        
        foreach ($this->children as $child) {
            $bookIds = $bookIds->merge($child->books()->pluck('id'));
        }
        
        return Book::whereIn('id', $bookIds);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // Helper methods
    public function isParent()
    {
        return $this->children()->count() > 0;
    }

    public function isChild()
    {
        return $this->parent_id !== null;
    }

    public function getFullPath()
    {
        if ($this->parent) {
            return $this->parent->name . ' → ' . $this->name;
        }
        return $this->name;
    }

    // Get total book count including subcategories
    public function getTotalBooksCountAttribute()
    {
        $count = $this->books()->count();
        foreach ($this->children as $child) {
            $count += $child->books()->count();
        }
        return $count;
    }
}