@extends('front.layout')

@section('title', 'Profile')

@section('content')

    <!-- ========================= Section breadcrumb ========================= -->
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">My account</h2>
        </div>
    </section>

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content padding-y">
        <div class="container">

            <div class="row">

                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" data-toggle="pill" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Account overview</a>

                        <a class="nav-link" data-toggle="pill" href="#orders" role="tab" aria-controls="orders" aria-selected="false">My Orders</a>

                        <a class="nav-link" data-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                    </div>
                </div>

                <div class="col-9">

                    @include('alert-message')

                    <div class="tab-content" id="v-pills-tabContent">

                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <article class="card mb-3">
                                <div class="card-body">

                                    <figure class="icontext">
                                        <div class="icon">
                                            <img class="rounded-circle img-sm border" src="https://via.placeholder.com/75">
                                        </div>
                                        <div class="text d-flex flex-column">
                                            <strong> {{ ucfirst($user->name) }} </strong>
                                            <span>{{ $user->email }}</span>
                                            <span class="text-muted">{{ $user->created_at }}</span>
                                        </div>
                                    </figure>
                                    <hr>
                                    @if($user->userDetail->address1)
                                        <p>
                                            <i class="fa fa-map-marker text-muted"></i> &nbsp; My address:
                                            <br>
                                            {{ $user->userDetail->address1 }}
                                        </p>
                                    @endif


                                    <article class="card-group">
                                        <figure class="card bg">
                                            <div class="p-3">
                                                <h5 class="card-title">{{ $user->orders->count() }}</h5>
                                                <span>Orders</span>
                                            </div>
                                        </figure>
                                        <figure class="card bg">
                                            <div class="p-3">
                                                <h5 class="card-title">5</h5>
                                                <span>Wishlists</span>
                                            </div>
                                        </figure>
                                        <figure class="card bg">
                                            <div class="p-3">
                                                <h5 class="card-title">12</h5>
                                                <span>Awaiting delivery</span>
                                            </div>
                                        </figure>
                                        <figure class="card bg">
                                            <div class="p-3">
                                                <h5 class="card-title">50</h5>
                                                <span>Delivered items</span>
                                            </div>
                                        </figure>
                                    </article>


                                </div>
                            </article>
                        </div>

                        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <article class="card  mb-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Orders </h5>

                                        @forelse($user->orders as $order)
                                            <div class="row my-4 justify-content-between align-items-center">

                                                <div class="col-md-2 ">On {{ $order->created_at }}</div>

                                                <div class="col-md-10  d-flex align-items-center">

                                                    @foreach($order->orderItems as $item)
                                                        <div class="mb-3 d-flex mx-2">
                                                            <div class="aside">
                                                                @if ($item->product->productImages->first())
                                                                    <img src="{{ asset('storage/'.$item->product->productImages->first()->path) }}" alt="{{ $item->product->name }}" class="border img-sm">
                                                                @else
                                                                    <img src="https://via.placeholder.com/150" alt="{{ $item->product->name }}">
                                                                @endif
                                                            </div>
                                                            <div class="info ml-2">
                                                                <time class="text-muted">
                                                                    <i class="fa fa-calendar-alt"></i>
                                                                    {{ $item->qty }} x
                                                                </time>
                                                                <p>{{ ucfirst($item->product->name) }} </p>
                                                                <span class="text-warning">{{ $order->shipment->status }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>
                                        @empty
                                            You haven't ordered yet
                                        @endforelse


                                    <a href="#" class="btn btn-outline-primary"> See all orders  </a>
                                </div>
                            </article>
                        </div>

                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <form action="{{ route('profile') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="address1">Address 1:</label>
                                    <textarea class="form-control" name="address1">{{ $user->userDetail->address1 }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="address1">Address 2:</label>
                                    <textarea class="form-control" name="address2">{{ $user->userDetail->address2 }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="phone1">Phone 1:</label>
                                    <input type="text" class="form-control" name="phone1" placeholder="Enter Phone 1" value="{{ $user->userDetail->phone1 }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone2">Phone 2:</label>
                                    <input type="text" class="form-control" name="phone2" placeholder="Enter Phone 2" value="{{ $user->userDetail->phone2 }}">
                                </div>

                                <button type="submit" class="btn btn-primary px-4 float-right">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
