@extends('admin.layout')

@section('content')

    <div class="card card-default">

        <div class="card-header card-header-border-bottom">
            <h5>Attributes</h5>
        </div>

        <div class="card-body">

            @include('alert-message')

            <table class="table table-bordered table-stripped">
                <thead>
                    <th>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Action</th>
                </thead>
                <tbody>
                @forelse ($attributes as $attribute)
                    <tr>
                        <td>{{ $attribute->id }}</td>
                        <td>{{ $attribute->code }}</td>
                        <td>{{ $attribute->name }}</td>
                        <td>{{ $attribute->type }}</td>
                        <td>
                            <form action="{{ url('admin/attributes/'.$attribute->id) }}" method="POST">
                                @can('show_attributes')
                                    <a href="{{ url('admin/attributes/'.$attribute->id) }}" class="btn btn-info btn-sm" title="Show Attribute">Show</a>
                                @endcan

                                @can('edit_attributes')
                                    <a href="{{ url('admin/attributes/'.$attribute->id .'/edit') }}" class="btn btn-primary btn-sm" title="Edit Attribute">Edit</a>
                                @endcan

                                @can('add_attributes')
                                    @if ($attribute->type == 'select')
                                        <a href="{{ url('admin/attributes/'. $attribute->id .'/options') }}" class="btn btn-success btn-sm">options</a>
                                    @endif
                                @endcan

                                @csrf
                                @method('DELETE')

                                @can('delete_attributes')
                                    <button type="submit" title="Delete Attribute" class="delete btn btn-danger btn-sm">Delete</button>
                                @endcan
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
            {{ $attributes->links() }}
        </div>

        @can('add_attributes')
            <div class="card-footer text-right">
                <a href="{{ url('admin/attributes/create') }}" class="btn btn-primary">Add New</a>
            </div>
        @endcan
    </div>


@endsection
