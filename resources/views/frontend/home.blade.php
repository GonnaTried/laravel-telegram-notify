@extends('frontend.master')

@section('title', 'Home Page')

@section('content')
<div class="row">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 d-flex">
            <div class="card mb-4 border-dark d-flex flex-column">
                <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['title'] }}" style="height: 200px; object-fit: contain;">
                <div class="card-body d-flex flex-column justify-content-between"> <!-- Removed justify-content-between -->
                    <h5 class="card-title">{{ $product['title'] }}</h5>
                    <p class="card-text">{{ Str::limit($product['description'], 50) }}</p>
                    <form action="{{ route('cart.add', $product['id']) }}" method="POST">
                        @csrf
                        <h5 class="card-text" style="color: blue; font-weight: bold;">Price: ${{ $product['price'] }}</h5>
                        <button type="submit" class="btn btn-primary mt-auto">Add to Cart</button>
                    </form>                
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection