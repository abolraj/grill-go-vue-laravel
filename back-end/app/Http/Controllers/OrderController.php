<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/orders",
     *     tags={"Orders"},
     *     operationId="getOrders",
     *     summary="Get a list of orders",
     *     description="Returns a list of all orders",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of orders",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Order")
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
        $orders = Order::all();
        return response()->json($orders);
    }

    /**
     * @OA\Post(
     *     path="/orders",
     *     tags={"Orders"},
     *     operationId="storeOrder",
     *     summary="Create a new order",
     *     description="Stores a new order",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         description="Order details",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
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
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        return response()->json($order, 201);
    }

    /**
     * @OA\Get(
     *     path="/orders/{id}",
     *     tags={"Orders"},
     *     operationId="getOrder",
     *     summary="Get an order",
     *     description="Returns a single order by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the order",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single order",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function show(Order $order)
    {
        return response()->json($order);
    }

    /**
     * @OA\Put(
     *     path="/orders/{id}",
     *     tags={"Orders"},
     *     operationId="updateOrder",
     *     summary="Update an order",
     *     description="Updates the details of an existing order",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the order",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Updated order details",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return response()->json($order);
    }

    /**
     * @OA\Delete(
     *     path="/orders/{id}",
     *     tags={"Orders"},
     *     operationId="deleteOrder",
     *     summary="Delete an order",
     *     description="Removes an existing order",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the order",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Order deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
