@php
    /** @var \App\Models\PostCategory $category */
@endphp
<div class="categories-wrapper mb-3">
    <div class="list-group">
        <li class="list-group-item"><h4>Categories</h4></li>
        @forelse($categories as $category)
            <a href="{{ route('categories', $category->slug) }}" class="list-group-item
                list-group-item-action">{{
                $category->title }}<span class="badge bg-secondary mx-3">{{ $category->posts_count }}</span></a>
        @empty
            No categories
        @endforelse
    </div>
</div>
