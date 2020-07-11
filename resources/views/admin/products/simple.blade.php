<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="price">Price :</label>
            <input type="text" class="form-control" name="price" id="price" value="{{ isset($product) ? $product->price : '' }}" placeholder="Price">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="weight">Weight :</label>
            <input type="text" class="form-control" name="weight" id="weight" value="{{ isset($product) ? $product->weight : '' }}" placeholder="Weight">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="qty">Quantity :</label>
            <input type="text" class="form-control" name="qty" id="qty" value="{{ isset($product) ? $product->qty : '' }}" placeholder="Quantity">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="length">Length :</label>
            <input type="text" class="form-control" name="length" id="length" value="{{ isset($product) ? $product->length : '' }}" placeholder="Length">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="width">Width :</label>
            <input type="text" class="form-control" name="width" id="width" value="{{ isset($product) ? $product->width : '' }}" placeholder="Width">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="height">Height :</label>
            <input type="text" class="form-control" name="height" id="height" value="{{ isset($product) ? $product->height : '' }}" placeholder="Height">
        </div>
    </div>
</div>
