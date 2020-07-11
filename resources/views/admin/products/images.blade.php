@extends('admin.layout')

@section('content')

    <div class="content">

        <div class="row">

            <div class="col-lg-4">
                @include('admin.products.product_menus')
            </div>

            <div class="col-lg-8">
                <div class="card card-default">

                    <div class="card-header card-header-border-bottom">
                        <h2>Product Images</h2>
                    </div>

                    <div class="card-body">

                        @include('admin.partials.flash')

                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Image</th>
                                <th>Uploaded At</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @forelse ($productImages as $image)
                                <tr>
                                    <td>{{ $image->id }}</td>
                                    <td><img src="{{ asset('storage/'.$image->path) }}" style="width:150px"/></td>
                                    <td>{{ $image->created_at }}</td>
                                    <td>
                                        <form action="{{ url('admin/products/images/'.$image->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Image" class="delete btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No records found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ url('admin/products/'.$productID.'/add-image') }}" class="btn btn-primary">Add New</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
