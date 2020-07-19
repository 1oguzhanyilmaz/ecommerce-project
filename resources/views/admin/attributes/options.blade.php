@extends('admin.layout')

@section('content')

    <div class="row">

        @include('alert-message')

        <div class="col-lg-5">
            @include('admin.attributes.option_form')
        </div>

        <div class="col-lg-7">

            <div class="card card-default">

                <div class="card-header card-header-border-bottom">
                    <h5>Options for : {{ $attribute->name }}</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-stripped">
                        <thead>
                            <th style="width:10%">#</th>
                            <th>Name</th>
                            <th style="width:30%">Action</th>
                        </thead>
                        <tbody>
                            @forelse ($attribute->attributeOptions as $option)
                                <tr>
                                    <td>{{ $option->id }}</td>
                                    <td>{{ $option->name }}</td>
                                    <td>
                                        <form action="{{ url('admin/attributes/options/'.$option->id) }}" method="POST">
                                            @can('show_attributes')
                                                <a href="{{ url('admin/attributes/options/'.$option->id) }}" class="btn btn-info btn-sm" title="Show Attribute Option">Show</a>
                                            @endcan

                                            @can('edit_attributes')
                                                <a href="{{ url('admin/attributes/options/'.$option->id .'/edit') }}" class="btn btn-primary btn-sm" title="Edit Attribute Option">Edit</a>
                                            @endcan

                                            @csrf
                                            @method('DELETE')

                                            @can('delete_attributes')
                                                <button type="submit" title="Delete Attribute Option" class="delete btn btn-danger btn-sm">Delete</button>
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
                </div>
            </div>
        </div>
    </div>
@endsection
