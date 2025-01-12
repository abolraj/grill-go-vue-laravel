<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::all();
        return response()->json($foods);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request)
    {
        $food = Food::create($request->validated());
        return response()->json($food, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        return response()->json($food);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        $food->update($request->validated());
        return response()->json($food);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        $food->delete();
        return response()->json(null, 204);
    }
}
