<nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">

                @forelse($categories as $category)

                    @php $isChilds = ($category->childs->count() > 0) ? true : false; @endphp
                    @php $dropdown = $isChilds ? 'dropdown' : ''; @endphp
                    @php $dataToggle = $isChilds ? 'data-toggle="dropdown"' : ''; @endphp
                    @php $bars = $isChilds ? '<i class="fa fa-bars"></i>' : ''; @endphp

                    <li class="nav-item {{ $dropdown }}">
                        <a class="nav-link" {!! $dataToggle !!} href="{{ route('category.products', $category->slug) }}">{!! $bars !!} {{ $category->name }}</a>
                        @if($isChilds)
                            <div class="dropdown-menu">
                                @foreach($category->childs as $childCategory)
                                    <a class="dropdown-item" href="{{ route('category.products', $childCategory->slug) }}">{{ $childCategory->name }}</a>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @empty
                    <li class="nav-item">
                        <a class="nav-link" href="#">No Category</a>
                    </li>
                @endforelse

{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong> <i class="fa fa-bars"></i> &nbsp  All category</strong></a>--}}
{{--                    <div class="dropdown-menu">--}}
{{--                        <a class="dropdown-item" href="#">Foods and Drink</a>--}}
{{--                        <a class="dropdown-item" href="#">Home interior</a>--}}
{{--                        <div class="dropdown-divider"></div>--}}
{{--                        <a class="dropdown-item" href="#">Category 1</a>--}}
{{--                        <a class="dropdown-item" href="#">Category 2</a>--}}
{{--                        <a class="dropdown-item" href="#">Category 3</a>--}}
{{--                    </div>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</nav>
