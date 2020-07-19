@extends('front.layout')

@section('content')

    @include('front.partials.navbar')

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">
        <div class="container">

            <h1 class="cart-heading mt-4">Your Order:</h1>

            <hr>

            <div class="row">

                <div class="col-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
                    <address>
                        {{ $order->customer_first_name }} {{ $order->customer_last_name }}
                        <br> {{ $order->customer_address }}
                        <br> Email: {{ $order->customer_email }}
                        <br> Phone: {{ $order->customer_phone }}
                    </address>
                </div>

                <div class="col-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Shipment Address</p>
                    <address>
                        {{ $order->shipment->first_name }} {{ $order->shipment->last_name }}
                        <br> {{ $order->shipment->address }}
                        <br> Email: {{ $order->shipment->email }}
                        <br> Phone: {{ $order->shipment->phone }}
                    </address>
                </div>

                <div class="col-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
                    <address>
                        Invoice ID:
                        <span class="text-dark">#{{ $order->code }}</span>
                        <br> {{ \General::datetimeFormat($order->order_date) }}
                        <br> Status: {{ $order->status }}
                        <br> Payment Status: {{ $order->payment_status }}
                        <br> Shipped by: {{ $order->shipping_service_name }}
                    </address>
                </div>

            </div>

            <div class="row my-4">
                <div class="col-md-12">

                    <div class="table-content table-responsive">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{!! \General::showAttributes($item->attributes) !!}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ \General::priceFormat($item->base_price) }}</td>
                                    <td>{{ \General::priceFormat($item->sub_total) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Order item not found!</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <div class="cart-page-total">
                        <ul>
                            <li> Subtotal
                                <span>{{ \General::priceFormat($order->base_total_price) }}</span>
                            </li>
                            <li>Tax (10%)
                                <span>{{ \General::priceFormat($order->tax_amount) }}</span>
                            </li>
                            <li>Shipping Cost
                                <span>{{ \General::priceFormat($order->shipping_cost) }}</span>
                            </li>
                            <li>Total
                                <span>{{ \General::priceFormat($order->grand_total) }}</span>
                            </li>
                        </ul>
                        @if (!$order->isPaid())
                            <a href="#">Proceed to payment</a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================= BRAND SECTION  ========================= -->
    <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                <h3 class="section-title">Our Brands</h3>
            </header>

            <div class="row">
                <div class="col-md-2 col-6">
                    <figure class="box item-logo">
                        <a href="#"><img src="{{ asset('images/brands/1.png') }}"></a>
                        <figcaption class="border-top pt-2">36 Products</figcaption>
                    </figure>
                </div>
                <div class="col-md-2  col-6">
                    <figure class="box item-logo">
                        <a href="#"><img src="{{ asset('images/brands/1.png') }}"></a>
                        <figcaption class="border-top pt-2">980 Products</figcaption>
                    </figure>
                </div>
                <div class="col-md-2  col-6">
                    <figure class="box item-logo">
                        <a href="#"><img src="{{ asset('images/brands/1.png') }}"></a>
                        <figcaption class="border-top pt-2">25 Products</figcaption>
                    </figure>
                </div>
                <div class="col-md-2  col-6">
                    <figure class="box item-logo">
                        <a href="#"><img src="{{ asset('images/brands/1.png') }}"></a>
                        <figcaption class="border-top pt-2">72 Products</figcaption>
                    </figure>
                </div>
                <div class="col-md-2  col-6">
                    <figure class="box item-logo">
                        <a href="#"><img src="{{ asset('images/brands/1.png') }}"></a>
                        <figcaption class="border-top pt-2">41 Products</figcaption>
                    </figure>
                </div>
                <div class="col-md-2  col-6">
                    <figure class="box item-logo">
                        <a href="#"><img src="{{ asset('images/brands/1.png') }}"></a>
                        <figcaption class="border-top pt-2">12 Products</figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================= APP SECTION  ========================= -->
    <section class="section-name padding-y">
        <div class="container">

            <h3 class="mb-3">Download app demo text</h3>

            <a href="#"><img src="{{ asset('images/appstore.png') }}" height="40"></a>
            <a href="#"><img src="{{ asset('images/appstore.png') }}" height="40"></a>

        </div><!-- container // -->
    </section>
@endsection
