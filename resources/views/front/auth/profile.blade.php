@extends('app')

@section('title', 'Profile')

@section('content')
    @include('front.elements.header')
    <section class="py-4 user-profile-page">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    @include('front.elements.dashboard_menu')
                </div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            Profile
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile_process') }}"
                                  method="post"
                                  class="needs-validation
                                @if($errors->all()) was-validated @endif"
                                  enctype="multipart/form-data"
                                  novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="email-label">Name</span>
                                            <input type="text" name="name" class="form-control" id="profile-name"
                                                   aria-describedby="name-label" value="{{ auth('web')->user()->name
                                                   }}" disabled>
                                        </div>
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="email-label">Email</span>
                                            <input type="email" name="email" class="form-control" id="profile-email"
                                                   aria-describedby="email-label" value="{{ auth('web')->user()->email
                                                   }}" disabled>
                                        </div>
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="old-password-label">Old Password</span>
                                            <input type="password" name="old-password" class="form-control"
                                                   id="old-password"
                                                   aria-describedby="password-label" required>
                                            @error('old_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="password-label">New Password</span>
                                            <input type="password" name="password" class="form-control"
                                                   id="login-password"
                                                   aria-describedby="password-label" required>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text"
                                                  id="confirmation-password-label">Confirm New Password</span>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                   id="register-password-confirmation"
                                                   aria-describedby="password-label" required>
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text"
                                                  id="avatar-image-disabled-label">Avatar image</span>
                                            <input type="text"
                                                   name="avatar-image-disabled"
                                                   class="form-control"
                                                   id="avatar-image-disabled"
                                                   aria-describedby="avatar-image-disabled-label"
                                                   disabled
{{--                                                   @if(auth('web')->user()->image)--}}
{{--                                                       value="{{ auth('web')->user()->image }}"--}}
{{--                                                   @else--}}
                                                   @if(auth('web')->user()->getFirstMedia('avatars'))
                                                       value="{{ auth('web')->user()->getFirstMediaUrl('avatars') }}"
                                                   @else
                                                       value="No image"
                                                @endif
                                            >
                                        </div>
                                        <div class="input-group has-validation mb-3">
                                            <input class="form-control" type="file" id="avatar-image"
                                                   name="avatar-image">
                                            @error('avatar-image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="avatar-wrapper p-4">
{{--                                            @if(auth('web')->user()->image)--}}
                                            @if(auth('web')->user()->getFirstMedia('avatars'))
{{--                                                <img src="{{ asset('storage/' . auth('web')->user()->image) }}"--}}
{{--                                                     class="rounded float-start" alt="...">--}}
                                                <img src="{{ auth('web')->user()->getFirstMedia('avatars')->getUrl('thumb') }}"
                                                     class="rounded float-start" alt="...">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                                    <path
                                                        d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm128 421.6c-35.9 26.5-80.1 42.4-128 42.4s-92.1-15.9-128-42.4V416c0-35.3 28.7-64 64-64 11.1 0 27.5 11.4 64 11.4 36.6 0 52.8-11.4 64-11.4 35.3 0 64 28.7 64 64v13.6zm30.6-27.5c-6.8-46.4-46.3-82.1-94.6-82.1-20.5 0-30.4 11.4-64 11.4S204.6 320 184 320c-48.3 0-87.8 35.7-94.6 82.1C53.9 363.6 32 312.4 32 256c0-119.1 96.9-216 216-216s216 96.9 216 216c0 56.4-21.9 107.6-57.4 146.1zM248 120c-48.6 0-88 39.4-88 88s39.4 88 88 88 88-39.4 88-88-39.4-88-88-88zm0 144c-30.9 0-56-25.1-56-56s25.1-56 56-56 56 25.1 56 56-25.1 56-56 56z"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
