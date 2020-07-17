@extends('front.layout')

@section('content')
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content " style="min-height:84vh">

        <div class="card mx-auto" style="max-width: 380px; margin-top:30px;">
            <div class="card-body">
                <h4 class="card-title mb-4">Sign in</h4>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <a href="#" class="btn btn-facebook btn-block mb-2"> <i class="fa fa-facebook-f"></i> &nbsp  Sign in with Facebook</a>
                    <a href="#" class="btn btn-google btn-block mb-4"> <i class="fa fa-google"></i> &nbsp  Sign in with Google</a>
                    <div class="form-group">
                        <input name="email" class="form-control" placeholder="Email" type="text">
                    </div>
                    <div class="form-group">
                        <input name="password" class="form-control" placeholder="Password" type="password">
                    </div>

                    <div class="form-group">
                        <a href="#" class="float-right">Forgot password?</a>
                        <label class="float-left custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" checked="">
                            <div class="custom-control-label"> Remember </div>
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Login  </button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center mt-4">Don't have account? <a href="#">Sign up</a></p>
        <br><br>


    </section>

@endsection
