@php
    /** @var \App\Models\PostTag $tag */
@endphp
<div class="categories-wrapper mb-3">
    <div class="list-group">
        <li class="list-group-item"><h4>Tags</h4></li>
        @forelse($tags as $tag)
            <a href="{{ route('tags', $tag->slug) }}" class="list-group-item
                list-group-item-action">{{
                $tag->title }}<span class="badge bg-secondary mx-3">{{ $tag->posts_count }}</span></a>
        @empty
            No tags
        @endforelse
    </div>
</div>
