<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    // Menampilkan daftar makanan
    public function index()
    {
        $foods = Food::latest()->paginate(10);
        return view('admin.foods.index', compact('foods'));
    }

    // Menampilkan form tambah makanan
    public function create()
    {
        return view('admin.foods.create');
    }

    // Menyimpan data makanan baru
    public function store(Request $request)
    {
        // Validasi data dari form
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman,Cemilan',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Membuat data makanan di database
        Food::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        // Kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.foods.index')
            ->with('success', 'Data makanan berhasil ditambahkan!');
    }

    // Menampilkan form edit makanan
    public function edit(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    // Memperbarui data makanan
    public function update(Request $request, Food $food)
    {
        // Validasi data dari form
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman,Cemilan',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Menggunakan gambar lama jika tidak ada gambar baru
        $imagePath = $food->image;

        // Mengganti gambar jika ada gambar baru
        if ($request->hasFile('image')) {
            // Menghapus gambar lama
            if ($food->image && Storage::disk('public')->exists($food->image)) {
                Storage::disk('public')->delete($food->image);
            }

            // Menyimpan gambar baru
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Memperbarui data makanan di database
        $food->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        // Kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.foods.index')
            ->with('success', 'Data makanan berhasil diperbarui!');
    }

    // Menghapus data makanan
    public function destroy(Food $food)
    {
        // Menghapus gambar dari storage
        if ($food->image && Storage::disk('public')->exists($food->image)) {
            Storage::disk('public')->delete($food->image);
        }

        // Menghapus data dari database
        $food->delete();

        // Kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('admin.foods.index')
            ->with('success', 'Data makanan berhasil dihapus!');
    }
}