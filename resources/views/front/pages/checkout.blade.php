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

            <div class="row">
                <!-- ##### left => Product List #### -->
                <main class="col-md-9">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" placeholder="Ad" class="form-control" name="firstname">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Last Name" class="form-control" name="lastname">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Phone" name="phone" class="form-control">
                                </div>
                            </div>

                            <aside class="col-6">

                                <div class="form-group">
                                    <textarea class="form-control" name="adress" id="adres" rows="3" placeholder="Adress"></textarea>
                                    <small class="form-text text-muted"> Maximum character is 250 letters </small>
                                </div>
                            </aside>

                            <div class="col-md-12">
                                <label class="custom-control custom-checkbox mb-3">
                                    <input class="custom-control-input" type="checkbox" checked="">
                                    <div class="custom-control-label">Checked</div>
                                </label>
                            </div>

                            <div class="card-body border-top">
                                <button class="btn btn-primary float-md-right">
                                    Place Order <i class="fa fa-chevron-right"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </main>

                <!-- Right Total Price -->
                <aside class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label>Your Cart</label>
                                </div>
                                <dl class="dlist-align">
                                    <dt>Product 1:</dt>
                                    <dd class="text-right">USD 568</dd>
                                </dl>
                                <dl class="dlist-align">
                                    <dt>Product 2:</dt>
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
                            </form>
                        </div>
                    </div>
                </aside>
            </div>

        </div>
    </section>

@endsection
