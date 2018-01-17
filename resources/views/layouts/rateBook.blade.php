@if(isset($user))
<div class="rate-book flexible">
	<span class="rate-book-text">You rated it </span>
	@include('layouts.bookBarrating', ['id' => 'rate-book-rating', 'class' => '', 'bookRating' => 0])
	<script type="text/javascript">
		@if($user->ratings->contains('book_id', $book->id))
            setBarratingRead($('#rate-book-rating'), parseFloat({{$user->ratings->where('book_id', $book->id)->first()->rate}}));
        @else
            setBarratingRate($('#rate-book-rating'), {{$book->id}})
        @endif
	</script>
</div>
@endif