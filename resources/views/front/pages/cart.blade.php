@extends('front.layout')

@section('content')

    <!-- ========================= SECTION Breadcrumb ========================= -->
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Shopping cart</h2>
        </div>
    </section>

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y">
        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    @if (Session::has('message'))
                        <p class="alert alert-success">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>

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
                                        <tr>
                                            <td>
                                                <figure class="itemside">
                                                    <div class="aside">
                                                        <img src="https://via.placeholder.com/150" class="img-sm">
                                                    </div>
                                                    <figcaption class="info">
                                                        <a href="#" class="title text-dark">{{ Str::words($item->name,20) }}</a>
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
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price">{{ $item->price . config('shopping_cart.currency_symbol') }}</var>
                                                    <small class="text-muted">each</small>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <a data-original-title="Save to Wishlist" title="" href="" class="btn btn-light" data-toggle="tooltip"> <i class="fa fa-heart"></i></a>
                                                <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-light"> Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="card-body border-top">
                                    <a href="{{ route('checkout') }}" class="btn btn-primary float-md-right">
                                        Make Purchase <i class="fa fa-chevron-right"></i>
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
                                <dt>Total price:</dt>
                                <dd class="text-right">{{ \Cart::getSubTotal() }} {{ config('shopping_cart.currency_symbol') }}</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Discount:</dt>
                                <dd class="text-right">USD 658</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Total:</dt>
                                <dd class="text-right  h5"><strong>$1,650</strong></dd>
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
