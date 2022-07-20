@php
    /** @var \App\Models\PostCategory $category */
@endphp
<div class="categories-wrapper mb-3">
    @if($categories)
        <div class="list-group">
            <li class="list-group-item"><h4>Categories</h4></li>
            @foreach($categories as $category)
                <a href="{{ route('categories', $category->slug) }}" class="list-group-item
                list-group-item-action">{{
                $category->title }}<span class="badge bg-secondary mx-3">{{ $category->posts()->where('is_published', true)->where('is_hide', false)->count() }}</span></a>
            @endforeach
        </div>
    @else
        No categories
    @endif
</div>
