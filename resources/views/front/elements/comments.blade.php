@php
    /** @var \App\Models\Comment $comment */
@endphp
<div class="comments-wrapper py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">Comments</h2>
            <ul class="list-group list-group-flush">
                @foreach($post->comments as $comment)
                    <li class="list-group-item">{{ $comment->text }} - {{ $comment->user->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
