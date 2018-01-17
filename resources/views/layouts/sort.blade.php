<h3 class="head">Sort by</h3>
<div class="main-radio-toolbar main-radio-toolbar-sort aside-category flexible">
    @php $i = 1 @endphp
    @foreach($sort_items as $sort_item)
        <input type="radio" id="sort{{$i}}" name="sort_item" value="{{$sort_item}}" {{$chosen_sort == $sort_item ? 'checked' : ''}}>
        <label for="sort{{$i}}">{{$sort_item}}</label>
        @php $i++ @endphp
    @endforeach
</div>