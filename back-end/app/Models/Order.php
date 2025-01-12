<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    
    protected $fillable = [
        'total_number',
        'total_price',
        'status',
        'duration',
        'customer_id',
        'food_id',
    ];

    public function customer():BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function food():BelongsTo
    {
        return $this->belongsTo(Food::class, 'food_id', 'id');
    }
}
