@php $percentoff = $book->sale_percent ? $book->sale_percent->percentoff : 0; @endphp
<div class="book-cover-container">
	<img class="book-cover" src="{{ File::exists(public_path() . '/images/books/' . $book->cover_name) ? URL::asset('/images/books/' . $book->cover_name) : URL::asset('/images/other/book-no-cover.jpg')}}">
</div>
<div class="book-info-container flexible" data-rates-amount="">
	<h3 class="book-title">{{$book->title}}</h3>
	<p class="book-author">Author:
		<a href="{{url('authors/' . $book->author->id)}}">{{$book->author->first_name . ' ' . $book->author->last_name}}</a>
	</p>
	<div class="rating-block flexible">
		@include('layouts.bookBarrating', ['id' => 'book-rating', 'class' => '', 'bookRating' => $bookRating])
		<span id="book-reviews-amount">{{count($book->ratings)}} reviews</span>
	</div>
	<div class="book-price">
		@if($percentoff > 0)
		<span class="old-book-price">{{$book->price}}$</span>
		<span class="sale-book-price">{{number_format($book->getCurrentPrice(), 2)}}$</span>
		@else
		<span class="current-price">{{$book->price}}$</span>
		@endif
	</div>
	<!-- .expanded -->
	<p class="book-description fold">{{$book->description}}</p>
	<span class="showMoreLessBt">View More</span>
</div>