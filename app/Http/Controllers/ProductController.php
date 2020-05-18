<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Mail\MailtrapExample;
use App\Mail\NewOrderNotification;
use App\Message;
use App\Order;
use App\Orders_products;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(4);
        return view('welcome',[
            'products'=> $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,$id)
    {
        $oneProduct = Product::findOrFail($id);
        return view('product',[
            'oneProduct'=> $oneProduct
        ]);
    }
    public function showPayment()
    {
        return view('payment',[]);
    }
    public function payment(Request $request, Customer $customer ,Order $order, Orders_products $orders_products, Message $message )
    {
         $request->validate([
            'firstName' => 'required',
            'nickname' => 'required',
            'address' => 'required',
            'postalCode' => 'required',
            'city' => 'required',
            'email' => 'required',
            'blueCardNumber' => 'required|max:11',
            'securityCode' => 'required|max:3',
            'blueCardOwner'=> 'required',
             'year' =>'required',
             'month' =>'required'
        ]);
        $session = session('cart');
        $customer->first_name = $request->firstName;
        $customer->last_name = $request->nickname;
        $customer->address = $request->address;
        $customer->postal = $request->postalCode;
        $customer->city= $request->city;
        $customer->email = $request->email;

        $message->firstName = $request->firstName;
        $message->nickname = $request->nickname;
        $message->address = $request->address;
        $message->postal = $request->postalCode;
        $message->city= $request->city;
        $message->dataSession = $session;
        Mail::to($request->email)->send(new MailtrapExample($message));
        Mail::to('admin@gmail.com')->send(new NewOrderNotification($message));
        $customer->save();

        $order->order_number = session('cart.token');
        $order->customer_id = $customer->id;
        $order->save();

        $products = session('cart.items');
        foreach ($products as $details => $value)
        {
            $orderProduct = new Orders_products;
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $value['id'];
            $orderProduct->save();
        }
        session()->flush();
        return view('ordered',[
           'firstName' => $request->firstName,
           'nickname' =>$request->nickname,
           'city' => $request->city,
           'postalCode' => $request->postalCode,
            'address' => $request->address,
            'email' => $request->email,
            'sessionData' => $session
        ]);
    }

    public function addToCart(Request $request,$id)
    {
        $infoProduct = $request->all();
        $productOnCart = Product::FindOrFail($id);
        $sessionExist= session('cart');
        $cart = session('cart.items');
        if (!$sessionExist) {
            $tokenUnique = uniqid();
            $cart = [
                [
                    "id" => $id,
                    "quantity" => $infoProduct['selectQuantite'],
                    "size" => $infoProduct['selectProduct'],
                    "product" => $productOnCart,
                    'SubTotal'=> $productOnCart->price  *  $infoProduct['selectQuantite']
                ]
            ];

            session()->put('cart.items',$cart);
            session()->put('cart.token',$tokenUnique);
            return redirect()->back()->with('success', 'Produit ajouté avec succès !');
        }
        foreach ($cart as $checkIdToMakeChange => $value){
            if($value['id'] === $id && $value['size'] === $infoProduct['selectProduct']) {
                $cart[$checkIdToMakeChange]['quantity']+=$infoProduct['selectQuantite'];
                $cart[$checkIdToMakeChange]['SubTotal'] += ($infoProduct['selectQuantite'] * $productOnCart->price);
                /*$cart[array_search($checkIdToMakeChange, array_keys($cart))] =
                    [
                        "id" => $id,
                        "quantity" => $value['quantity']+=$infoProduct['selectQuantite'],
                        "size" => $infoProduct['selectProduct'],
                        "product" => $productOnCart,
                        'SubTotal'=> $value['SubTotal'] += ($infoProduct['selectQuantite'] * $productOnCart->price)
                    ];*/
                session()->put('cart.items',$cart);
                return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
        }
        $cart = [
               "id" => $id,
               "quantity" => $infoProduct['selectQuantite'],
               "size" => $infoProduct['selectProduct'],
               "product" => $productOnCart,
               'SubTotal'=> $productOnCart->price  *  $infoProduct['selectQuantite']
        ];
        session()->push('cart.items', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function showCart()
    {
        if (session('cart')) {
            if (count(session('cart.items')) == 0) {
                session()->flush();
            }
        }
        return view('cart');
    }

    public function removeItem(Request $request,$id)
    {
        $cart = session()->get('cart.items');
        unset($cart[$id]);
        session()->put('cart.items', $cart);
        return redirect()->back()->with('success', 'Product deleted to cart successfully!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $updateData = $request->all();
        $item = Product::findOrFail($updateData['idItem']);
        $cart = session()->get('cart.items');
        $cart[$id]['quantity']+=$updateData['quantityUpdate'];
        $cart[$id]['SubTotal'] += ($updateData['quantityUpdate'] * $item['price']);
        session()->put('cart.items', $cart);
        return redirect()->back()->with('success', 'Product Updated to cart successfully!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

    }
}
