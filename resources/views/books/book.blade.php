@extends('layouts.app')

@section('title', $book->title)
@section('content')
    <main>
        <div class="main-singlebook-block flexible rewidth">
            <div class="main-singlebook-content">
                <div class="singlebook-container">
                    <div class="main-book flexible">
                        @include('layouts.singleBookMainInfo', ['book' => $book, 'bookRating' => $averageRating])
                        <div class="nud-btAdd-block flexible">
                            <button type="button" name="btnAddToCart" class="btn btnAddToCart" data-bookid="{{$book->id}}">Add to cart</button>
                        </div>
                        @include('layouts.singleBookTableInfo', ['book' => $book])
                        <div class="reviews-block">
                            <div class="head-reviews flexible">
                                <h3>Community Reviews</h3>
                                @include('layouts.rateBook', ['user' => $user, 'book' => $book])
                            </div>
                            @include('layouts.leaveReview', ['user' => $user, 'book' => $book])
                            <div class="reviews">
                                @if(count($book->reviews) > 0)
                                @foreach($book->reviews as $review)
                                    @include('layouts.mainReview', ['user' => $user, 'book' => $book, 'review' => $review])
                                @endforeach
                                @else
                                    <p class="no-reviews">No one has left the review. @if(!isset($user)) <button onclick="showModalAuth();" class="bt-login">Be the first!</button> @endif</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <aside class="main-singlebook-aside">
                <h3 class="head">Related Books</h3>
                <div class="realted-books-container flexible">                    
                    @foreach($relatedBooks as $relBook)
                        @include('layouts.relatedBook', ['book' => $relBook])
                    @endforeach                    
                </div>
            </aside>
        </div>
    </main>
@endsection



