<!doctype html>
<html>
< lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    h3{
        text-decoration: underline;
    }
    .total{
        border-top:1px solid gray;
    }
    .info{
        grid-gap: 50px;
        grid-template-columns: repeat(auto-fit, 125px);
        display: grid;
        justify-content: flex-start;
        margin-bottom: 10px;
    }
    h5{
        margin: 0;
    }
    body{
        padding: 5px;
    }
</style>
<body>
    Bonjour <b>{{$firstName ?? ''}}</b><br>
    <p>Merci d'avoir commander sur notre site, nous espérons vous revoir très bientôt</p>
    <h3>Adresse de facturation</h3>
    <span> <b>{{ $address}}</b></span>
    <span><b>{{$postal}}</b></span>
    <span>{{$city}}</span>
    <br><br>

    <h3>Récapitulatifs des produits commandés</h3>
    <?php $total = 0; ?>
    @foreach($dataSession['items'] as $details => $values)
        <h5>{{$values['product']->name}}</h5>
        <div class="info">
            <span>Taille: <b>{{  $values['size'] }}</b></span>
            <span>Quantité: <b>{{  $values['quantity'] }}</b></span>
            <span>Sous-Total: <b>{{  $values['SubTotal'] }}</b></span>
        </div>
        <?php $total += $values['product']->price  * $values['quantity']?>
    @endforeach

    <div class="total">
        <b>Total: {{$total}} €</b>
    </div>
</body>
</html>