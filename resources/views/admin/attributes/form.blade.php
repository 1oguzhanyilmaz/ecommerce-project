@extends('admin.layout')

@section('content')

    @php
        $formTitle = isset($attribute) ? 'Update' : 'New';
        $disableInput = isset($attribute) ? true : false;
    @endphp

    <div class="content">
        <div class="row">

            <div class="col-lg-6">

                <div class="card card-default">

                    <div class="card-header card-header-border-bottom">
                        <h2>{{ $formTitle }} Attribute</h2>
                    </div>

                    <div class="card-body">

                        @include('admin.partials.flash', ['$errors' => $errors])

                        <?php $url = (isset($attribute)) ? 'admin/attributes/'.$attribute->id : 'admin/attributes'; ?>

                        <form action="{{ url($url) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($attribute))
                                @method('PUT')
                            @endif

                            <!-- ### General ### -->
                            <fieldset class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <legend class="col-form-label pt-0">General</legend>

                                        <div class="form-group">
                                            <label for="code">Code :</label>
                                            <input type="text" class="form-control" name="code" id="code" value="{{ isset($attribute) ? $attribute->code : '' }}" placeholder="Code" {{ $disableInput ? 'readonly' : '' }}>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Name :</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ isset($attribute) ? $attribute->name : '' }}" placeholder="Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="type">Select Set Type</label>
                                            <select class="form-control" name="type" id="type">
                                                @foreach($types as $key => $value)
                                                    <option value="{{ $key }}" {{ isset($attribute) && ($attribute->type == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <!-- ### Validation ### -->
                            <fieldset class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <legend class="col-form-label pt-0">Validation</legend>

                                        <div class="form-group">
                                            <label for="is_required">Is Required ?</label>
                                            <select class="form-control" name="is_required" id="is_required">
                                                @foreach($booleanOptions as $key => $value)
                                                    <option value="{{ $key }}" {{ isset($attribute) && ($attribute->is_required == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="is_unique">Is Unique ?</label>
                                            <select class="form-control" name="is_unique" id="is_unique">
                                                @foreach($booleanOptions as $key => $value)
                                                    <option value="{{ $key }}" {{ isset($attribute) && ($attribute->is_unique == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="validation">Validation</label>
                                            <select class="form-control" name="validation" id="validation">
                                                @foreach($validations as $key => $value)
                                                    <option value="{{ $key }}" {{ isset($attribute) && ($attribute->validation == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <!-- ### Configuration ### -->
                            <fieldset class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <legend class="col-form-label pt-0">Configuration</legend>

                                        <div class="form-group">
                                            <label for="is_configurable">Configurable Product ?</label>
                                            <select class="form-control" name="is_configurable" id="is_configurable">
                                                @foreach($booleanOptions as $key => $value)
                                                    <option value="{{ $key }}" {{ isset($attribute) && ($attribute->is_configurable == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="is_filterable">Filtering Product ?</label>
                                            <select class="form-control" name="is_filterable" id="is_filterable">
                                                @foreach($booleanOptions as $key => $value)
                                                    <option value="{{ $key }}" {{ isset($attribute) && ($attribute->is_filterable == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-footer pt-5 border-top">
                                <button type="submit" class="btn btn-primary btn-default">Save</button>
                                <a href="{{ url('admin/attributes') }}" class="btn btn-secondary btn-default">Back</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
