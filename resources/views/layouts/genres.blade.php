<h3 class="head">Search by Genres</h3>
<div class="main-radio-toolbar main-radio-toolbar-genres aside-category flexible">
    @php $i = 1 @endphp
    @foreach($genres as $genre)
        <input type="radio" id="namegenre{{$i}}" name="genre" value="{{$genre}}" {{$chosen_genre == $genre ? 'checked' : ''}}>
        <label for="namegenre{{$i}}">{{$genre}}</label>
        @php $i++ @endphp
    @endforeach
</div>
