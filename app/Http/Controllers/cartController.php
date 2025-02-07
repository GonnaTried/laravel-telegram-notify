<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class cartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        // Fetch the product from the Fake Store API
        $response = Http::get("https://fakestoreapi.com/products/{$productId}");

        if ($response->successful()) {
            $product = $response->json(); // Decode the JSON response
        } else {
            // Handle the error (e.g., log it, redirect with an error message)
            return back()->with('error', 'Product not found.');
        }

        // Get the cart from the session
        $cart = session()->get('cart', []);

        // Check if the product is already in the cart
        if (isset($cart[$productId])) {
            // If the product is already in the cart, increment the quantity
            $cart[$productId]['quantity']++;
        } else {
            // If the product is not in the cart, add it to the cart
            $cart[$productId] = [
                'name' => $product['title'],       // Use 'title' from the API
                'quantity' => 1,
                'price' => $product['price'],      // Use 'price' from the API
                'image' => $product['image'],      // Use 'image' from the API
            ];
        }

        // Store the cart in the session
        session()->put('cart', $cart);

        // Redirect back to the previous page with a success message
        return back()->with('success', 'Product added to cart successfully!');
    }
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('frontend.checkOut', ['total' => $total]);
    }
    public function processCheckout(Request $request)
    {
        // 1. Validate the input
        $validatedData = $request->validate([
            'telegramid' => 'required|integer',
        ]);

        $telegramId = $request->input('telegramid');

        // 2. Get the cart data and calculate the total
        $cart = session('cart');
        $total = 0;
        $invoiceText = "<b>Order Details:</b>\n";
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $invoiceText .= "{$item['name']}<b> x {$item['quantity']} - $" . ($item['price'] * $item['quantity']) . "</b>\n";
        }
        $invoiceText .= "<b>Total:</b> $" . $total;

        // 3. Construct the Telegram API URL
        $botToken = env('TELEGRAM_BOT_TOKEN'); // Store your bot token in .env file
        $apiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$telegramId}&text=" . urlencode($invoiceText) . "&parse_mode=HTML";

        // 4. Make the API request using Laravel's HTTP client
        $response = Http::get($apiUrl);

        // 5. Check if the message was sent successfully
        if ($response->successful()) {
            // Clear the cart
            session()->forget('cart');

            // Redirect to a confirmation page
            return redirect('home')->with('success', 'Your order has been placed! An invoice has been sent to your Telegram.');
        } else {
            // Handle the error (e.g., log it, redirect with an error message)
            // \Log::error('Telegram API Error: ' . $response->body()); // Log the error
            return back()->with('error', 'There was an error sending the invoice to Telegram. Please try again.');
        }
    }
    public function updateCart(Request $request, $productId)
    {
        // Validate the request data (ensure quantity is a positive integer)
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        // Get the cart from the session
        $cart = session()->get('cart', []);

        // Check if the product exists in the cart
        if (isset($cart[$productId])) {
            // Update the quantity
            $cart[$productId]['quantity'] = $quantity;

            // Store the updated cart in the session
            session()->put('cart', $cart);

            // Redirect back to the checkout page with a success message
            return redirect()->route('checkout')->with('success', 'Cart updated successfully!');
        } else {
            // If the product doesn't exist in the cart, redirect back with an error message
            return redirect()->route('checkout')->with('error', 'Product not found in cart.');
        }
    }

    public function removeFromCart($productId)
    {
        // Get the cart from the session
        $cart = session()->get('cart', []);

        // Check if the product exists in the cart
        if (isset($cart[$productId])) {
            // Remove the product from the cart
            unset($cart[$productId]);

            // Store the updated cart in the session
            session()->put('cart', $cart);
        }

        // Redirect back to the checkout page with a success message
        return redirect()->route('checkout')->with('success', 'Product removed from cart successfully!');
    }
}
