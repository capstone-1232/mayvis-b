<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'proposal_title',
        'status',
        'start_date',
        'client_id', // foreign key
        'user_id', // foreign key
        'product_id' // foreign key
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
