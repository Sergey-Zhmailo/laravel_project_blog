@extends('app')

@section('title', 'Search')

@section('content')
    @include('front.elements.header')
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <section class="posts-wrapper py-4">
                        <div class="container">
                            <div class="row">
                                <h1>Search</h1>
                            </div>
                            <div class="row">
                                @forelse ($posts as $post)
                                    @include('front.elements.post')
                                @empty
                                    <p>No posts</p>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
