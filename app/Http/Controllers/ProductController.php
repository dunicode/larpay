<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function list(){
        try {
            $data = Product::all();
            return view('products.list', ['data' => $data]);
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            return Redirect::back()->with('message-error', 'An error occurred while trying to process your request.');
        }
    }
}
