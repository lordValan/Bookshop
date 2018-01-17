@if(isset($user) && !($user->reviews->contains('book_id', $book->id)))
<div class="leave-review-block">
	@php $photoUser = '/images/users/user' . $user->id . '.jpg'; @endphp
	<div class="leave-review-head flexible" onclick="writeUserReview();">
		<div class="leave-review-photo-container">
			<img src="{{ File::exists(public_path() . $photoUser) ? URL::asset($photoUser) : URL::asset('/images/other/unknown.png')}}">
		</div>
		<span class="leave-review-message">Write a review...</span>
		<span class="leave-review-user-name">{{$user->name}}</span>
	</div>
	<div class="leave-review-text-bt">
		<textarea class="leave-review-textarea"></textarea>
		<button type="button" class="leave-review-bt-publish" data-bookid="{{$book->id}}">Publish</button>
	</div>
</div>
@endif