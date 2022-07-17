<section class="posts-wrapper py-4">
    <div class="container">
        <div class="row">
            @foreach($posts as $post)
                @php
                    /** @var \App\Models\Post $post */
                @endphp
                <div class="col-lg-4 col-md-6 col p-2">
                    <div class="card post-item" style="position: relative;">
                        <a href="#"><span class="badge bg-white text-black" style="position: absolute; top: 20px; left: 20px;">{{
                        $post->post_category->title }}</span></a>
                        <div class="tags-wrapper" style="position: absolute; top: 20px; right: 20px;">
                            @if($post->post_tags())
                                @foreach($post->post_tags as $tag)
                                    <a href="#"><span class="badge bg-white text-black">{{
                        $tag->title }}</span></a>
                                @endforeach
                            @endif
                        </div>
                        <a href="#"><img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->title }}"></a>
                        <div class="card-body">
                            <a href="#"><h5 class="card-title">{{ $post->title }}</h5></a>
                            <p class="card-text">{{ $post->excerpt }}</p>
                            <a href="#" class="btn btn-primary">Read more</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
