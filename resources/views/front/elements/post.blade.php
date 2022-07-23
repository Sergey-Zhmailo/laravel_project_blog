@php
    /** @var \App\Models\Post $post */
@endphp
<div class="col-lg-4 col-md-6 col p-2">
    <div class="card post-item">
        <a href="{{ route('categories', $post->post_category->slug) }}"><span class="badge bg-white text-black
        category-badge">{{
        $post->post_category->title }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M194.74 96l54.63 54.63c6 6 14.14 9.37 22.63 9.37h192c8.84 0 16 7.16 16 16v224c0 8.84-7.16 16-16 16H48c-8.84 0-16-7.16-16-16V112c0-8.84 7.16-16 16-16h146.74M48 64C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48H272l-54.63-54.63c-6-6-14.14-9.37-22.63-9.37H48z"/></svg></span></a>
        <div class="tags-wrapper">
            @if($post->post_tags())
                @foreach($post->post_tags as $tag)
                    <a href="{{ route('tags', $tag->slug) }}"><span class="badge bg-white
                    text-black">{{
        $tag->title }}<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497.941 225.941L286.059 14.059A48 48 0 0 0 252.118 0H48C21.49 0 0 21.49 0 48v204.118a48 48 0 0 0 14.059 33.941l211.882 211.882c18.745 18.745 49.137 18.746 67.882 0l204.118-204.118c18.745-18.745 18.745-49.137 0-67.882zm-22.627 45.255L271.196 475.314c-6.243 6.243-16.375 6.253-22.627 0L36.686 263.431A15.895 15.895 0 0 1 32 252.117V48c0-8.822 7.178-16 16-16h204.118c4.274 0 8.292 1.664 11.314 4.686l211.882 211.882c6.238 6.239 6.238 16.39 0 22.628zM144 124c11.028 0 20 8.972 20 20s-8.972 20-20 20-20-8.972-20-20 8.972-20 20-20m0-28c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48z"/></svg></span></a>
                @endforeach
            @endif
        </div>
        <a href="{{ route('post', $post->slug) }}">
            @if($post->image)
                <img class="card-img-top rounded d-block lh-1 mw-100" src="{{ asset('storage/' . $post->image) }}"
                     alt="{{ $post->title }}">
            @else
                <img class="card-img-top rounded d-block lh-1 mw-100" src="{{ asset('storage/no_image.png') }}"
                     alt="{{ $post->title }}">
            @endif
        </a>
        <div class="card-body">
            <div class="info-wrapper">
                <div class="date">Date: {{ $post->published_at }}</div>
                <div class="date">Comments: {{ $post->comments_count }}</div>
            </div>
            <a href="{{ route('post', $post->slug) }}"><h5 class="card-title">{{ $post->title }}</h5></a>
            <p class="card-text">{{ $post->excerpt }}</p>
            <a href="{{ route('post', $post->slug) }}" class="btn btn-primary">Read more</a>
        </div>
    </div>
</div>
