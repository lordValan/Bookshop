@if($pagination['firstPagPage'] != $pagination['lastPagPage'])
<div class="pagination flexible">
    @if($pagination['currPagPage'] > 1) <a href="{{$link . ($pagination['currPagPage'] - 1)}}">Prev</a> @endif
    @for($i = $pagination['firstPagPage']; $i <= $pagination['lastPagPage']; $i++)
        @if($i == $pagination['currPagPage'])
            <span class="pag-num-link pag-active">{{$i}}</span>
        @else
            <a href="{{$link . $i}}" class="pag-num-link">{{$i}}</a>
        @endif
    @endfor
    @if($pagination['currPagPage'] < $pagination['pagesAmount']) <a href="{{$link . ($pagination['currPagPage'] + 1)}}">Next</a> @endif
</div>
@endif