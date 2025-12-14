<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderVendidoController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::query()
            ->where('order_status', OrderStatus::VENDIDO)
            ->latest()
            ->get();

        return view('orders.vendido-orders', [
            'orders' => $orders
        ]);
    }
}
