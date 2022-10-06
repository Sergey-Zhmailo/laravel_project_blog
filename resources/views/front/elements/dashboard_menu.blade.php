<ul class="list-group">
    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action @if(Route::currentRouteName() ==
    'profile') active @endif">Profile</a>
    <a href="{{ route('user_posts') }}" class="list-group-item list-group-item-action @if(Route::currentRouteName() ==
    'user_posts') active @endif">Posts</a>
    <a href="{{ route('user_posts_trash') }}" class="list-group-item list-group-item-action @if(Route::currentRouteName
    () ==
    'user_posts_trash') active @endif">Trash</a>
    <a href="#" class="list-group-item list-group-item-action @if(Route::currentRouteName() ==
    'user_comments') active @endif">Comments</a>
    @can('admin_actions')
        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action
    @if (Route::currentRouteName() == 'admin.dashboard') active @endif">Dashboard</a>
        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action
    @if (Route::currentRouteName() == 'admin.users') active @endif">Users</a>
        <a href="{{ route('admin.notifications') }}" class="list-group-item list-group-item-action
    @if (Route::currentRouteName() == 'admin.notifications') active @endif">Notifications</a>
    @endcan

</ul>
