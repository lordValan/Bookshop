@extends('layouts.app')

@section('title', $head_title)
@section('content')
    <main>
        <h3 class="booklist-head">{{$head_title}}</h3>
        @if(count($books) > 0)
        <div class="booklist-result flexible rewidth">
            @foreach($books as $book)
                @include('layouts.mainBook', ['book' => $book])
            @endforeach
        </div>
        @include('layouts.pagination', ['pagination' => $pagination, 'link' => $link])
        @else
        <p class="books-not-found">{{$message}}</p>
        @endif
    </main>
@endsection