<ul class="list-group text-small">
    <li class="list-group-item">
        <h5 class="text-primary">Catalog</h5>
        <ul class="list-group inner-list">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ url('admin/products') }}" class="">Products</a>
                <span class="badge badge-primary badge-pill">12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ url('admin/categories') }}" class="">Categories</a>
                <span class="badge badge-primary badge-pill">12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ url('admin/attributes') }}" class="">Attributes</a>
                <span class="badge badge-primary badge-pill">12</span>
            </li>
        </ul>
    </li>

    <li class="list-group-item">
        <h5 class="text-primary">Orders</h5>
        <ul class="list-group inner-list">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ url('admin/users') }}" class="">Orders</a>
                <span class="badge badge-primary badge-pill">12</span>
            </li>
        </ul>
    </li>

    <li class="list-group-item">
        <h5 class="text-primary">Users & Roles</h5>
        <ul class="list-group inner-list">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ url('admin/users') }}" class="">Users</a>
                <span class="badge badge-primary badge-pill">12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ url('admin/roles') }}" class="">Roles</a>
                <span class="badge badge-primary badge-pill">12</span>
            </li>
        </ul>
    </li>

</ul>
