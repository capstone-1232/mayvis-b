<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_description',
        'product_notes',
        'price',
        'created_by',
        'category_id' // foreign key
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function proposals()
    {
        return $this->belongsToMany(Proposal::class);
    }

}
