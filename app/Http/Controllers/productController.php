<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class productController extends Controller
{
    public function index()
    {
        // Fetch products from the Fake Store API
        $response = Http::get('https://fakestoreapi.com/products');

        // Check if the request was successful
        if ($response->successful()) {
            $products = $response->json(); // Decode the JSON response
        } else {
            // Handle the error (e.g., log it, display an error message)
            $products = []; // Set an empty array if there's an error
            // Optionally, you could log the error:
            // Log::error('Failed to fetch products from Fake Store API: ' . $response->status());
        }

        // Pass the products to the view
        return view('frontend.home', ['products' => $products]);
    }
}
