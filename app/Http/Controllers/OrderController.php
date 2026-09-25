<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Menampilkan daftar menu makanan untuk customer
    public function index()
    {
        $foods = Food::all();

        return view('customer.index', compact('foods'));
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        // Validasi data pesanan
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|integer|min:1',
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0',
        ]);

        // Mengambil menu yang jumlahnya lebih dari 0
        $orderedItems = array_filter(
            $request->items,
            fn ($qty) => $qty > 0
        );

        // Memastikan customer memilih minimal satu menu
        if (empty($orderedItems)) {
            return back()->withErrors([
                'items' => 'Pilih minimal satu menu makanan!'
            ]);
        }

        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Membuat data order
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $totalPrice = 0;

            // Memproses setiap menu yang dipesan
            foreach ($orderedItems as $foodId => $quantity) {

                // Mengambil data makanan berdasarkan ID
                $food = Food::findOrFail($foodId);

                // Menghitung subtotal makanan
                $subTotal = $food->price * $quantity;

                // Menambahkan subtotal ke total harga
                $totalPrice += $subTotal;

                // Menyimpan detail pesanan
                OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id' => $foodId,
                    'quantity' => $quantity,
                    'subtotal' => $subTotal,
                ]);
            }

            // Menyimpan total harga ke order
            $order->update([
                'total_price' => $totalPrice
            ]);

            // Menyelesaikan transaksi
            DB::commit();

            // Kembali ke halaman customer dengan pesan sukses
            return redirect()
                ->route('customer.index')
                ->with(
                    'success',
                    'Pesanan berhasil dibuat! Nomor Meja: ' .
                    $order->table_number
                );

        } catch (\Exception $e) {

            // Membatalkan transaksi jika terjadi error
            DB::rollBack();

            return back()->with(
                'error',
                'Gagal memproses pesanan: ' . $e->getMessage()
            );
        }
    }

    // Menampilkan semua pesanan di dashboard admin
    public function adminDashboard()
    {
        // Mengambil order beserta detail dan data makanan
        $orders = Order::with('orderDetails.food')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('orders'));
    }

    // Mengubah status pesanan
    public function updateStatus(Request $request, $id)
    {
        // Validasi status
        $request->validate([
            'status' => 'required|string'
        ]);

        // Mencari pesanan berdasarkan ID
        $order = Order::findOrFail($id);

        // Memperbarui status pesanan
        $order->update([
            'status' => $request->status
        ]);

        // Kembali dengan pesan sukses
        return back()->with(
            'success',
            'Status pesanan #' . $order->id . ' berhasil diperbarui!'
        );
    }
}