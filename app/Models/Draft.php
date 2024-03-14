<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'created_by',
        'proposal_title',
        'status',
        'start_date',
        'proposal_price',
        'client_id',
        'product_id',
        'data' // This will store the serialized session data
    ];

    // Define relationships
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
