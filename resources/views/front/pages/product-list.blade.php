@extends('front.layout')

@section('title', 'Product List')

@section('content')

    @include('front.partials.navbar')
    @include('front.partials.bread')
    @include('alert-message')

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y">
        <div class="container">

            <div class="row">
                <!-- ########## Filter Side ########## -->
                <aside class="col-md-3">

                    <div class="card">
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true" class="">
                                    <i class="icon-control fa fa-chevron-down"></i>
                                    <h6 class="title">Product type</h6>
                                </a>
                            </header>

                            <div class="filter-content collapse show" id="collapse_1" style="">
                                <div class="card-body">

                                    <form action="{{ url('products') }}" method="GET" class="pb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="q" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-light" type="submit"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>

                                    <ul class="list-menu">
                                        <li><a href="#">Watches </a></li>
                                        <li><a href="#">Cinema  </a></li>
                                    </ul>

                                </div>
                            </div>
                        </article>


                        @if ($categories)
                            <article class="filter-group">
                                <header class="card-header">
                                    <a href="#" data-toggle="collapse" data-target="#collapse_categories" aria-expanded="true" class="">
                                        <i class="icon-control fa fa-chevron-down"></i>
                                        <h6 class="title">Categories {{ Request::get('category') }}</h6>
                                    </a>
                                </header>

                                <div class="filter-content collapse show" id="collapse_categories" style="">
                                    <div class="card-body">
                                            @foreach ($categories as $category)
                                                <label class="custom-control custom-checkbox">
                                                    <a href="{{ url('products?category='. $category->slug) }}">
                                                        <input type="checkbox" {{ (Request::get('category') == $category->slug) ?  'checked' : '' }} class="custom-control-input">
                                                        <div class="custom-control-label">{{ $category->name }}
                                                            <b class="badge badge-pill badge-light float-right">{{ $category->products->count() }}</b>  </div>
                                                    </a>
                                                </label>
                                            @endforeach
                                    </div>
                                </div>
                            </article>
                        @endif

                        <!-- price range -->
                        <form method="GET" action="{{ url('products')}}">
                            <article class="filter-group">
                                <header class="card-header">
                                    <a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class="">
                                        <i class="icon-control fa fa-chevron-down"></i>
                                        <h6 class="title">Price range </h6>
                                    </a>
                                </header>
                                <div class="filter-content collapse show" id="collapse_3" style="">
                                    <div class="card-body">
                                        <input type="range" class="custom-range" min="0" max="100" name="price">
                                        <input type="hidden" id="productMinPrice" value="{{ $minPrice }}"/>
                                        <input type="hidden" id="productMaxPrice" value="{{ $maxPrice }}"/>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Min</label>
                                                <input class="form-control" placeholder="{{ $minPrice }}" type="number" name="minPrice">
                                            </div>
                                            <div class="form-group text-right col-md-6">
                                                <label>Max</label>
                                                <input class="form-control" placeholder="{{ $maxPrice }}" type="number" name="maxPrice">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-block btn-primary">Apply</button>
                                    </div>
                                </div>
                            </article>
                        </form>

                        <!-- attributes -->
                        <article class="filter-group">
                            <header class="card-header">
                                <a href="#" data-toggle="collapse" data-target="#collapse_4" aria-expanded="true" class="">
                                    <i class="icon-control fa fa-chevron-down"></i>
                                    <h6 class="title">Sizes </h6>
                                </a>
                            </header>
                            <div class="filter-content collapse show" id="collapse_4" style="">
                                <div class="card-body">
                                    <label class="checkbox-btn">
                                        <input type="checkbox">
                                        <span class="btn btn-light"> XS </span>
                                    </label>

                                    <label class="checkbox-btn">
                                        <input type="checkbox">
                                        <span class="btn btn-light"> SM </span>
                                    </label>

                                    <label class="checkbox-btn">
                                        <input type="checkbox">
                                        <span class="btn btn-light"> LG </span>
                                    </label>

                                    <label class="checkbox-btn">
                                        <input type="checkbox">
                                        <span class="btn btn-light"> XXL </span>
                                    </label>
                                </div>
                            </div>
                        </article>

                    </div>

                </aside>

                <!-- ########## Products Side ########## -->
                <main class="col-md-9">

                    @if(count($products) > 0)

                        <header class="border-bottom mb-4 pb-3">
                            <div class="form-inline">
                                <span class="mr-md-auto">32 Items found </span>
                                <select class="mr-2 form-control">
                                    <option>Latest items</option>
                                    <option>Trending</option>
                                    <option>Most Popular</option>
                                    <option>Cheapest</option>
                                </select>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-outline-secondary active" data-toggle="tooltip" title="List view">
                                        <i class="fa fa-bars"></i></a>
                                    <a href="#" class="btn  btn-outline-secondary" data-toggle="tooltip" title="Grid view">
                                        <i class="fa fa-th"></i></a>
                                </div>
                            </div>
                        </header>

                        @foreach($products as $product)

                            <article class="card card-product-list">
                                <div class="row no-gutters">

                                    <aside class="col-md-3">
                                        <a href="{{ route('product.details', $product->slug) }}" class="img-wrap">
                                            <span class="badge badge-danger"> NEW </span>
                                            @if ($product->productImages->first())
                                                <img src="{{ asset('storage/'.$product->productImages->first()->path) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="https://via.placeholder.com/150" alt="{{ $product->name }}">
                                            @endif
                                        </a>
                                    </aside>

                                    <div class="col-md-6">
                                        <div class="info-main">
                                            <a href="{{ route('product.details', $product->slug) }}" class="h5 title">{{ ucfirst($product->name) }}</a>
                                            <div class="rating-wrap mb-3">
                                                <ul class="rating-stars">
                                                    <li style="width:80%" class="stars-active">
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </li>
                                                </ul>
                                                <div class="label-rating">7/10</div>
                                            </div>

                                            <p> {{ ($product->short_description) ? $product->short_description : 'Product Short Description' }}</p>
                                        </div>
                                    </div>
                                    <aside class="col-sm-3">
                                        <div class="info-aside">
                                            <div class="price-wrap">
                                                <span class="price h5"> {{ number_format($product->priceLabel()) }} {{ config('custom.currency_symbol') }}</span>
                                                <del class="price-old"> {{ number_format($product->priceLabel()) }} {{ config('custom.currency_symbol') }}</del>
                                            </div>
                                            <p class="text-success">Free shipping</p>
                                            <br>
                                            <p>
                                                <a href="{{ route('product.details', $product->slug) }}" class="btn btn-primary btn-block">Details</a>

                                                <a class="btn btn-light btn-block animate-left add-to-cart" title="Wishlist"  product-slug="{{ $product->slug }}" href="" product-id="{{ $product->id }}" product-type="{{ $product->type }}" product-slug="{{ $product->slug }}">
                                                    <i class="fa fa-shopping-cart"></i>
                                                    <span class="text">Add to cart</span>
                                                </a>
                                            </p>
                                        </div>
                                    </aside>
                                </div>
                            </article>

                        @endforeach

                            <!-- ### Pagination ### -->
                            <nav aria-label="Page navigation sample">
                                <ul class="pagination">
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>

                            {{--                    {{ $products->links() }}--}}
                    @else
                        <h4 class="text-center">No Products found</h4>
                    @endif

                </main>
            </div>
        </div>
    </section>

@endsection
