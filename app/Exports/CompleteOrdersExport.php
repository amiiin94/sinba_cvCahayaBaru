<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompleteOrdersExport implements FromView
{
    public function view(): View
    {
        // Ambil data pesanan yang sudah selesai dengan order_status = 1
        $orders = Order::where('order_status', 1)
            ->with('customer', 'orderDetails.product') // Pastikan ada relasi ke customer dan product
            ->get();

        // Kembalikan ke view yang akan dirender menjadi Excel
        return view('exports.complete_orders', [
            'orders' => $orders
        ]);
    }
}
