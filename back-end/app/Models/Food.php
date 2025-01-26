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
 *         property="category",
 *         type="string",
 *         description="Category of the food item",
 *         example="Pizza"
 *     ),
 *     @OA\Property(
 *         property="image_path",
 *         type="string",
 *         description="Image path of the food item",
 *         example="/images/dosijpddpjd8w-wihdpo.jpg"
 *     ),
 *     @OA\Property(
 *         property="ingredients",
 *         type="string",
 *         description="ID of the parent food item",
 *         example="1. 1 dish food 2. ..."
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
        'category',
        'image_path',
        'ingredients',
    ];

}
