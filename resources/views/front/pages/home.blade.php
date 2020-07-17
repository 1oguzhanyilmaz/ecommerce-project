@extends('front.layout')

@section('content')

    @include('front.partials.navbar')
    @include('front.partials.banner')
    @include('front.partials.feature')


    <!-- Popular Products -->
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">
        <div class="container">

            <header class="section-heading">
                <h3 class="section-title">Popular products</h3>
            </header>

            <div class="row">
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="{{ route('product.details', $slug) }}" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Product Name</a>

                            <div class="rating-wrap">
                                <ul class="rating-stars">
                                    <li style="width:80%" class="stars-active">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <span class="label-rating text-muted"> 34 reviws</span>
                            </div>
                            <div class="price mt-1">10 TL</div>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Product Name</a>

                            <div class="rating-wrap">
                                <ul class="rating-stars">
                                    <li style="width:80%" class="stars-active">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <span class="label-rating text-muted"> 34 reviws</span>
                            </div>
                            <div class="price mt-1">10 TL</div>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Product Name</a>

                            <div class="rating-wrap">
                                <ul class="rating-stars">
                                    <li style="width:80%" class="stars-active">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <span class="label-rating text-muted"> 34 reviws</span>
                            </div>
                            <div class="price mt-1">10 TL</div>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Product Name</a>

                            <div class="rating-wrap">
                                <ul class="rating-stars">
                                    <li style="width:80%" class="stars-active">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </li>
                                </ul>
                                <span class="label-rating text-muted"> 34 reviws</span>
                            </div>
                            <div class="price mt-1">10 TL</div>
                        </figcaption>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Recommended Products -->
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-bottom-sm">
        <div class="container">

            <header class="section-heading">
                <a href="#" class="btn btn-outline-primary float-right">See all</a>
                <h3 class="section-title">Recommended</h3>
            </header><!-- sect-heading -->

            <div class="row">
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Just another product name</a>
                            <div class="price mt-1">$179.00</div>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Some item name here</a>
                            <div class="price mt-1">$280.00</div>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Great product name here</a>
                            <div class="price mt-1">$56.00</div>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-3">
                    <div href="#" class="card card-product-grid">
                        <a href="#" class="img-wrap">
                            <img src="https://via.placeholder.com/150">
                        </a>
                        <figcaption class="info-wrap">
                            <a href="#" class="title">Just another product name</a>
                            <div class="price mt-1">$179.00</div>
                        </figcaption>
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