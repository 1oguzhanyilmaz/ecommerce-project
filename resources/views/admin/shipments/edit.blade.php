@extends('admin.layout')

@section('content')
    <div class="row">

        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h5>Order Shipment #{{ $shipment->order->code }}</h5>
                </div>
                <div class="card-body">

                    @include('alert-message')

                    <form action="{{ route('shipments.update', $shipment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="first_name">First name :</label>
                                <input type="text" class="form-control" name="first_name" readonly value="{{ $shipment->first_name }}">
                            </div>
                            <div class="col-6">
                                <label for="last_name">Last name :</label>
                                <input type="text" class="form-control" name="last_name" readonly value="{{ $shipment->last_name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address :</label>
                            <textarea class="form-control" rows="5" name="address" readonly>{{ $shipment->address }}</textarea>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="phone">Phone :</label>
                                <input type="text" class="form-control" name="phone" readonly value="{{ $shipment->phone }}">
                            </div>
                            <div class="col-6">
                                <label for="email">Email :</label>
                                <input type="email" class="form-control" name="email" readonly value="{{ $shipment->email }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="total_qty">Quantity :</label>
                                <input type="text" class="form-control" name="total_qty" readonly value="{{ $shipment->total_qty }}">
                            </div>
                            <div class="col-6">
                                <label for="total_weight">Total Weight :</label>
                                <input type="text" class="form-control" name="total_weight" readonly value="{{ $shipment->total_weight }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="track_number">Track Number :</label>
                            <input type="text" class="form-control" name="track_number" value="">
                        </div>

                        <div class="form-footer pt-5 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Save</button>
                            <a href="{{ url('admin/orders/'. $shipment->order->id) }}" class="btn btn-secondary btn-default">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h5>Detail Order</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-xl-6 col-lg-6">
                            <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
                            <address>
                                {{ $shipment->order->customer_first_name }} {{ $shipment->order->customer_last_name }}
                                <br> {{ $shipment->order->customer_address }}
                                <br> Email: {{ $shipment->order->customer_email }}
                                <br> Phone: {{ $shipment->order->customer_phone }}
                            </address>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
                            <address>
                                ID: <span class="text-dark">#{{ $shipment->order->code }}</span>
                                <br> {{ \General::datetimeFormat($shipment->order->order_date) }}
                                <br> Status: {{ $shipment->order->status }}
                                <br> Payment Status: {{ $shipment->order->payment_status }}
                                <br> Shipped by: {{ $shipment->order->shipping_service_name }}
                            </address>
                        </div>

                    </div>

                    <table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($shipment->order->orderItems as $item)
                            <tr>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ \General::priceFormat($item->sub_total) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Order item not found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="row justify-content-end">
                        <div class="col-lg-5 col-xl-6 col-xl-3 ml-sm-auto">
                            <ul class="list-unstyled mt-4">
                                <li class="mid pb-3 text-dark">Subtotal
                                    <span class="d-inline-block float-right text-default">{{ \General::priceFormat($shipment->order->base_total_price) }}</span>
                                </li>
                                <li class="mid pb-3 text-dark">Tax(10%)
                                    <span class="d-inline-block float-right text-default">{{ \General::priceFormat($shipment->order->tax_amount) }}</span>
                                </li>
                                <li class="mid pb-3 text-dark">Shipping Cost
                                    <span class="d-inline-block float-right text-default">{{ \General::priceFormat($shipment->order->shipping_cost) }}</span>
                                </li>
                                <li class="pb-3 text-dark">Total
                                    <span class="d-inline-block float-right">{{ \General::priceFormat($shipment->order->grand_total) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
