@extends('admin.layout')

@section('content')
    <div class="card card-default">

        <div class="card-header card-header-border-bottom">
            <h5>Users</h5>
        </div>

        <div class="card-body">

            @include('alert-message')

            <table class="table table-bordered table-stripped">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Action</th>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->implode('name', ', ') }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
{{--                                        @if (!$user->hasRole('Admin'))--}}
                                <form action="{{ url('admin/users/'.$user->id) }}" method="POST">
                                    @can('edit_users')
                                        <a href="{{ url('admin/users/'.$user->id .'/edit') }}" class="btn btn-primary btn-sm" title="Edit User">Edit</a>
                                    @endcan

                                    @csrf
                                    @method('DELETE')

                                    @can('delete_users')
                                        <button type="submit" title="Delete Product" class="delete btn btn-danger btn-sm">Delete</button>
                                    @endcan
                                </form>
{{--                                        @endif--}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No records found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>

        @can('add_users')
            <div class="card-footer text-right">
                <a href="{{ url('admin/users/create') }}" class="btn btn-primary">Add New</a>
            </div>
        @endcan
    </div>

@endsection
