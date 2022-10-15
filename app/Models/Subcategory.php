<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['category_id', 'name'];

    protected $searchableFields = ['*'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function allProducts()
    {
        return $this->hasMany(Products::class);
    }
}
