@php
    /** @var \App\Models\PostCategory $category */
@endphp
@extends('app')

@section('title', $category->title)

@section('content')
    @include('front.elements.header')
    <div class="main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    @if($category->posts)
                        <section class="posts-wrapper py-4">
                            <div class="container">
                                <div class="row">
                                    <h1>{{ $category->title }}</h1>
                                </div>
                                <div class="row">
                                    @foreach($category->posts as $post)
                                        @include('front.elements.post')
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                    {{--    TODO Как сделать пагинацию???--}}
                    {{--    @if($posts->total() > $posts->count())--}}
                    {{--        @include('front.elements.pagination')--}}
                    {{--    @endif--}}
                </div>
                <div class="col-3">
                    <aside class="py-4">
                        @include('front.elements.categories')
                        @include('front.elements.tags')
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
