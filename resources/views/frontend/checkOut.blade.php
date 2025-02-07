@extends('frontend.master')

@section('title', 'Checkout')

@section('content')
    <div style="display: flex; justify-content: center; margin: 10 10 10 10">
        <h1>Checkout</h1>
    </div>
    @if (session('cart') && count(session('cart')) > 0)
        <div class="row">
            <div class="col-md-8">
                <h2>Cart Items</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('cart') as $productId => $item)
                            <tr>
                                <td>{{ $item['name'] }}
                                    <img src="{{ $item['image'] }}" style="width:50px">
                                </td>
                                <td>
                                    <form action="{{ route('cart.update', $productId) }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" class="form-control" min="1">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                                        </div>
                                    </form>
       
                                </td>
                                <td>${{ $item['price'] }}</td>
                                <td>${{ $item['quantity'] * $item['price'] }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h3>Total: ${{ $total }}</h3> <!-- Display Total Price -->
            </div>
            <div class="col-md-4">
                <h2>Your Telegram Chat ID</h2>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        {{-- <label for="telegramid" class="form-label">Your Telegram Chat ID</label> --}}
                        <input type="number" class="form-control" id="telegramid" name="telegramid" required>
                    </div>
                    <a class="btn btn-secondary" href="https://t.me/st25_sa_bunnet_bot">Subscribe to Bot</a>
                    <button type="submit" class="btn btn-primary">Send Invoice</button>
                </form>
            </div>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
@endsection