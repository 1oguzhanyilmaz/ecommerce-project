@extends('front.layout')

@section('content')

    <!-- ========================= SECTION Breadcrumb ========================= -->
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Checkout</h2>
        </div>
    </section>

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y">
        <div class="container">

            @include('alert-message')

            <form action="{{ route('orders.checkout.place.order') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Address #### -->
                    <main class="col-md-8">

                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" placeholder="First Name" class="form-control" name="first_name">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Last Name" class="form-control" name="last_name">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Phone" name="phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="email" placeholder="Email" name="email" class="form-control">
                                </div>
                            </div>

                            <aside class="col-6">

                                <div class="form-group">
                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address"></textarea>
                                    <small class="form-text text-muted"> Maximum character is 250 letters </small>
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="note" id="note" rows="3" placeholder="Order Note?"></textarea>
                                </div>
                            </aside>

                            <div class="col-md-12">
                                <label class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" type="checkbox" checked="">
                                    <div class="custom-control-label">Checked</div>
                                </label>
                            </div>

                        </div>

                    </main>

                    <!-- Cart Summary -->
                    <aside class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Your Cart</label>
                                </div>

                                @forelse ($items as $item)
                                    @php
                                        $product = $item->associatedModel;
                                        $image = !empty($product->productImages->first()) ? asset('storage/'.$product->productImages->first()->path) : asset('https://via.placeholder.com/50')
                                    @endphp
                                    <dl class="dlist-align">
                                        <dt>{{ $item->name }} <span class="product-quantity"> × {{ $item->quantity }}</span></dt>
                                        <dd class="text-right">{{ number_format(\Cart::get($item->id)->getPriceSum()) }}</dd>
                                    </dl>

                                @empty
                                    <p>The cart is empty! </p>
                                @endforelse

                                <hr>

                                <dl class="dlist-align">
                                    <dt>Subtotal</dt>
                                    <dd class="text-right">{{ number_format(\Cart::getSubTotal()) }}</dd>
                                </dl>

                                <dl class="dlist-align">
                                    <dt>Tax</dt>
                                    <dd class="text-right">{{ number_format(\Cart::getCondition('TAX 10%')->getCalculatedValue(\Cart::getSubTotal())) }}</dd>
                                </dl>

                                <dl class="dlist-align">
                                    <dt>Shipping Cost ({{ $totalWeight }} kg)</dt>
                                    <dd class="text-right">
                                        <select name="shipping_service" required id="shipping-cost-option">
                                            <option value="0" selected disabled>Select Shipping Service</option>
                                            <option value="shipping-0">Shipping 0</option>
                                            <option value="shipping-1">Shipping 1</option>
                                        </select>
                                    </dd>
                                </dl>

                                <hr>
                                <dl class="dlist-align">
                                    <dt>Order Total</dt>
                                    <dd class="text-right">
                                        <strong>
                                            <span class="total-amount">
                                                {{ number_format(\Cart::getTotal()) }}
                                            </span>
                                        </strong>
                                    </dd>
                                </dl>

                                <hr>
                                <p class="text-center mb-3">
                                    <img src="{{ asset('images/payments.png') }}" height="26">
                                </p>
                            </div>
                        </div>
                    </aside>
                </div>

                <!-- Payment -->
                <div class="row payment-method">
                    <div class="col-md-8">
                        <div id="accordion">

                            <!-- Payment 1 -->
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#payment-1" aria-expanded="true" aria-controls="payment-1">
                                            Direct Bank Transfer
                                        </button>
                                    </h5>
                                </div>
                                <div id="payment-1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment 2 -->
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#payment-2" aria-expanded="false" aria-controls="payment-2">
                                            Cheque Payment
                                        </button>
                                    </h5>
                                </div>
                                <div id="payment-2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment 3 -->
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#payment-3" aria-expanded="false" aria-controls="payment-3">
                                            PayPal
                                        </button>
                                    </h5>
                                </div>
                                <div id="payment-3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary float-md-right">
                            Place Order <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </section>

@endsection
