@extends('front.layout')

@section('content')

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">

        <div class="card mx-auto my-2" style="max-width:520px;">
            <article class="card-body">
                <header class="mb-1"><h4 class="card-title">Sign up</h4></header>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col form-group my-1">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group my-1">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input name="password" id="password" class="form-control  @error('password') is-invalid @enderror" type="password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password-confirm">Confirm Password</label>
                            <input name="password_confirmation" id="password-confirm" class="form-control @error('password_confirmation') is-invalid @enderror" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Register </button>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox" for="contitions">
                            <input type="checkbox" name="contitions" id="contitions" class="custom-control-input" {{ old('contitions') ? 'checked' : '' }}>
                            <div class="custom-control-label">
                                I am agree with
                                <a href="#">terms and contitions</a>
                            </div>
                        </label>
                    </div>
                </form>
            </article>
        </div>
        <p class="text-center mt-4">Have an account? <a href="{{ route('login') }}">Log In</a></p>
        <br><br>


    </section>

@endsection
