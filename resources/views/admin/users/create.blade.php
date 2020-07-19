@extends('admin.layout')

@section('title', 'Create')

@section('content')

    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h5>Create User</h5>
        </div>
        <div class="card-body">

            @include('alert-message')

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                @include('admin.users.form')

                <!-- Submit Form Button -->
                <div class="form-footer pt-5 border-top">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>

@endsection
