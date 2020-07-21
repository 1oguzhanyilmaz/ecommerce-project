<!-- ========================= SECTION Breadcrumb ========================= -->
<section class="section-pagetop bg">
    <div class="container">
        <nav>
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                @foreach($breadcrumbs as $key => $value)
                    @if($loop->iteration != $loop->count)
                        <li class="breadcrumb-item"><a href="{{ url($key) }}">{{ ucfirst($value) }}</a></li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($value) }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</section>
