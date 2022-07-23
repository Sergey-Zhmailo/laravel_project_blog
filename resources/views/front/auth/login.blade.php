@extends('app')

@section('title', 'Login')

@section('content')
    @include('front.elements.header')
    <section class="login-section d-flex align-items-center" style="min-height: calc(100Vh - 80px);">
        <div class="container">
            <div class="row">
                <div class="col-12" class="d-flex">
                    <div class="card shadow-sm" style="width: 100%; max-width: 300px; margin: auto;">
                        <form action="{{ route('login_process') }}" method="post" class="needs-validation
                        @if($errors->all()) was-validated @endif"
                              novalidate>
                            @csrf
                            <div class="card-header text-center"><h3>Login</h3></div>
                            <div class="card-body">
                                <div class="input-group has-validation mb-3">
                                    <span class="input-group-text" id="email-label" style="width: 100px;">Email</span>
                                    <input type="email" name="email" class="form-control" id="login-email"
                                           aria-describedby="email-label" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="password-label"
                                          style="width: 100px;">Password</span>
                                    <input type="password" name="password" class="form-control" id="login-password"
                                           aria-describedby="password-label" required>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button class="btn btn-primary" type="submit">Login</button>
                                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
