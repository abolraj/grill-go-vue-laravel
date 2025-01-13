<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use Illuminate\Http\Request;

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
     *         @OA\JsonContent(ref="#/components/schemas/Food")
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
        $food = Food::create($request->validated());
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
     *         @OA\JsonContent(ref="#/components/schemas/Food")
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
        $food->update($request->validated());
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
        $food->delete();
        return response()->json(null, 204);
    }
}
