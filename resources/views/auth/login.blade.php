@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <div class="login-wrap py-5">
                    <div class="img d-flex align-items-center justify-content-center" style="background-image: url({{url('/template/assets/images/icon/logoJinom2.jpg')}});"></div>
                    <h3 class="text-center mb-0" style="color: #00897b;font-weight:800;">Login</h3>
                        <div class="form-group">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
                            <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                    <div class="form-group">
                        <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock"></span></div>
                    <input id="password" type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group d-md-flex">
                                    {{-- <div class="w-100 text-md-right">
                                        <a href="{{ route('password.request') }}">Forgot Password</a>
                                    </div> --}}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn form-control btn-primary rounded submit px-3">Login</button>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection



