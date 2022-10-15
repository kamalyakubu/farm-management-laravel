<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['image', 'name', 'subcategory_id'];

    protected $searchableFields = ['*'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
