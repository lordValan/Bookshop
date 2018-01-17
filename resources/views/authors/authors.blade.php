@extends('layouts.app')

@section('title', 'Authors')
@section('content')
    <main>
        <div class="main-allauthors-block flexible rewidth">
            <aside class="main-search-aside">
                <form action="/authors">
                    @include('layouts.genres', ['genres' => $search_items['genres'], 'chosen_genre' => $search_items['chosen_genre']])
                    @include('layouts.sort', ['sort_items' => $search_items['sort_items'], 'chosen_sort' => $search_items['chosen_sort']])
                    <button type="submit" class="btn" id="btnSearch">Search</button>
                </form>
            </aside>
            <div class="main-search-content">
                @if(count($authors) > 0)
                <h3 class="head">Authors</h3>
                <div class="main-authors flexible">
                    @foreach($authors as $author)
                        @include('layouts.mainAuthor', ['author' => $author])
                    @endforeach
                </div>
                @endif
                @include('layouts.pagination', ['pagination' => $pagination, 'link' => $link])
            </div>
        </div>
    </main>
@endsection