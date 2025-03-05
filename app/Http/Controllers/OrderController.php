<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
        ]);

        $cart = Cart::where('user_id', auth()->id())->firstOrFail();

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $cart->getTotal(),
            'shipping_address' => $validated['shipping_address'],
            'billing_address' => $validated['billing_address'],
            'status' => 'PENDING',
            'payment_status' => 'PENDING'
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Commande créée avec succès');
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'payment');
        return view('orders.show', compact('order'));
    }
}
