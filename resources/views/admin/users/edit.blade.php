@extends('admin.layout')

@section('title', 'Edit User ' . $user->first_name)

@section('content')
    <div class="content">

        <div class="row">

            <div class="col-lg-12">

                <div class="card card-default">

                    <div class="card-header card-header-border-bottom">
                        <h2>Edit -  {{ $user->name }}</h2>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            @include('admin.users.form')

                            <!-- Submit Form Button -->
                            <div class="form-footer pt-5 border-top">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
