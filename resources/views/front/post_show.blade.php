@php
    /** @var \App\Models\Post $post */
@endphp
@extends('app')

@section('title', $post->title)

@section('content')
    @include('front.elements.header')
    <div class="main-wrapper py-4">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-12">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1>{{ $post->title }}</h1>
                            <div class="post-info">
                                @if($post->post_category)
                                    <h6>Category: <a href="{{ route('categories.show', $post->post_category->slug) }}">{{
                        $post->post_category->title
                        }}</a></h6>
                                @endif
                                @if($post->post_tags)
                                    <h6>Tags:
                                        @foreach($post->post_tags as $tag)
                                            <a href="">{{ $tag->title }}</a>
                                        @endforeach
                                    </h6>
                                @endif
                            </div>
                            <div class="content">{{ $post->content }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <aside>
                        @include('front.elements.categories')
                        @include('front.elements.tags')
                    </aside>
                </div>
            </div>
        </div>
    </div>
@endsection
