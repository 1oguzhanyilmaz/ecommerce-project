


@extends('front.layout')

@section('content')

    @include('front.partials.bread')

    <div class="container my-4">
        <div class="row">
            <div class="col-md-10 offset-1">
                <article class="card card-product-list">
                    <div class="row no-gutters">

                        <!-- images -->
                        <aside class="col-md-3">
                            <a href="#" class="img-wrap">
                                <span class="badge badge-danger"> NEW </span>
                                <img src="images/items/3.jpg">
                            </a>
                        </aside>

                        <!-- product info -->
                        <div class="col-md-6">
                            <div class="info-main">
                                <a href="#" class="h5 title"> Great product name goes here  </a>
                                <div class="rating-wrap my-3">
                                    <div class="">
                                        <span class="my-2">Select Color </span>
                                        <select class="mr-2 form-control">
                                            <option>White</option>
                                            <option>Black</option>
                                            <option>Red</option>
                                        </select>
                                    </div>
                                </div>

                                <h6>Attributes goes here</h6>

                                <p> Take it as demo specs, ipsum dolor sit amet, consectetuer adipiscing elit, Lorem ipsum dolor sit amet, consectetuer adipiscing elit, Ut wisi enim ad minim veniam </p>
                            </div>
                        </div>
                        <aside class="col-sm-3">
                            <div class="info-aside">
                                <div class="price-wrap">
                                    <span class="price h5"> $140 </span>
                                    <del class="price-old"> $198</del>
                                </div> <!-- info-price-detail // -->
                                <p class="text-success">Free shipping</p>
                                <br>
                                <p>
                                    <a href="#" class="btn btn-primary btn-block"> Add To Cart </a>
                                    <a href="#" class="btn btn-light btn-block"><i class="fa fa-heart"></i>
                                        <span class="text">Add to wishlist</span>
                                    </a>
                                </p>
                            </div>
                        </aside>
                    </div>
                </article>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-1">
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, deleniti eaque enim est expedita fuga fugit in iure iusto minima molestias officia placeat quas quidem saepe sapiente sit vitae voluptates?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, deleniti eaque enim est expedita fuga fugit in iure iusto minima molestias officia placeat quas quidem saepe sapiente sit vitae voluptates?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, deleniti eaque enim est expedita fuga fugit in iure iusto minima molestias officia placeat quas quidem saepe sapiente sit vitae voluptates?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, deleniti eaque enim est expedita fuga fugit in iure iusto minima molestias officia placeat quas quidem saepe sapiente sit vitae voluptates?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, deleniti eaque enim est expedita fuga fugit in iure iusto minima molestias officia placeat quas quidem saepe sapiente sit vitae voluptates?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, deleniti eaque enim est expedita fuga fugit in iure iusto minima molestias officia placeat quas quidem saepe sapiente sit vitae voluptates?</p>
                </div>
            </div>
        </div>
    </div>

@endsection
