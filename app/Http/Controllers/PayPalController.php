<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;

class PayPalController extends Controller
{
    public function createOrder(Request $request)
    {
        $amount = 0;
        
        if (count(session("cart")) == 0) {
            return redirect()->route('home')->with('message-error', 'No products in cart!');
        }

        foreach (session("cart") as $key => $value) {
            $amount += ($value["quantity"] * $value["price"]);
        }


        $client = new \GuzzleHttp\Client();
        $url = env("PAYPAL_MODE") == 'sandbox' 
            ? 'https://api-m.sandbox.paypal.com/v2/checkout/orders'
            : 'https://api-m.paypal.com/v2/checkout/orders';

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(
                        env("PAYPAL_CLIENT_ID") . ':' . env("PAYPAL_SECRET_ID")
                    )
                ],
                'json' => [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'amount' => [
                                'currency_code' => 'USD',
                                'value' => $amount
                            ]
                        ]
                    ]
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function captureOrder(Request $request, $orderId)
    {
        $client = new \GuzzleHttp\Client();
        $url = env("PAYPAL_MODE") == 'sandbox'
            ? "https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderId}/capture"
            : "https://api-m.paypal.com/v2/checkout/orders/{$orderId}/capture";

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(
                        env("PAYPAL_CLIENT_ID") . ':' . env("PAYPAL_SECRET_ID")
                    )
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            // START SAVING
            try {
                $order = Order::create([
                    "user_id" => auth()->user()->id
                ]);

                $amount = 0;
                foreach (session("cart") as $key => $value) {
                    $order->products()->create([
                        "product_id" => $key,
                        "quantity" => $value["quantity"],
                        "price" => $value["price"]
                    ]);
                    $amount += ($value["quantity"] * $value["price"]);
                }

                $order->amount = $amount;
                $order->save();

                session()->forget('cart');
             } catch (\Exception $e) {
                info($e->getMessage());
            }            
            // END SAVING

            return response()->json($data);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}