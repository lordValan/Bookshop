@php $price = $item->book->getCurrentPrice(); @endphp
<tr>
	<td>{{$item->book->title}}</td>
	<td>{{$item->amount}}</td>
	<td>{{$price}}</td>
	<td>{{$price * $item->amount}}</td>
</tr>