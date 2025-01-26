<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderFood;
use App\Http\Requests\StoreOrderFoodRequest;
use App\Http\Requests\UpdateOrderFoodRequest;
use Illuminate\Http\Response;

/**
 *
 * @OA\Schema(
 *     schema="OrderFood",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the food item",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the food item",
 *         example="Pizza"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="integer",
 *         description="The price of the food item",
 *         example=1000
 *     ),
 *     @OA\Property(
 *         property="number",
 *         type="integer",
 *         description="The quantity of the food item",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="category",
 *         type="string",
 *         nullable=true,
 *         description="The category of the food item",
 *         example="Italian"
 *     ),
 *     @OA\Property(
 *         property="image_path",
 *         type="string",
 *         nullable=true,
 *         description="The path to the image of the food item",
 *         example="images/pizza.jpg"
 *     ),
 *     @OA\Property(
 *         property="ingredients",
 *         type="string",
 *         nullable=true,
 *         description="The ingredients of the food item",
 *         example="Cheese, Tomato, Basil"
 *     ),
 *     @OA\Property(
 *         property="pivot",
 *         type="object",
 *         @OA\Property(
 *             property="number",
 *             type="integer",
 *             description="The quantity of the food item in the order",
 *             example=2
 *         )
 *     )
 * )
 */
class OrderFoodController extends Controller
{
    /**
     * @OA\Get(
     *     path="/orders/{order}/foods",
     *     summary="List all foods in an order",
     *     description="Retrieve a list of all foods associated with a specific order.",
     *     tags={"Order Foods"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="The ID of the order",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of foods in the order",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/OrderFood")
     *         )
     *     )
     * )
     */
    public function index(Order $order)
    {
        // Get all foods associated with the order
        $foods = $order->foods()->withPivot('number')->get();
        return response()->json($foods);
    }

    /**
     * @OA\Post(
     *     path="/orders/{order}/foods",
     *     summary="Add a food item to an order",
     *     description="Add a new food item to a specific order with the quantity.",
     *     security={{"bearerAuth":{}}},
     *     tags={"Order Foods"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="The ID of the order",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"food_id", "number"},
     *             @OA\Property(
     *                 property="food_id",
     *                 type="integer",
     *                 description="The ID of the food item to add to the order",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="number",
     *                 type="integer",
     *                 description="The quantity of the food item to add",
     *                 example=2
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Food item added to the order successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Food added to order successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/OrderFood"
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreOrderFoodRequest $request, Order $order)
    {
        // Attach food to order with the number of items
        $order->foods()->attach($request->food_id, ['number' => $request->number]);

        return response()->json([
            'message' => 'Food added to order successfully',
            'data' => $order->foods()->where('food_id', $request->food_id)->first(),
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/orders/{order}/foods/{food}",
     *     summary="Get a specific food item in an order",
     *     description="Retrieve details of a specific food item in a specific order.",
     *     security={{"bearerAuth":{}}},
     *     tags={"Order Foods"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="The ID of the order",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="food",
     *         in="path",
     *         required=true,
     *         description="The ID of the food item",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the food item in the order",
     *         @OA\JsonContent(ref="#/components/schemas/OrderFood")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food item not found in the order",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Food not found in this order"
     *             )
     *         )
     *     )
     * )
     */
    public function show(Order $order, Food $food)
    {
        // Get the specific food item in the order
        $food = $order->foods()->where('food_id', $food->id)->first();

        if (!$food) {
            return response()->json([
                'message' => 'Food not found in this order',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($food);
    }

    /**
     * @OA\Put(
     *     path="/orders/{order}/foods/{food}",
     *     summary="Update a food item in an order",
     *     description="Update the quantity of a specific food item in a specific order.",
     *     security={{"bearerAuth":{}}},
     *     tags={"Order Foods"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="The ID of the order",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="food",
     *         in="path",
     *         required=true,
     *         description="The ID of the food item",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"number"},
     *             @OA\Property(
     *                 property="number",
     *                 type="integer",
     *                 description="The new quantity of the food item in the order",
     *                 example=3
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Food item updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Food item updated successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/OrderFood"
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateOrderFoodRequest $request, Order $order, Food $food)
    {
        // Update the number of the specific food item in the order
        $order->foods()->updateExistingPivot($food->id, [
            'number' => $request->number,
        ]);

        return response()->json([
            'message' => 'Food item updated successfully',
            'data' => $order->foods()->where('food_id', $food->id)->first(),
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/orders/{order}/foods/{food}",
     *     summary="Remove a food item from an order",
     *     description="Remove a specific food item from a specific order.",
     *     security={{"bearerAuth":{}}},
     *     tags={"Order Foods"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         description="The ID of the order",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="food",
     *         in="path",
     *         required=true,
     *         description="The ID of the food item",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Food item removed from the order successfully"
     *     )
     * )
     */
    public function destroy(Order $order, Food $food)
    {
        // Detach the food item from the order
        $order->foods()->detach($food->id);

        return response()->json([
            'message' => 'Food item removed from order successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}