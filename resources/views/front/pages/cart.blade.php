@extends('front.layout')

@section('title', 'Cart')

@section('content')

    @include('front.partials.navbar')
    @include('front.partials.bread')
    @include('alert-message')

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y">
        <div class="container">

            <div class="row">
                @if ($items->isEmpty())
                    <div class="alert alert-warning col-12">
                        <p class="text-center">Your shopping cart is empty.</p>
                    </div>

                @else
                    <!-- ##### left => Product List #### -->
                    <main class="col-md-9">

                            <div class="card">

                                <table class="table table-borderless table-shopping-cart">
                                    <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col">Product</th>
                                        <th scope="col" width="120">Quantity</th>
                                        <th scope="col" width="120">Price</th>
                                        <th scope="col" class="text-right" width="200"> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $item)
                                        @php
                                            $product = $item->associatedModel;
                                            $image = !empty($product->productImages->first()) ? asset('storage/'.$product->productImages->first()->path) : "https://via.placeholder.com/150"
                                        @endphp

                                        <tr>
                                            <td>
                                                <figure class="itemside">
                                                    <div class="aside">
                                                        <img src="{{ $image }}" class="img-sm" alt="{{ $product->name }}">
                                                    </div>
                                                    <figcaption class="info">
                                                        <a href="{{ route('product.details', $product->slug) }}" class="title text-dark">{{ Str::words($item->name,20) }}</a>
                                                        <p class="text-muted small">
                                                        @foreach($item->attributes as $key  => $value)
                                                            <dl class="dlist-inline small">
                                                                <dt>{{ ucwords($key) }}: </dt>
                                                                <dd>{{ ucwords($value) }}</dd>
                                                            </dl>
                                                        @endforeach
                                                    </figcaption>
                                                </figure>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-light text-primary px-2 decrease-item" data-id="{{ $item->id }}" data-qty="{{ ($item->quantity) - 1 }}">-</a>

                                                {{ $item->quantity }}

                                                <a href="#" class="btn btn-sm btn-outline-light text-primary px-2 increase-item" data-id="{{ $item->id }}" data-qty="{{ ($item->quantity) + 1 }}">+</a>

                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price">{{ $item->price . config('custom.currency_symbol') }}</var>
                                                    <small class="text-muted">each</small>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-light"> Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="card-body border-top">
                                    <a href="{{ route('orders.checkout') }}" class="btn btn-primary float-md-right">
                                        Proceed to checkout <i class="fa fa-chevron-right"></i>
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-light">
                                        <i class="fa fa-chevron-left"></i> Continue shopping
                                    </a>
                                    <a href="{{ route('cart.clear') }}" class="btn btn-light">Clear Cart</a>
                                </div>

                            </div>

                            <div class="alert alert-success mt-3">
                                <p class="icontext"><i class="icon text-success fa fa-truck"></i> Free Delivery within 1-2 weeks</p>
                            </div>

                    </main>

                    <!-- Right Total Price -->
                    <aside class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label>Have coupon?</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="" placeholder="Coupon code">
                                        <span class="input-group-append">
							                <button class="btn btn-primary">Apply</button>
						                </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>Subtotal :</dt>
                                <dd class="text-right">{{ number_format(\Cart::getSubTotal()) }} {{ config('custom.currency_symbol') }}</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Discount:</dt>
                                <dd class="text-right">0 {{ config('custom.currency_symbol') }}</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Total:</dt>
                                <dd class="text-right  h5"><strong>{{ \Cart::getTotal() }} {{ config('custom.currency_symbol') }}</strong></dd>
                            </dl>
                            <hr>
                            <p class="text-center mb-3">
                                <img src="{{ asset('images/payments.png') }}" height="26">
                            </p>

                        </div>
                    </div>
                </aside>
                @endif
            </div>

        </div>
    </section>

@endsection
