@extends('layouts.app')

@section('title', $author->first_name.' '.$author->last_name)
@section('content')
    <div class="person-container author-container">
        <div class="person-block flexible rewidth">
            <div class="main-person flexible">
                <div class="person-photo-container" style="background-image: url('{{ File::exists(public_path() . '/images/authors/' . $author->photo) ? URL::asset('/images/authors/' . $author->photo) : URL::asset('/images/other/unknown.png')}}');">&nbsp;</div>
                <div class="person-info-container flexible">
                    <h3 class="person-name">{{$author->first_name.' '.$author->last_name}}</h3>
                    <p class="authors-books-amount">{{count($author->books) . (count($author->books) > 1 ? ' books' : ' book')}}</p>
                    <div class="person-bio">
                        <p>{{$author->biography}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="authors-books rewidth">
            <h3 class="head">All Author's books</h3>
            <div class="main-author-books-container">
                @foreach($author->books as $book)
                    @include('layouts.mainBook', ['book' => $book])
                @endforeach
            </div>
        </div>
    </div>
    </main>
@endsection



