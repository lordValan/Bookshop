<table class="book-info-table">
	<tr>
		<td>Book Title</td>
		<td>{{$book->title}}</td>
	</tr>
	<tr>
		<td>Author</td>
		<td>
			<a href="{{url('authors/' . $book->author->id)}}">{{$book->author->first_name . ' ' . $book->author->last_name}}</a>
		</td>
	</tr>
	<tr>
		<td>ISBN</td>
		<td>{{$book->isbn}}</td>
	</tr>
	<tr>
		<td>Book Format</td>
		<td>Paperback, {{$book->pages_amount}} pages</td>
	</tr>
	<tr>
		<td>Year Published</td>
		<td>{{$book->publish_year}}</td>
	</tr>
	<tr>
		<td>Edition Language</td>
		<td>English</td>
	</tr>
	<tr>
		<td>Genres</td>
		<td class="cell-genres">
			@foreach($book->genres as $genre)
			<a href="{{url('genres/' . $genre->id)}}">{{$genre->title}}</a> @endforeach
		</td>
	</tr>
</table>