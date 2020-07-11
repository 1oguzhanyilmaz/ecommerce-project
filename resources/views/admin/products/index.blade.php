@extends('admin.layout')

@section('content')
    <div class="content">

        <div class="row">

            <div class="col-lg-12">

                <div class="card card-default">

                    <div class="card-header card-header-border-bottom">
                        <h2>Products</h2>
                    </div>

                    <div class="card-body">

                        @include('admin.partials.flash')

                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th style="width:15%">Action</th>
                            </thead>
                            <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->type }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format($product->price) }}</td>
                                    <td>{{ $product->status_label() }}</td>
                                    <td>
                                        <form action="{{ url('admin/products/'.$product->id) }}" method="POST" class="d-flex">

                                            @can('show_products')
                                                <a href="{{ url('admin/products/'.$product->id) }}" class="btn btn-info btn-sm" title="Show Product">Show</a>
                                            @endcan

                                            @can('edit_products')
                                                <a href="{{ url('admin/products/'.$product->id .'/edit') }}" class="btn btn-primary btn-sm" title="Edit Product">Edit</a>
                                            @endcan

                                            @csrf
                                            @method('DELETE')

                                            @can('delete_products')
                                                <button type="submit" title="Delete Product" class="delete btn btn-danger btn-sm">Delete</button>
                                            @endcan

                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No records found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $products->links() }}

                    </div>

                    @can('add_products')
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/products/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
