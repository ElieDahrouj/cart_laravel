@extends('partials.default')
@section('title', "Cart")
@section('content')
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Size</th>
            <th class="text-center">Subtotal</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <?php $total = 0 ?>
        @if(session('cart'))
            @foreach(session('cart.items') as $id => $details)
                <?php $total += $details['product']->price  * $details['quantity']?>
                <tr>
                    <td data-th="Product">
                        <div class="row ml-3">
                            <img src="{{ $details['product']->picture }}" width="100" height="100" class="img-responsive"/>
                            <h4 class="p-0 ml-3">{{  $details['product']->name }}</h4>
                        </div>
                    </td>
                    <td data-th="Price">{{  $details['product']->price }} €</td>
                    <td data-th="Quantity">
                        <form method="post" action="/cart/{{$id}}">
                            @csrf
                            <input type="hidden" name="idItem" value="{{$details['product']->id}}">
                            <label for="quantity">Quantité :</label> {{$details['quantity']}}
                            <select class="form-control" name="quantityUpdate" id="quantity" >
                                @for($i = 1; $i <= 20; $i++)
                                    <option {{ $i == $details['quantity'] ?' selected ': '' }} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <button type="submit" name="_method" value="patch" class="btn btn-secondary mt-2">Mettre à jour</button>
                        </form>
                    </td>
                    <td data-th="Size">
                        {{ $details['size'] }}
                    </td>
                    <td data-th="Subtotal" class="text-center">{{$details['SubTotal']}}</td>
                    <td class="actions">
                        <form method="post" action="/cart/{{$id}}">
                            @csrf
                            <button class="btn btn-danger btn-sm remove-from-cart" name="_method" value="delete" ><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <div class="alert alert-info" role="alert">
                Aucun produit présent dans le panier
            </div>
        @endif
    </tbody>

    <tfoot style="border-top: 1px solid #dee2e6;">
        <tr>
            <td><a href="{{ url('/') }}" class="btn btn-light"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong><b>Total</b> {{ $total }} €</strong></td>
            @if(session('cart.items') )
                <td><a href="{{ url('/payment') }}" class="btn btn-success"> Proceed to payment</a></td>
            @endif
        </tr>
    </tfoot>
</table>

@endsection