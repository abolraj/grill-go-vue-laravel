<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFood extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFoodFactory> */
    use HasFactory;

    protected $table = 'orders_foods';

    protected $fillable = [
        'number',
        'food_id',
        'order_id',
    ];
}
