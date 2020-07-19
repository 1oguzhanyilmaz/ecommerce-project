@extends('admin.layout')

@section('content')

    @php
        $formTitle = isset($category) ? 'Update' : 'New'
    @endphp


    <div class="row">

        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h5>{{ $formTitle }} Category</h5>
                </div>
                <div class="card-body">

                    @include('alert-message', ['$errors' => $errors])

                    <?php $url = (isset($category)) ? 'admin/categories/'.$category->id : 'admin/categories'; ?>

                    <form action="{{ url($url) }}" method="POST">
                        @csrf
                        @if(isset($category))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="name">Name :</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Category Name" value="{{ isset($category) ? $category->name : '' }}">
                        </div>

                        <?php $parentId = isset($category) && !is_null($category->parent_id) ? $category->parent_id : ''; ?>
                        <?php $selected = !empty(old('parent_id')) ? old('parent_id') : $parentId; ?>

                        <div class="form-group">

                            {!! General::selectMultiLevel('parent_id',
                                                        $categories,
                                                        ['class' => 'form-control',
                                                            'selected' => $selected,
                                                            'placeholder' => 'Main Category']) !!}
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ url('admin/categories') }}" class="btn btn-secondary btn-default">Back</a>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection
