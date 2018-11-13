<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request, CartService $cartService)
    {
        $cartItems = $cartService->get();
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();
        $total_price = 0;
        $total_price += collect($cartItems)->map(function($item)  {
            return $item->productSku->price * $item->amount;
        })->sum();
        return view('checkout.index', ['cartItems' => $cartItems, 'addresses' => $addresses, 'total_price' => $total_price]);
    }
}
