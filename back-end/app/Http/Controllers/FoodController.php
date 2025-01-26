<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    /**
     * @OA\Get(
     *     path="/foods",
     *     tags={"Foods"},
     *     operationId="getFoods",
     *     summary="Get a list of foods",
     *     description="Returns a list of all food items",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of foods",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Food")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function index()
    {
        $foods = Food::all();
        return response()->json($foods);
    }

    /**
     * @OA\Post(
     *     path="/foods",
     *     tags={"Foods"},
     *     operationId="storeFood",
     *     summary="Create a new food item",
     *     description="Stores a new food item",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         description="Food item details",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "price", "number"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Pizza"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="integer",
     *                     example=1000
     *                 ),
     *                 @OA\Property(
     *                     property="number",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     example="Fast Food"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="ingredients",
     *                     type="string",
     *                     example="Cheese, Tomato, Dough"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Food created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Food")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreFoodRequest $request)
    {
        // Handle image upload
        $image_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->storePublicly('images', 'public');
        }

        // Create the food item
        $food = Food::create([
            ...$request->except('image'),
            'image_path' => $image_path,
        ]);

        return response()->json($food, 201);
    }

    /**
     * @OA\Get(
     *     path="/foods/{id}",
     *     tags={"Foods"},
     *     operationId="getFood",
     *     summary="Get a food item",
     *     description="Returns a single food item by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the food item",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single food item",
     *         @OA\JsonContent(ref="#/components/schemas/Food")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food item not found"
     *     )
     * )
     */
    public function show(Food $food)
    {
        return response()->json($food);
    }

    /**
     * @OA\Put(
     *     path="/foods/{id}",
     *     tags={"Foods"},
     *     operationId="updateFood",
     *     summary="Update a food item",
     *     description="Updates the details of an existing food item",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the food item",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Updated food item details",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Pizza"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="integer",
     *                     example=1000
     *                 ),
     *                 @OA\Property(
     *                     property="number",
     *                     type="integer",
     *                     example=10
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     example="Fast Food"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="ingredients",
     *                     type="string",
     *                     example="Cheese, Tomato, Dough"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Food updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Food")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food item not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        // Handle image upload
        $image_path = $food->image_path;
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($image_path && Storage::disk('public')->exists($image_path)) {
                Storage::disk('public')->delete($image_path);
            }
            // Store the new image
            $image_path = $request->file('image')->store('images', 'public');
        }

        // Update the food item
        $food->update([
            ...$request->except('image'),
            'image_path' => $image_path,
        ]);

        return response()->json($food);
    }

    /**
     * @OA\Delete(
     *     path="/foods/{id}",
     *     tags={"Foods"},
     *     operationId="deleteFood",
     *     summary="Delete a food item",
     *     description="Removes an existing food item",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the food item",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Food deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food item not found"
     *     )
     * )
     */
    public function destroy(Food $food)
    {
        // Delete the image if it exists
        if ($food->image_path && Storage::disk('public')->exists($food->image_path)) {
            Storage::disk('public')->delete($food->image_path);
        }

        // Delete the food item
        $food->delete();

        return response()->json(null, 204);
    }
}