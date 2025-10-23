<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function list(Request $request)
    {   
        if (count(session("cart")) == 0) {
            return redirect()->route('home')->with('message-error', 'No products in cart!');
        }
        return view('cart.list');
    }

    public function add(Request $request, $id)
    {
        $product = Product::find($id);
        $cart = session('cart', []);
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image,
            "description" => $product->description,
        ];

        session()->put("cart", $cart);
        
        return redirect()->back()->with("success", "Product added to the cart.");
    }

    public function update(Request $request)
    {
        $cart = session("cart");
        if ($request->type == "update") {
            $cart[$request->product_id]["quantity"] = $request->quantity;
        }else{
            unset($cart[$request->product_id]);
        }
        
        session()->put("cart", $cart);
        $view = view("cart.box")->render();
        return response()->json(["success" => $view]);
    }

    public function check(Request $request)
    {
        if (count(session("cart")) == 0) {
            return redirect()->route('home')->with('message-error', 'No products in cart!');
        }
        return view('cart.check');
    }
}
