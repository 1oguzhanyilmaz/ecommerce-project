@extends('front.layout')

@section('title', $product->name)

@section('content')

{{--    @include('front.partials.bread')--}}

    @include('alert-message')

    <div class="container">
        <div class="card my-4">
            <div class="row no-gutters">

                <!-- images -->
                <aside class="col-md-6">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap">
                            <div>
                                <a href="#">
                                    <img src="{{ asset('storage/'.$product->productImages->first()->path) }}">
                                </a>
                            </div>
                        </div>

                        <div class="thumbs-wrap">
                            @forelse ($product->productImages as $image)
                                @if ($image->small)
                                    <img src="{{ asset('storage/'.$image->small) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/75" alt="{{ $product->name }}">
                                @endif
                            @empty
                                No image found!
                            @endforelse
                        </div>

                    </article>
                </aside>

                <!-- product -->
                <main class="col-md-6 border-left">
                    <article class="content-body">

                        <h2 class="title">{{ ucfirst($product->name) }}</h2>

                        <div class="rating-wrap my-3">
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
                            <small class="label-rating text-muted">132 reviews</small>
                            <small class="label-rating text-success">
                                <i class="fa fa-clipboard"></i> 154 orders
                            </small>

                            @if($product->productInventory->qty > 0)
                                <small class="label-rating text-success">
                                    <i class="fa fa-star"></i> In stock ({{ $product->productInventory->qty }})
                                </small>
                            @else
                                <small class="label-rating text-danger">
                                    <i class="fa fa-cube"></i> No stock
                                </small>
                            @endif

                        </div>

                        <div class="mb-3">
                            <var class="price h4">{{ number_format($product->priceLabel()) }} {{ config('custom.currency_symbol') }}</var>
                        </div>

                        <p>{{ ($product->short_description) ? $product->short_description : '' }}</p>

                        <hr>

                        <div class="my-4">
                            <p>Categories :
                                @foreach($product->categories as $category)
                                    <a class="btn-link text-muted" href="{{ route('category.products', $category->slug) }}">{{ ucfirst($category->name) }}</a>
                                @endforeach
                            </p>
                        </div>

                        <hr>

                        <div class="my-4">

                            @foreach($attributes as $key => $value)
                                <strong>{{ ucfirst($key) }} : </strong>
                                @foreach($value as $v)
                                    <span>{{ $v }},</span>
                                @endforeach
                                <br>
                            @endforeach

                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md d-flex align-items-center justify-content-start">
                                <label class="m-0 mr-4">Quantity</label>
                                <div class="input-group input-spinner">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-light" type="button" id="button-plus"> + </button>
                                    </div>
                                    <input type="text" class="form-control" value="1">
                                    <div class="input-group-append">
                                        <button class="btn btn-light" type="button" id="button-minus"> − </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md d-flex align-items-center justify-content-start">
                                <label class="m-0 mr-4">Select size</label>
                                <div class="">
                                    <label class="m-0 custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="select_size" checked="" class="custom-control-input">
                                        <div class="custom-control-label">Small</div>
                                    </label>

                                    <label class="m-0 custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="select_size" class="custom-control-input">
                                        <div class="custom-control-label">Medium</div>
                                    </label>

                                    <label class="m-0 custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="select_size" class="custom-control-input">
                                        <div class="custom-control-label">Large</div>
                                    </label>

                                </div>
                            </div>
                        </div>

                        <hr>

                        <a href="#" class="btn btn-primary"> Buy now </a>
                        <a href="" class="btn btn-outline-primary add-to-cart" product-id="{{ $product->id }}" product-type="{{ $product->type }}" product-slug="{{ $product->slug }}">
                            <span class="text">Add to cart</span>
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </article>
                </main>
            </div>
        </div>
        <div class="mt-4 row justify-content-center">
            <div class="col-10">
                {{ $product->description }}
            </div>
        </div>
    </div>

@endsection
