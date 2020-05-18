<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class=" navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav d-flex justify-content-between align-items-center col-12 p-0">
            <div>
                <b>Laravel E-commerce</b>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="nav-item active mr-4">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </div>
                <div class="nav-item active">
                    <a class="nav-link" href="/cart" id="navbarDropdown" role="button" >
                        <i class="fas fa-shopping-cart"></i>
                        @if( session('cart') !== null)
                            {{count(session('cart.items'))}}
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>