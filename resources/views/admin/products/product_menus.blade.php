<div class="card card-default">

    <div class="card-header card-header-border-bottom">
        <h5>Product Menus</h5>
    </div>

    <div class="card-body">
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ isset($productID) ? url('admin/products/'. $productID .'/edit') : '#' }}">Product Detail</a>
            <a class="nav-link" href="{{ isset($productID) ? url('admin/products/'. $productID .'/images') : '#' }}">Product Images</a>
        </nav>
    </div>

</div>
