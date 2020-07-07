@extends('admin.layout')

@section('content')

    @php
        $formTitle = !empty($category) ? 'Update' : 'New'
    @endphp

    <div class="content">

        <div class="row">

            <div class="col-lg-6">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>{{ $formTitle }} Category</h2>
                    </div>
                    <div class="card-body">

                        @include('admin.partials.flash', ['$errors' => $errors])

                        <form action="{{ url('admin/categories') }}" method="POST">
                            @csrf
                            @if(!empty($category))
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="name">Name :</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Category Name">
                            </div>

                            <?php $selected = !empty(old('parent_id')) ? old('parent_id') : !empty($category['parent_id']) ? $category['parent_id'] : '' ?>

                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ url('admin/categories') }}" class="btn btn-secondary btn-default">Back</a>
                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
