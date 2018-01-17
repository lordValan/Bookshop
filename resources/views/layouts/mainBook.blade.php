@php 
    $percentoff = $book->sale_percent ? $book->sale_percent->percentoff : 0; 
    $authorName = $book->author->first_name.' '.$book->author->last_name;
@endphp
<div class="main-book flexible" ontouchstart="this.classList.toggle('hover');">
    <div class="book-cover-container">
        @if($percentoff > 0) <span class="sale-book-percent-off">{{$percentoff}}% off</span> @endif
        <a href="{{url('books/' . $book->id)}}"><img class="book-cover" src="{{ File::exists(public_path() . '/images/books/' . $book->cover_name) ? URL::asset('/images/books/' . $book->cover_name) : URL::asset('/images/other/book-no-cover.jpg')}}"></a>
    </div>
    <div class="book-info-container book-info-flip-container flexible">
        <div class="front">
            <h3 class="book-title">{{strlen($book->title) < 15 ? $book->title : substr($book->title, 0, 12).'...'}}</h3>
            <p class="book-author">{{strlen($authorName) < 20 ? $authorName : substr($authorName, 0, 15).'...'}}</p>
            <div class="book-price">
                @if($percentoff > 0)
                    <span class="old-book-price">{{$book->price}}$</span>
                    <span class="sale-book-price">{{number_format($book->getCurrentPrice(), 2)}}$</span>
                @else
                    <span class="current-price">{{$book->price}}$</span>
                @endif
            </div>
        </div>
        <div class="back">
            <a href="{{url('books/' . $book->id)}}"><h3 class="book-title">{{strlen($book->title) < 15 ? $book->title : substr($book->title, 0, 12).'...'}}</h3></a>
            <button type="button" name="btnAddToCart" class="btn btnAddToCart" data-bookid="{{$book->id}}">Add to cart</button>
        </div>
    </div>
</div>