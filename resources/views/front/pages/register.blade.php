@extends('front.layout')

@section('content')

    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content">

        <div class="card mx-auto my-2" style="max-width:520px;">
            <article class="card-body">
                <header class="mb-1"><h4 class="card-title">Sign up</h4></header>
                <form>
                    <div class="form-row">
                        <div class="col form-group my-1">
                            <label>First name</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="col form-group my-1">
                            <label>Last name</label>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group my-1">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="">
                        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group my-1">
                        <label class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" checked="" type="radio" name="gender" value="option1">
                            <span class="custom-control-label"> Male </span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="gender" value="option2">
                            <span class="custom-control-label"> Female </span>
                        </label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Country</label>
                            <select id="inputState" class="form-control">
                                <option> Choose...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Create password</label>
                            <input class="form-control" type="password">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Repeat password</label>
                            <input class="form-control" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Register  </button>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked="">
                            <div class="custom-control-label"> I am agree with <a href="#">terms and contitions</a>  </div>
                        </label>
                    </div>
                </form>
            </article>
        </div>
        <p class="text-center mt-4">Have an account? <a href="">Log In</a></p>
        <br><br>


    </section>

@endsection
