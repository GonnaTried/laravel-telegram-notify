<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="">100pt</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{url('/home')}}">Home</a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="{{ route('checkout') }}" class="btn btn-outline-primary">
                    <i class="bi bi-cart"></i>
                    <span id="cart-count">{{ $cartCount ?? 0 }}</span> <!-- Display the cart count -->
                </a>

            </div>
        </div>
    </div>
</nav>