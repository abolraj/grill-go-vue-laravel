<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"name", "username", "email", "password"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="User ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the user",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="username",
 *         type="string",
 *         description="Username",
 *         example="johndoe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address",
 *         example="johndoe@example.com"
 *     ),
 *     @OA\Property(
 *         property="location",
 *         type="string",
 *         description="Location of the user",
 *         example="New York, USA"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         description="Role of the user",
 *         example="Manager"
 *     ),
 *     @OA\Property(
 *         property="avatar",
 *         type="integer",
 *         description="Avatar of the user (0 = no avatar,1,2,3,4)",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="Password",
 *         example="password123"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         description="Email verified at",
 *         example="2023-01-01T00:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="remember_token",
 *         type="string",
 *         description="Remember token"
 *     )
 * )
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'username',
        'email',
        'location',
        'password',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }
}
