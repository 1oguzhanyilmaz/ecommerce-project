@extends('front.layout')

@section('content')
    <section class="section-content " style="min-height:84vh">

        <div class="card mx-auto" style="max-width: 380px; margin-top:30px;">
            <div class="card-header">
                <h4 class="card-title text-center text-primary">{{ __('Reset Password') }}</h4>
            </div>

            <div class="card-body">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <a href="#" class="btn btn-facebook btn-block mb-2"> <i class="fa fa-facebook-f"></i> &nbsp  Sign in with Facebook</a>
                    <a href="#" class="btn btn-google btn-block mb-4"> <i class="fa fa-google"></i> &nbsp  Sign in with Google</a>

                    <div class="form-group">
                        <label for="email" class="">{{ __('E-Mail Address') }}</label>
                        <input name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" type="text" value="{{ old('email') }}">
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
                        <button type="submit" class="btn btn-primary btn-block"> {{ __('Reset Password') }}  </button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center mt-4">Don't have account? <a href="{{ route('register') }}">Sign up</a></p>
        <br><br>

    </section>

@endsection
