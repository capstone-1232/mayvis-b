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
        'product_id' // varchar
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
