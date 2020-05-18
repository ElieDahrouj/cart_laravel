@extends('partials.default')
@section('title', "order")
@section('content')
    <div class="container-fluid mt-4">
        <h3>Confirmation de commande</h3>
        <h4>N° {{$sessionData['token']}}</h4>
        <div class="d-flex">
            <div class="col p-0">
                <p><b>Nom:</b> {{$firstName ?? ''}}</p>
            </div>
            <div class="col p-0">
                <p><b>Prénom:</b> {{$nickname ?? ''}}</p>
            </div>
        </div>
        <div class="d-flex">
            <div class="col p-0">
                <p><b>Email:</b> {{$email}}</p>
            </div>
            <div class="col p-0">
                <p><b>Adresse:</b> {{$address}}</p>
            </div>
        </div>
        <div class="d-flex">
            <div class="col p-0">
                <p><b>Code Postale:</b> {{$postalCode}}</p>
            </div>
            <div class="col p-0">
                <p><b>Ville:</b> {{$city}}</p>
            </div>
        </div>
        <h3><u>Produits commandés</u></h3>
        <?php $total = 0; ?>
        <div class="form-group payment">
            @foreach($sessionData['items'] as $id => $details)
                <div>
                    <h4>{{  $details['product']->name }}</h4>
                    <div class="d-flex justify-content-sm-between">
                        <span>Taille: <b>{{  $details['size'] }}</b></span>
                        <span>Quantité: <b>{{  $details['quantity'] }}</b></span>
                        <span>Sous-Total: <b>{{  $details['SubTotal'] }}</b></span>
                    </div>
                    <?php $total += $details['product']->price  * $details['quantity']?>
                </div>
            @endforeach
        </div>
        <div class=" mb-4 border-top">
            <span><b>Total</b> : {{ $total }} €</span>
        </div>
        <a href="{{ url('/') }}" class="btn btn-light"><i class="fa fa-angle-left"></i> Continue Shopping</a>
    </div>
@endsection