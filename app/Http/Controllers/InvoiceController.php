<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Models\Customer;
use Gloudemans\Shoppingcart\Facades\Cart;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('invoices.index', [
            'carts' => Cart::instance('order')->content(),
        ]);
    }
}
