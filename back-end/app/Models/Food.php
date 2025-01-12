<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Food extends Model
{
    /** @use HasFactory<\Database\Factories\FoodFactory> */
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
