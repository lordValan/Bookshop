@extends('layouts.app')

@section('title', 'Books')
@section('content')
    <main>
        <div class="main-allBooks-block flexible rewidth">
            <aside class="main-search-aside">
                <form action="/books">
                    @include('layouts.genres', ['genres' => $search_items['genres'], 'chosen_genre' => $search_items['chosen_genre']])
                    @include('layouts.sort', ['sort_items' => $search_items['sort_items'], 'chosen_sort' => $search_items['chosen_sort']])
                    <button type="submit" class="btn" id="btnSearch">Search</button>
                </form>
            </aside>
            <div class="main-search-content">
                @if(count($books) > 0)
                <h3 class="head">Books</h3>
                <div class="main-books flexible">
                    @foreach($books as $book)
                        @include('layouts.mainBook', ['book' => $book])
                    @endforeach
                </div>
                @endif
                @include('layouts.pagination', ['pagination' => $pagination, 'link' => $link])
            </div>
        </div>
    </main>
@endsection