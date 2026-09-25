<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Http\Requests\StoreOrderDetailRequest;
use App\Http\Requests\UpdateOrderDetailRequest;

class OrderDetailController extends Controller
{
    // Menampilkan semua data order detail
    public function index()
    {
        //
    }

    // Menampilkan form untuk membuat order detail
    public function create()
    {
        //
    }

    // Menyimpan order detail baru
    public function store(StoreOrderDetailRequest $request)
    {
        //
    }

    // Menampilkan detail order tertentu
    public function show(OrderDetail $orderDetail)
    {
        //
    }

    // Menampilkan form untuk mengedit order detail
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    // Memperbarui order detail
    public function update(UpdateOrderDetailRequest $request, OrderDetail $orderDetail)
    {
        //
    }

    // Menghapus order detail
    public function destroy(OrderDetail $orderDetail)
    {
        //
    }
}