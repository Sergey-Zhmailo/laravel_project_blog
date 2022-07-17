@php
    /** @var \App\Models\PostTag $tag */
@endphp
<div class="categories-wrapper mb-3">
    @if($tags)
        <div class="list-group">
            <li class="list-group-item"><h4>Tags</h4></li>
            @foreach($tags as $tag)
                <a href="{{ route('tags.show', $tag->slug) }}" class="list-group-item
                list-group-item-action">{{
                $tag->title }}</a>
            @endforeach
        </div>
    @else
        No tags
    @endif
</div>
