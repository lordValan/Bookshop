@php $authorName = $author->first_name.' '.$author->last_name; @endphp
<div class="main-author flexible">
    <a href="{{url('authors/' . $author->id)}}">
        <div class="person-photo-container" style="background-image: url('{{ File::exists(public_path() . '/images/authors/' . $author->photo) ? URL::asset('/images/authors/' . $author->photo) : URL::asset('/images/other/unknown.png')}}');">&nbsp;</div>
    </a>
    <div class="author-info-container flexible">
        <a href="{{url('authors/' . $author->id)}}"><h3 class="author-name">{{strlen($authorName) < 20 ? $authorName : substr($authorName, 0, 15).'...'}}</h3></a>
        <p class="author-books-amount">{{count($author->books)}} books</p>
    </div>
</div>