@extends('admin.layout')

@section('content')
    <div class="content">

        <div class="row">

            <div class="col-lg-12">

                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Categories</h2>
                    </div>

                    <div class="card-body">

                        @include('admin.partials.flash')

                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->parent ? $category->parent->name : '' }}</td>
                                    <td>
                                        <form action="{{ url('admin/categories/'.$category->id) }}" method="POST">
                                            <a href="{{ url('admin/categories/'.$category->id) }}" class="btn btn-info btn-sm" title="Show Category">Show</a>
                                            <a href="{{ url('admin/categories/'.$category->id .'/edit') }}" class="btn btn-primary btn-sm" title="Edit Category">Edit</a>

                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Category" class="delete btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No records found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{ $categories->links() }}
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ url('admin/categories/create') }}" class="btn btn-primary">Add New</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
