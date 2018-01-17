@php 
    $photo = '/images/users/user' . $review->user->id . '.jpg'; 
    $revDate = new DateTime($review->created_at);
    $userRating = $review->user->ratings->contains('book_id', $book->id) ? $review->user->ratings->where('book_id', $book->id)->first()->rate : 0;
@endphp
<div class="review flexible">
	<div class="photo-block">
		<a href="{{url('users/' . $review->user->id)}}">
			<img src="{{ File::exists(public_path() . $photo) ? URL::asset($photo) : URL::asset('/images/other/unknown.png')}}">
		</a>
	</div>
	<div class="text-block">
		<div class="review-head-rate flexible">
			<h3 class="review-user-head">
				<a href="{{url('users/' . $review->user->id)}}">{{ $review->user->name }}</a>
			</h3>
			@if($userRating > 0)
			<div class="rating-block flexible">
				<span class="review-rating">Rated it</span>
                @include('layouts.bookBarrating', ['id' => '', 'class' => 'user-rating', 'bookRating' => $userRating])
			</div>
			@endif
		</div>
		<p class="review-date">{{$revDate->format('M d, Y')}}</p>
		<p class="review-content">{{$review->review}}</p>
	</div>
</div>