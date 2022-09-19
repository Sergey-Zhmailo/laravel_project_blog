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
                            <span>Users</span>
{{--                            <a href="{{ route('posts.create') }}" type="button" class="btn btn-success">New--}}
{{--                                post</a>--}}
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($posts as $index => $post)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + ($posts->perPage() * ($posts->currentPage() -
                                         1))
                                        }}</th>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->name }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
{{--                                                Как правильно?--}}
                                                @if($post->status == 1)
                                                    <a href="{{ route('admin.block_user', $post->id) }}" type="button"
                                                       class="btn
                                                btn-outline-danger">Block</a>
                                                @else
                                                    <a href="{{ route('admin.unblock_user', $post->id) }}" type="button"
                                                       class="btn
                                                btn-outline-warning">UnBlock</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <p>No users</p>
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
