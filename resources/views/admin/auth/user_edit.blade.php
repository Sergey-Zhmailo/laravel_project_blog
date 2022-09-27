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
                            @if($post->exists)
                                <form action="{{ route('admin.users.update', $post->id) }}"
                                      method="post"
                                      class="needs-validation
                                @if($errors->all()) was-validated @endif"
                                      enctype="multipart/form-data"
                                      novalidate>
                                    @csrf
{{--                                    @method('PATCH')--}}
                            @else
                                <form action="{{ route('admin.users.store') }}"
                                      method="post"
                                      class="needs-validation
                                @if($errors->all()) was-validated @endif"
                                      enctype="multipart/form-data"
                                      novalidate>
                                    @csrf
                            @endif

                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="email-label">Name</span>
                                            <input type="text" name="name" class="form-control" id="profile-name"
                                                   aria-describedby="name-label" value="{{ old('name', $post->name) }}" required>
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="email-label">Email</span>
                                            <input type="email" name="email" class="form-control" id="profile-email"
                                                   aria-describedby="email-label" value="{{ old('email', $post->email) }}"  @if($post->exists) disabled @else required @endif>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="input-group has-validation mb-3">
                                            <span class="input-group-text" id="password-label">Password</span>
                                            <input type="password" name="password" class="form-control"
                                                   id="password"
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
                                        <div class="form-check form-switch mb-3">
                                            <input type="hidden" name="is_blocked" value="0">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                id="is_blocked"
                                                name="is_blocked"
                                                @if($post->is_blocked)
                                                    checked
                                                @endif
                                            >
                                            <label class="form-check-label" for="is_blocked">Is blocked</label>
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
