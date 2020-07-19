@extends('admin.layout')

@section('content')
    <div class="row">

        <div class="col-lg-4">
            @include('admin.products.product_menus')
        </div>

        <div class="col-lg-8">
            <div class="card card-default">

                <div class="card-header card-header-border-bottom">
                    <h5>Upload Images</h5>
                </div>

                <div class="card-body">

                    @include('alert-message')

                    <form action="{{ url('admin/products/images/'. $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="image">Select Image</label>
                            <input type="file" name="image" class="form-control-file" id="image">
                        </div>

{{--                            <div class="custom-file">--}}
{{--                                <input type="file" class="custom-file-input" name="image" id="image" required>--}}
{{--                                <label class="custom-file-label" for="image">Product Image</label>--}}
{{--                                <div class="invalid-feedback">Example invalid custom file feedback</div>--}}
{{--                            </div>--}}

                        <div class="form-footer pt-5 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Save</button>
                            <a href="{{ url('admin/products/'.$productID.'/images') }}" class="btn btn-secondary btn-default">Back</a>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
