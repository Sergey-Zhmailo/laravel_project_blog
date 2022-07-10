@extends('app')

@section('title', 'Verify email')

@section('content')
    @include('front.elements.header')
    <section class="ferify-section d-flex align-items-center" style="min-height: calc(100Vh - 80px);">
        <div class="container">
            <div class="row">
                <div class="col-12" class="d-flex">
                    <div class="card shadow-sm" style="width: 100%; max-width: 300px; margin: auto;">
                        <div class="card-header text-center"><h3>Veryfy your email</h3></div>
                        <div class="card-body">Check you email for ferify link</div>
                        <div class="card-footer text-center">
                            <a href="{{ route('verification.send') }}" class="btn btn-secondary">Resend mail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
