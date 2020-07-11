<p class="text-primary mt-4">Product Variants</p>
<hr/>
@foreach ($product->variants as $variant)

    <input type="hidden" name="variants[{{ $variant->id }}][id]" value="{{ $variant->id }}">
    <div class="row">

        <div class="col-md-2">
            <div class="form-group">
                <div class="form-group">
                    <label for="sku">SKU :</label>
                    <input type="text" class="form-control" name="variants[{{$variant->id}}][sku]" value="{{ $variant->sku }}">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" class="form-control" name="variants[{{$variant->id}}][name]" value="{{ $variant->name }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="price">Price :</label>
                <input type="text" class="form-control" name="variants[{{$variant->id}}][price]" value="{{ $variant->price }}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="qty">Stock :</label>
                <input type="text" class="form-control" name="variants[{{$variant->id}}][qty]" value="{{ ($variant->productInventory) ? $variant->productInventory->qty : null }}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="weight">Weight :</label>
                <input type="text" class="form-control" name="variants[{{$variant->id}}][weight]" value="{{ $variant->weight }}" required>
            </div>
        </div>
    </div>
@endforeach
<hr/>
