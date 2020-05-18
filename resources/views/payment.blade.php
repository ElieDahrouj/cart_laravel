@extends('partials.default')
@section('title', "Payment")
@section('content')
    @if(session('cart.items'))
        <div class="container-fluid mt-4">
            <form method="post" action="/payment">
                @csrf
                <div class="container-fluid">
                    <h2>Informations Clients</h2>
                </div>
                <div style="display: flex;justify-content: space-between">
                    <div class="form-group col" >
                        <label for="userName">Name</label>
                        <input type="text" name="firstName" class="form-control{{($errors->first('firstName') ? " form-error" : "")}}" id="userName">
                        {!! $errors->first('firstName', '<p class="help-block">:message</p>') !!}
                    </div>
                    <input type="hidden" value="{{session('cart.token')}}" name="id">
                    <div class="form-group col">
                        <label for="nickname">Nickname</label>
                        <input type="text" class="form-control{{($errors->first('nickname') ? " form-error" : "")}}" name="nickname" id="nickname">
                        {!! $errors->first('nickname', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div style="display: flex;justify-content: space-between">
                    <div class="form-group col" >
                        <label for="address">Addresse</label>
                        <input type="text" name="address" class="form-control{{($errors->first('address') ? " form-error" : "")}}" id="address">
                        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div style="display: flex;">
                        <div class="form-group col">
                            <label for="code">Code Postale</label>
                            <input type="tel" maxlength="5" class="form-control{{($errors->first('postalCode') ? " form-error" : "")}}" name="postalCode" id="code">
                            {!! $errors->first('postalCode', '<p class="help-block">:message</p>') !!}
                        </div>
                        <div class="form-group col">
                            <label for="city">Ville</label>
                            <input type="text" class="form-control{{($errors->first('city') ? " form-error" : "")}}" name="city" id="city">
                            {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="w-50" style="display: flex;">
                    <div class="form-group col">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email"  name="email" class="form-control{{($errors->first('email') ? " form-error" : "")}}" id="exampleInputEmail1">
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="container-fluid">
                    <h2>Informations Bancaire</h2>
                </div>
                <div class="d-flex">
                    <div class="form-group col ">
                        <label for="cbNumber">Blue Card Number</label>
                        <input type="tel" maxlength="11" name="blueCardNumber" class="form-control{{($errors->first('blueCardNumber') ? " form-error" : "")}}" id="cbNumber">
                        {!! $errors->first('blueCardNumber', '<p class="help-block">:message</p>') !!}
                </div>
                    <div class="form-group col ">
                        <label for="securityCode">Security Code</label>
                        <input type="tel" maxlength="3" class="form-control{{($errors->first('securityCode') ? " form-error" : "")}}" name="securityCode" id="securityCode">
                        {!! $errors->first('securityCode', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col ">
                        <label for="owner">Blue Card Owner</label>
                        <input type="text" class="form-control{{($errors->first('blueCardOwner') ? " form-error" : "")}}" name="blueCardOwner" id="owner">
                        {!! $errors->first('blueCardOwner', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col ">
                        <label for="month">Month</label>
                        <input type="text" class="form-control{{($errors->first('month') ? " form-error" : "")}}" name="month" id="month">
                        {!! $errors->first('month', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group col ">
                        <label for="year">Year</label>
                        <input type="text" class="form-control{{($errors->first('year') ? " form-error" : "")}}"  name="year" id="month">
                        {!! $errors->first('year', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="container-fluid mb-3">
                    <h2><strong>Récapitulatif de la commande</strong></h2>
                </div>
                <?php $total = 0; ?>
                <div class="form-group container-fluid payment">
                    @foreach(session('cart.items') as $id => $details)
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
                <div class=" mb-4 ml-3 border-top">
                    <span><b>Total</b> : {{ $total }} €</span>
                </div>
                <div class="form-group container-fluid btnCustom">
                    <button class="btn btn-success pl-5 pr-5">Payer</button>
                </div>
            </form>
        </div>
    @else
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping before to pay</a>
        </div>
    @endif
@endsection