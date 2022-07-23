<ul class="list-group">
    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action @if(Route::currentRouteName() ==
    'profile') active @endif">Profile</a>
    <a href="{{ route('user_posts') }}" class="list-group-item list-group-item-action @if(Route::currentRouteName() ==
    'user_posts') active @endif">Posts</a>
    <a href="#" class="list-group-item list-group-item-action @if(Route::currentRouteName() ==
    'user_comments') active @endif">Comments</a>
</ul>
