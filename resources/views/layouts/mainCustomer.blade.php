<div class="main-customer @if($is_active) main-customer-active @endif">
	<img src="{{'./images/customers/' . $customer->photo}}" alt="customer" class="customer-photo">
	<h4 class="customer-name">{{$customer->name}}</h4>
	<p class="customer-status">{{$customer->status}}</p>
	<p class="customer-comment">{{$customer->opinion}}</p>
</div>