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
                            @if($post->getFirstMedia('posts'))
                                @if(count($post->getMedia('posts')) > 1)
                                    <div class="swiper post-slider">
                                        <div class="swiper-wrapper">
                                            @foreach($post->getMedia('posts') as $slide)
                                                <div class="swiper-slide">
                                                    <img src="{{ $slide->getUrl
                                ('post_preview') }}" alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                @else
                                    <img
                                        class="rounded d-block lh-1 mw-100"
                                        src="{{  $post->getFirstMedia('posts')->getUrl
                                ('post_preview') }}"
                                        alt="{{ $post->title }}"
                                    >
                                @endif
{{--                                <img class="rounded d-block lh-1 mw-100" src="{{ asset('storage/' .--}}
{{--                                $post->image) }}" alt="{{ $post->title }}">--}}

                            @else
                                <img class="rounded d-block lh-1 mw-100" src="{{ asset('storage/no_image.png')
                                }}" alt="{{ $post->title }}">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h1>{{ $post->title }}</h1>
                            <div class="post-info">
                                @if($post->post_category)
                                    <h6>Category: <a href="{{ route('categories', $post->post_category->slug) }}">{{
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
                            @if($post->comments)
                                @include('front.elements.comments')
                            @endif
                            @if(auth('web')->check() && auth('web')->user()->email_verified_at)
                                @include('front.elements.comments_form')
                            @endif
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
