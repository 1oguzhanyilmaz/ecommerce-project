<header class="section-header">
    <nav class="navbar navbar-dark navbar-expand p-0 bg-primary">
        <div class="container">
            <ul class="navbar-nav d-none d-md-flex mr-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Delivery</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Payment</a></li>
            </ul>
            <ul class="navbar-nav">
                <li  class="nav-item"><a href="#" class="nav-link"> Call: +99812345678 </a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> English </a>
                    <ul class="dropdown-menu dropdown-menu-right" style="max-width: 100px;">
                        <li><a class="dropdown-item" href="#">Arabic</a></li>
                        <li><a class="dropdown-item" href="#">Turkish</a></li>
                        <li><a class="dropdown-item" href="#">Russian </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <section class="header-main border-bottom">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-2 col-6">
                    <a href="{{ route('home') }}" class="brand-wrap">
                        <img class="logo" src="{{ asset('images/logo.png') }}">
                    </a>
                </div>

                <div class="col-lg-6 col-12 col-sm-12">
                    <form action="#" class="search">
                        <div class="input-group w-100">
                            <input type="text" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="widgets-wrap float-md-right">

                        <div class="widget-header mr-3">
                            <a href="{{ route('cart') }}" class="icon icon-sm rounded-circle border">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <span class="badge badge-pill badge-danger notify">{{ \Cart::getContent()->count() }}</span>
                        </div>

                        @guest
                            <div class="widget-header icontext">
                                <div class="text">
                                    <span class="text-muted">Welcome!</span>
                                    <div>
                                        <a href="{{ route('login') }}">Sign in</a> |
                                        <a href="{{ route('register') }}"> Register</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="widget-header icontext">
                                <a href="{{ route('profile') }}" class="icon icon-sm rounded-circle border">
                                    <i class="fa fa-user"></i>
                                </a>
                                <div class="text d-flex flex-column justify-content-between align-items-center">
                                    <span class="text-muted">{{ ucfirst(auth()->user()->name) }}</span>
                                    <a href="{{ route('logout') }}" class="border-top btn-sm mt-1"  onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">Log out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>

            </div>
        </div>
    </section>
</header>
