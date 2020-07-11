<div class="card card-default">

    <div class="card-header card-header-border-bottom">
        <h2>{{ isset($option) ? 'Edit' : 'Add' }} Option</h2>
    </div>

    <div class="card-body">

        @include('admin.partials.flash', ['$errors' => $errors])

        <?php $url = (isset($option)) ? 'admin/attributes/options/'.$option->id : 'admin/attributes/options/'.$attribute->id; ?>

        <form action="{{ url($url) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($option))
                @method('PUT')
            @endif

            <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">

            <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ isset($option) ? $option->name : '' }}" placeholder="Name">
            </div>

            <div class="form-footer pt-5 border-top">
                <button type="submit" class="btn btn-primary btn-default">Save</button>
                <a href="{{ url('admin/attributes/') }}" class="btn btn-secondary btn-default">Back</a>
            </div>
        </form>

    </div>

</div>
