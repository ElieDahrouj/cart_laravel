@extends('partials.default')
@section('title', "Home")
@section('content')
    <div class="container-fluid homePage mt-4">
        @foreach($products as $product)
            <a class="link" href="/product/{{$product->id}}">
                <div class="card">
                    <img src="{{$product->picture}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text mb-1">{{$product->name}}</p>
                        <p class="card-text mt-1"><b>{{$product->price}} €</b></p>
                        <p class="card-text">{{$product->description}}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="d-flex align-items-center justify-content-center mt-4 mb-3">
        {{ $products->links() }}
    </div>
@endsection