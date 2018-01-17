@php 
    $authorName = $book->author->first_name.' '.$book->author->last_name;
@endphp
<div class="main-book flexible">
	<div class="book-cover-container">
		<a href="{{url('books/' . $book->id)}}">
			<img class="book-cover" src="{{ File::exists(public_path() . '/images/books/' . $book->cover_name) ? URL::asset('/images/books/' . $book->cover_name) : URL::asset('/images/other/book-no-cover.jpg')}}">
		</a>
	</div>
	<div class="book-info-container flexible">
		<a href="{{url('books/' . $book->id)}}">
			<h3 class="book-title">{{substr($book->title, 0, 6).'...'}}</h3>
		</a>
		<p class="book-author">
			<a href="{{url('authors/' . $book->author->id)}}">{{substr($authorName, 0, 6).'...'}}</a>
		</p>
		<div class="book-price">
            <span class="current-price">{{$book->getCurrentPrice()}}$</span>
        </div>
	</div>
</div>