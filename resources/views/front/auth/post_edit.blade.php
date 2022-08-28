@php
    /**
 * @var \App\Models\Post $post
 * @var \App\Models\PostCategory $category
 * @var \App\Models\PostTag $tag
 */
@endphp
@extends('app')

@section('title', 'Edit post')

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
                            @if($post->exists)
                                <h3>Edit post</h3>
                            @else
                                <h3>Create post</h3>
                            @endif
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item">Published at: @if($post->published_at)
                                        {{ \Illuminate\Support\Carbon::parse
                                                                       ($post->published_at)->format('d/m/Y') }}
                                    @endif</li>
                                <li class="list-group-item">Created at: @if($post->created_at)
                                        {{
                                                                       \Illuminate\Support\Carbon::parse
                                                                       ($post->created_at)->format('d/m/Y') }}
                                    @endif</li>
                                <li class="list-group-item">Updated at: @if($post->updated_at)
                                        {{
                                                                        \Illuminate\Support\Carbon::parse
                                                                        ($post->updated_at)->format('d/m/Y') }}
                                    @endif</li>
                            </ul>
                        </div>
                        <div class="card-body">
                            @if($post->exists)
                                <form action="{{ route('posts.update', $post->id) }}"
                                      method="post"
                                      class="needs-validation
                                @if($errors->all()) was-validated @endif"
                                      enctype="multipart/form-data"
                                      novalidate>
                                    @csrf
                                    @method('PATCH')
                                    @else
                                        <form action="{{ route('posts.store') }}"
                                              method="post"
                                              class="needs-validation
                                @if($errors->all()) was-validated @endif"
                                              enctype="multipart/form-data"
                                              novalidate>
                                            @csrf
                                            @endif
                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="title-label">Title</span>
                                                <input type="text"
                                                       name="title"
                                                       class="form-control"
                                                       id="edit-title"
                                                       aria-describedby="title-label"
                                                       value="{{ old('title', $post->title) }}"
                                                       required>
                                                @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="slug-label">Slug</span>
                                                <input type="text"
                                                       name="slug"
                                                       class="form-control"
                                                       id="edit-slug"
                                                       aria-describedby="slug-label"
                                                       value="{{ old('slug', $post->slug) }}"
                                                >
                                                @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="content-label">Text</span>
                                                <textarea class="form-control"
                                                          id="edit-content"
                                                          rows="3"
                                                          name="content"
                                                          aria-describedby="content-label"
                                                          required
                                                >{{ old('content', $post->content) }}</textarea>
                                                @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="excerpt-label">Excerpt</span>
                                                <input type="text"
                                                       name="excerpt"
                                                       class="form-control"
                                                       id="edit-excerpt"
                                                       aria-describedby="excerpt-label"
                                                       value="{{ old('excerpt', $post->excerpt) }}"
                                                >
                                                @error('excerpt')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="edit-category">Category</span>
                                                <select
                                                    class="form-select"
                                                    id="edit-category"
                                                    name="category_id"
                                                    required>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                                @if($post->category_id == $category->id) selected @endif
                                                        >
                                                            {{ $category->title }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('category_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="edit-tags">Tags</span>
                                                <select
                                                    class="form-select"
                                                    id="edit-tags"
                                                    name="tag_ids[]"
                                                    multiple
                                                    required>
                                                    @foreach($tags as $tag)
                                                        <option value="{{ $tag->id }}"
                                                                @if(in_array($tag->id, $post_tags)) selected @endif
                                                        >
                                                            {{ $tag->title }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('tag_ids')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-check form-switch mb-3">
                                                <input type="hidden" name="is_published" value="0">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    role="switch"
                                                    id="is_published"
                                                    name="is_published"
                                                    @if($post->is_published)
                                                        checked
                                                    @endif
                                                >
                                                <label class="form-check-label" for="is_published">Is published</label>
                                            </div>

                                            <div class="form-check form-switch mb-3">
                                                <input type="hidden" name="is_hide" value="0">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    role="switch"
                                                    id="is_hide"
                                                    name="is_hide"
                                                    @if($post->is_hide)
                                                        checked
                                                    @endif
                                                >
                                                <label class="form-check-label" for="is_hide">Is hide</label>
                                            </div>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text"
                                                      id="published-at-label">Published at</span>
                                                <input type="date"
                                                       name="published_at"
                                                       class="form-control"
                                                       id="edit-published-at"
                                                       aria-describedby="published-at-label"
                                                       value="{{ old('published_at', \Illuminate\Support\Carbon::parse
                                           ($post->published_at)->format('Y-m-d')) }}"
                                                >
                                            </div>

                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text"
                                                      id="post-image-disabled-label">Image</span>
                                                <input type="text"
                                                       name="post-image-disabled"
                                                       class="form-control"
                                                       id="post-image-disabled"
                                                       aria-describedby="post-image-disabled-label"
                                                       disabled
                                                       value="{{ old('image', $post->image) }}"
                                                >
                                            </div>
                                            <div class="input-group has-validation mb-3">
                                                <input
                                                    class="form-control"
                                                    type="file"
                                                    id="post-image"
                                                    name="image[]"
                                                    multiple
                                                >
                                                @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="image-wrapper py-4 d-flex gap-1">
                                                @if($post->getFirstMedia('posts'))
                                                    @foreach($post->getMedia('posts') as $image)
                                                        <img
                                                            src="{{ $image->getUrl
                                ('post_thumb')  }}"
                                                            class="rounded d-block"
                                                            alt="{{ $post->title }}"
                                                        >
                                                    @endforeach
                                                @else
                                                    No image
                                                @endif
                                            </div>
                                            <button class="btn btn-primary" type="submit">Save changes</button>
                                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
