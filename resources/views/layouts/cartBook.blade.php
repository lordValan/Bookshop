@php $price = $item->book->getCurrentPrice(); @endphp
<tr data-itemid="{{$item->id}}">
    <td>
        <div class="main-book flexible">
            <div class="book-cover-container">
                <a href="{{url('books/' . $item->book->id)}}"><img class="book-cover" src="{{ File::exists(public_path() . '/images/books/' . $item->book->cover_name) ? URL::asset('/images/books/' . $item->book->cover_name) : URL::asset('/images/other/book-no-cover.jpg')}}"></a>
            </div>
            <div class="book-info-container flexible">
                <h3 class="book-title"><a href="{{url('books/' . $item->book->id)}}">{{$item->book->title}}</a></h3>
                <p class="book-author">Author: <a href="/authors/{{$item->book->author->id}}">{{$item->book->author->first_name.' '.$item->book->author->last_name}}</a></p>
            </div>
        </div>
    </td>
    <td>
        <div class="nud-block flexible">
            <button class="buttonReset addChangeBooksAmount btnMinusAmount"><i class="ti ti-angle-down"></i></button>
            <input type="number" value="{{$item->amount}}" min="1" max="10" class="addBooksAmount nudBooksAmount" readonly/>
            <button class="buttonReset addChangeBooksAmount btnPlusAmount"><i class="ti ti-angle-up"></i></button>
        </div>
    </td>
    <td class="price">{{$price}}$</td>
    <td class="price total-item-price">{{number_format($item->amount * $price, 2)}}$</td>
    <td><button class="buttonReset bt-delete-item"><i class="ti-close"></i></button></td>
</tr>