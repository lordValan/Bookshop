@extends('layouts.app')

@section('title', 'Welcome!')
@section('content')
    <main class="main">
        <div class="main-slider-advantages-block">
            <div class="offer-block flexible">
                <div class="offer-block-part img-block">
                    <img src="./images/other/woman.png">
                </div>
                <div class="offer-block-part text-block flexible">
                    <h1 class="head">Special <span>offer</span></h1>
                    <p class="text">for our customers</p>
                    <a href="{{Route('salebooks')}}"><button class="btn">Get the deal</button></a>
                </div>
            </div>
            <div class="main-advantages-block">
                <div class="main-advantages-items flexible rewidth">
                    <div class="main-advantages-item flexible">
                        <i class="ti-truck main-advantages-item-icon"></i>
                        <div class="main-advantages-item-text">
                            <h5 class="header">Quick Delivery</h5>
                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <div class="main-advantages-item flexible">
                        <i class="ti-credit-card main-advantages-item-icon"></i>
                        <div class="main-advantages-item-text">
                            <h5 class="header">Pay with Easy</h5>
                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <div class="main-advantages-item flexible">
                        <i class="ti-tag main-advantages-item-icon"></i>
                        <div class="main-advantages-item-text">
                            <h5 class="header">Best Deal</h5>
                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <div class="main-advantages-item flexible">
                        <i class="ti-check main-advantages-item-icon"></i>
                        <div class="main-advantages-item-text">
                            <h5 class="header">Secured Payment</h5>
                            <p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($bestsellers) > 0)
        <div class="main-slider-bestsellers-block rewidth">
            <div class="main-slider-head flexible vert-flex-center">
                <h3 class="main-slider-header">Current Bestsellers</h3>
                <a href="{{Route('bestsellingbooks')}}" class="main-slider-show-all">Show all</a>
            </div>
            <div class="main-slider-bestsellers-container">
                @foreach($bestsellers as $bestseller)
                    @include('layouts.mainBook', ['book' => $bestseller])
                @endforeach
            </div>
        </div>
        @endif
        @if(count($toprated) > 0)
        <div class="main-slider-toprated-block rewidth">
            <div class="main-slider-head flexible vert-flex-center">
                <h3 class="main-slider-header">Top Rated Books</h3>
                <a href="{{Route('topratedbooks')}}" class="main-slider-show-all">Show all</a>
            </div>
            <div class="main-slider-toprated-container">
                @foreach($toprated as $toprate)
                    @include('layouts.mainBook', ['book' => $toprate])
                @endforeach
            </div>
        </div>
        @endif
        @if(count($onsale) > 0)
        <div class="main-sale-block flexible">
            <h3 class="sale-timer-center-header">Limited time offer</h3>
            <div class="sale-timer flexible">
                <div class="sale-timer-days">
                    <span class="timer-num">13</span>
                    <span class="timer-text">days</span>
                </div>
                <div class="sale-timer-hours">
                    <span class="timer-num">13</span>
                    <span class="timer-text">hours</span>
                </div>
                <div class="sale-timer-minutes">
                    <span class="timer-num">13</span>
                    <span class="timer-text">minutes</span>
                </div>
                <div class="sale-timer-seconds">
                    <span class="timer-num">13</span>
                    <span class="timer-text">seconds</span>
                </div>
            </div>
            <div class="main-sale-books flexible rewidth">
                @foreach($onsale as $onsaleBook)
                    @include('layouts.mainBook', ['book' => $onsaleBook])
                @endforeach
            </div>
        </div>
        @endif
        <div class="main-customers-block rewidth">
            <h3 class="main-center-header">Our happy cutomers</h3>
            <p class="main-customers-text">{{$customers[1]->opinion}}</p>
            <div class="main-customers flexible">
                @foreach($customers as $customer)
                    @include('layouts.mainCustomer', [
                        'customer' => $customer,
                        'is_active' => $customer->name == $customers[1]->name
                    ])
                @endforeach                
            </div>
        </div>
    </main>
@endsection