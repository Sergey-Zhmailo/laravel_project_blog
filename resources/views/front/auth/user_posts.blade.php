@extends('app')

@section('title', 'Profile')

@section('content')
    @include('front.elements.header')
    <section class="py-4 user-profile-page">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    @include('front.elements.dashboard_menu')
                </div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Posts</span>
                            <a href="{{ route('posts.create') }}" type="button" class="btn btn-success">New
                                post</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($posts as $index => $post)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td><a title="open post" href="{{ route('post', $post->slug) }}"
                                               target="_blank">{{
                                        $post->title
                                        }}</a></td>
                                        <td>{{ $post->is_published ? \Illuminate\Support\Carbon::parse
                                        ($post->published_at)->format
                                        ('d/m/Y') : 'not published'
                                        }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                @if(Route::currentRouteName() == 'user_posts')
                                                    <a href="{{ route('post', $post->slug) }}" type="button" class="btn
                                                btn-outline-primary">Preview</a>
                                                    <a href="{{ route('posts.edit', $post->id) }}" type="button" class="btn
                                                btn-outline-warning">Edit</a>
                                                    <form method="post" action="{{ route('posts.destroy', $post->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" value="Delete" class="btn btn-outline-danger">
                                                    </form>
                                                @endif
                                                @if(Route::currentRouteName() == 'user_posts_trash')
                                                        <a href="{{ route('posts.restore',
                                                    $post->id) }}" type="button" class="btn
                                                btn-outline-primary">Restore</a>
                                                        <a href="{{ route('posts.force_delete',
                                                    $post->id) }}" type="button" class="btn
                                                btn-outline-danger">Delete from trash</a>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <p>No posts</p>
                                @endforelse

                                </tbody>
                            </table>
                            @if($posts->total() > $posts->count())
                                @include('front.elements.pagination')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
