<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Food",
 *     required={"name", "price", "number"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Food ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the food item",
 *         example="Pizza"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="Price of the food item",
 *         example=9.99
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="integer",
 *         description="Quantity available",
 *         example=50
 *     ),
 *     @OA\Property(
 *         property="parent_id",
 *         type="integer",
 *         description="ID of the parent food item",
 *         example=0
 *     )
 * )
 */
class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    protected $fillable = [
        'name',
        'price',
        'number',
        'parent_id',
    ];

    /**
     * Return the parent food if exists
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class, 'parent_id', 'id');
    }
}
