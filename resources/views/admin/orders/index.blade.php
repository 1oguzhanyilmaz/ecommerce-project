@extends('admin.layout')

@section('content')

    <div class="card card-default">

        <div class="card-header card-header-border-bottom">
            <h5>Orders</h5>
        </div>

        <div class="card-body">

            @include('alert-message')

            @include('admin.orders.filter')

            <table class="table table-bordered table-stripped">
                <thead>
                    <th>Order ID</th>
                    <th>Grand Total</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                </thead>
                <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->code }} <br><span style="font-size: 12px; font-weight: normal"> {{\General::datetimeFormat($order->order_date) }}</span></td>
                        <td>{{\General::priceFormat($order->grand_total) }}</td>
                        <td>{{ $order->customer_full_name }} <br><span style="font-size: 12px; font-weight: normal"> {{ $order->customer_email }}</span></td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->payment_status }}</td>
                        <td>
                            @can('edit_orders')
                                <a href="{{ url('admin/orders/'. $order->id) }}" class="btn btn-primary btn-sm" title="Show Order">Show</a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No records found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>

    </div>


@endsection
