@extends('layouts.app')

@section('title', 'Books')
@section('content')
    <main>
        <div class="main-head"><h1>Shopping cart</h1></div>
        <div class="shopping-cart-block rewidth">
            <table class="shopping-cart-table">
                <thead>
                <tr>
                    <th class="items-col">Items</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th class="bt-del-col"></th>
                </tr>
                </thead>
                @php
                $totalPrice = 0
                @endphp
                @foreach($items as $item)
                    @php $price = count($item->book->sale_percent) > 0 ? number_format($item->book->price / 100 * (100-$item->book->sale_percent->percentoff), 2) : $item->book->price; @endphp
                    @include('layouts.cartBook', ['item' => $item])
                    @php $totalPrice += $item->amount * $price @endphp
                @endforeach
            </table>
            <p class="total-price">Total price: <b>{{number_format($totalPrice, 2)}}$</b></p>
            <div class="btns-block flexible">
                <a href="{{route('home')}}"><button type="button" class="btn" id="btContinueShopping">Continue shopping</button></a>
                @if(count($user->cart_items) > 0)
                <a href="{{route('checkout')}}"><button type="button" class="btn" id="btGoToCheckout">Process checkout</button></a>
            </div>
        </div>
        @endif
    </main>
@endsection