<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Order",
 *     required={"total_number", "total_price", "status", "duration", "customer_id", "food_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Order ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="total_number",
 *         type="integer",
 *         description="Total number of items",
 *         example=3
 *     ),
 *     @OA\Property(
 *         property="total_price",
 *         type="number",
 *         format="float",
 *         description="Total price of the order",
 *         example=29.99
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Order status",
 *         example="pending"
 *     ),
 *     @OA\Property(
 *         property="duration",
 *         type="integer",
 *         description="Duration in minutes",
 *         example=30
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="integer",
 *         description="ID of the customer who placed the order",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="food_id",
 *         type="integer",
 *         description="ID of the food item ordered",
 *         example=2
 *     )
 * )
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_number',
        'total_price',
        'status',
        'duration',
        'customer_id',
        'food_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class, 'food_id', 'id');
    }
}
