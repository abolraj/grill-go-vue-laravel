<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
 *     ),
 *     @OA\Property(
 *         property="note",
 *         type="integer",
 *         description="Notes for the order",
 *         example=2
 *     )
 * )
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'duration',
        'customer_id',
        'food_id',
        'note',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'orders_foods', 'order_id', 'food_id')->withPivot('number');
    }
}
