@extends('admin.layout')

@section('content')

    @php
        $formTitle = isset($product) ? 'Update' : 'New'
    @endphp

    <div class="row">

        <div class="col-lg-3">
            @include('admin.products.product_menus')
        </div>

        <div class="col-lg-9">
            <div class="card card-default">

                <div class="card-header card-header-border-bottom">
                    <h5>{{ $formTitle }} Product</h5>
                </div>

                <div class="card-body">

                    @include('alert-message')

                    <?php $url = (isset($product)) ? 'admin/products/'.$product->id : 'admin/products'; ?>

                    <form action="{{ url($url) }}" method="POST">
                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif
                        <input type="hidden" name="id" value="{{ isset($product) ? $product->id : ''}}">

                        <div class="form-group">
                            <label for="type">Select Product Type:</label>
                            <select class="form-control product-type" name="type" id="type">
                                    @foreach($types as $key => $value)
                                        <option {{ isset($product) && ($product->type == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU :</label>
                            <input type="text" class="form-control" name="sku" id="sku" value="{{ isset($product) ? $product->sku : '' }}" placeholder="SKU">
                        </div>

                        <div class="form-group">
                            <label for="name">Name :</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ isset($product) ? $product->name : '' }}" placeholder="Name">
                        </div>


                        <div class="form-group">
                            <label for="category_ids">Category :</label>
                            {!! General::selectMultiLevel('category_ids[]', $categories, ['class' => 'form-control', 'multiple' => true, 'selected' => !empty(old('category_ids')) ? old('category_ids') : $categoryIDs, 'placeholder' => '-- Choose Category --']) !!}
                        </div>

                        <div class="configurable-attributes">
                            @if (!empty($configurableAttributes) && !isset($product))
                                <p class="text-primary mt-4">Configurable Attributessssssssssss</p>
                                <hr/>
                                @foreach ($configurableAttributes as $attribute)

                                    <div class="form-group">
                                        <label for="{{ $attribute->code }}">{{ $attribute->name }}:</label>
                                        <select class="form-control" name="{{ $attribute->code }}[]" multiple>
                                            @foreach($attribute->attributeOptions as $attr)
                                                <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                @endforeach
                            @endif
                        </div>

                        @if (isset($product))
                            @if ($product->type == 'configurable')
                                @include('admin.products.configurable')
                            @else
                                @include('admin.products.simple')
                            @endif

                            <div class="form-group">
                                <label for="short_description">Short Description :</label>
                                <textarea class="form-control" rows="5" name="short_description" id="short_description">{{ isset($product) ? $product->short_description : '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="description">Description :</label>
                                <textarea class="form-control" rows="5" name="description" id="description">{{ isset($product) ? $product->description : '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="status">Select Status:</label>
                                <select class="form-control" name="status" id="status">
                                    @foreach($statuses as $key => $value)
                                        <option {{ ($product->status == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-footer pt-5 border-top">
                            <button type="submit" class="btn btn-primary btn-default">Save</button>
                            <a href="{{ url('admin/products') }}" class="btn btn-secondary btn-default">Back</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
