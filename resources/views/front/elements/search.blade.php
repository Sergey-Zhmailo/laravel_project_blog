@if(!in_array(Route::currentRouteName(), ['profile', 'user_posts', 'posts.edit', 'posts.create', 'user_posts_trash']))
<div class="search-header-wrapper">
    <form action="{{ route('search_process') }}" method="post">
        @csrf
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                placeholder="Search"
                aria-describedby="button-search"
                name="search_text"
            >
            <button class="btn btn-outline-primary" type="submit" id="button-search">Search</button>
        </div>
    </form>
</div>
@endif
