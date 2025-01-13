<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Get list of users",
     *     description="Returns list of users",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         ),
     *         @OA\Examples(
     *             example="usersList",
     *             value={
     *                 {
     *                     "id": 1,
     *                     "name": "John Doe",
     *                     "username": "johndoe",
     *                     "email": "johndoe@example.com",
     *                     "location": "New York, USA",
     *                     "email_verified_at": "2023-01-01T00:00:00Z"
     *                 }
     *             },
     *             summary="Example users list"
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Get user information",
     *     description="Returns user data",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *         @OA\Examples(
     *             example="singleUser",
     *             value={
     *                 "id": 1,
     *                 "name": "John Doe",
     *                 "username": "johndoe",
     *                 "email": "johndoe@example.com",
     *                 "location": "New York, USA",
     *                 "email_verified_at": "2023-01-01T00:00:00Z"
     *             },
     *             summary="Single user example"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Update user",
     *     description="Updates user information",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *         @OA\Examples(
     *             example="updateUserRequest",
     *             value={
     *                 "name": "John Doe Updated",
     *                 "username": "johndoe_updated",
     *                 "email": "johndoe_updated@example.com",
     *                 "location": "New York, USA",
     *                 "password": "new_password123"
     *             },
     *             summary="Update user request example"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *         @OA\Examples(
     *             example="updatedUser",
     *             value={
     *                 "id": 1,
     *                 "name": "John Doe Updated",
     *                 "username": "johndoe_updated",
     *                 "email": "johndoe_updated@example.com",
     *                 "location": "New York, USA",
     *                 "email_verified_at": "2023-01-01T00:00:00Z"
     *             },
     *             summary="Updated user example"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Delete user",
     *     description="Deletes a user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
?>
