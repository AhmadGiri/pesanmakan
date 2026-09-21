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
        $foods = Food::paginate(10);
        return view('admin.foods.index', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.food.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            "category" => 'required|in:Makanan,Minuman,Cemilan',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            "image" => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $food->image;
        if ($request->hasFile('image')) {
            if ($food->image && storage::disk('public')->exists($food->image)) {
                storage::disk('public')->delete($food->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
    }

        Food::Update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('foods.index')->with('success', 'Data Makanan berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        if ($food->image && storage::disk('public')->exists($food->image)) {
            storage::disk('public')->delete($food->image);
        }

        $food->delete();

        return redirect()->route('foods.index')->with('success', 'Data Makanan berhasil dihapus.');
    }
}
