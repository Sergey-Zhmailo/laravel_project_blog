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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Admin notifications</span>
                        </div>
                        <div class="card-body">
                            @foreach($notifications as $notification)
                            @include('front.elements.notification')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
