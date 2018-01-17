@extends('layouts.empty')
@section('title', 'Checkout')

@section('content')
    <main class="user-page">
        <div class="panel flexible">
            <div class="panel-heading">
                <h3>Buy</h3>
            </div>
            @if (count($errors) > 0)
            <ul class="errors-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
            @endif
            <div class="panel-body">
                <form action="{{action('CartController@confirmpurchase')}}" method="POST" class="user-edit-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <table class="cart_items">
                            <thead>
                                <th>Book</th>                                
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </thead>
                            @foreach($user->cart_items as $item)
                                @include('layouts.cartBookCheckout', ['item' => $item])
                            @endforeach
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Full Name*</label>
                        <input type="text" maxlength="100" id="fullname" name="fullname" required value="{{!is_null(old('fullname')) ? old('fullname') : $user->name}}">
                    </div>   
                    <div class="form-group">
                        <label for="phone">Phone number*</label>
                        <input type="text"  id="phone" name="phone" required value="{{!is_null(old('phone')) ? old('phone') : ''}}">
                    </div>
                    <div class="form-group">
                        <label for="adress">Adress*</label>
                        <input type="text" maxlength="100" id="adress" name="adress" required value="{{!is_null(old('adress')) ? old('adress') : ''}}">
                    </div>
                    <div class="form-group">
                        <label for="city">City*</label>
                        <input type="text" maxlength="100" id="city" name="city" required value="{{!is_null(old('city')) ? old('city') : ''}}">
                    </div>
                    <div class="form-group">         
                        <button type="submit">Confirm</button>
                        <a href="{{route('home')}}"><button type="button">Home</button></a>
                    </div>   
                </form>
            </div>
        </div>
        
    </main>
@endsection



