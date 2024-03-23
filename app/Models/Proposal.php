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
        'proposal_price',
        'automated_message',
        'unique_token',
        'view_link',
        'client_id', // foreign key
        'user_id', // foreign key
        'product_id' // varchar
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class); // Adjust based on your actual relationship
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
