@extends('partials.default')
@section('title', "{$oneProduct->name}")
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div>
        <div class="container-fluid oneProduct mt-4 mb-3">
            <div class="card" style="width: 18rem;">
                <img src="{{$oneProduct->picture}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text">{{$oneProduct->description}}</p>
                </div>
            </div>
            <div>
                <h2 >{{$oneProduct->name}}</h2>
                <p  class="mb-1"><b>{{$oneProduct->price}} €</b></p>
                <p class="mb-1"><b>Color </b>Unique</p>
                <p class="mb-1"><b>Date de sortie:</b> {{$oneProduct->release_date}}</p>
                <form method="post" action="/product/{{$oneProduct->id}}">
                    @csrf
                    <label for="product">Taille</label>
                    <select id="product" name="selectProduct" class="form-control mb-2">
                        <option>Selectionner une paire</option>
                        @for($i = 37; $i <= 49; $i++)
                            <option value="{{$i}}">Taille {{$i}} EU</option>
                        @endfor
                    </select>

                    <label for="product">Quantité</label>
                    <select id="product" name="selectQuantite" class="form-control mb-3">
                        <option>Selectionner une quantité</option>
                        @for($i = 1; $i <= 20; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                    <button class="btn btn-dark" name="id" value="{{$oneProduct->id}}">Ajouter au panier</button>
                </form>
            </div>
        </div>
    </div>
@endsection