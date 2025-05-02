<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function create()
    {
        Cart::instance('order')
            ->destroy();

        return view('orders.create', [
            'carts' => Cart::content(),
            'products' => Product::with(['category'])->get(),
        ]);
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create($request->all());

        // Create Order Details
        $contents = Cart::instance('order')->content();
        $oDetails = [];

        foreach ($contents as $content) {
            $oDetails['order_id'] = $order['id'];
            $oDetails['product_id'] = $content->id;
            $oDetails['quantity'] = $content->qty;
            $oDetails['unitcost'] = $content->price;
            $oDetails['total'] = $content->subtotal;
            $oDetails['created_at'] = Carbon::now();

            OrderDetails::insert($oDetails);
        }

        // Delete Cart Sopping History
        Cart::destroy();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order has been created!');
    }

    public function show(Order $order)
    {
        $order->loadMissing(['details'])->get();

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    public function update(Order $order, Request $request)
    {
        // TODO refactoring

        // Reduce the stock
        $products = OrderDetails::where('order_id', $order)->get();

        foreach ($products as $product) {
            Product::where('id', $product->product_id)
                ->update(['quantity' => DB::raw('quantity-' . $product->quantity)]);
        }

        $order->update([
            'order_status' => OrderStatus::VENDIDO,
        ]);

        return redirect()
            ->route('orders.vendido')
            ->with('success', 'Order has been completed!');
    }

    public function downloadInvoice($order)
    {
        $order = Order::with(['details'])
            ->where('id', $order)
            ->first();

        return view('orders.print-invoice', [
            'order' => $order,
        ]);
    }

    public function updateStatus(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                $nuevoEstado = $order->order_status == OrderStatus::PENDIENTE
                    ? OrderStatus::VENDIDO
                    : OrderStatus::PENDIENTE;
                $order->update([
                    'order_status' => $nuevoEstado,
                ]);
            });
            return redirect()
                ->back()
                ->with('success', 'El estado del pedido ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al cargar el pedido.');
        }
    }

    public function destroy(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                // Delete order details
                OrderDetails::where('order_id', $order->id)->delete();

                // Delete the order
                $order->delete();
            });

            return redirect()
                ->route('orders.index')
                ->with('success', 'Order has been deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete the order.');
        }
    }
}
