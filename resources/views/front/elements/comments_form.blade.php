<div class="comments-form-wrapper card">
    <form action="{{ route('comment_process') }}" method="post" class="needs-validation
        @if($errors->all()) was-validated @endif"
          novalidate>
        @csrf
        <div class="card-header"><h3>Leave comment</h3></div>
        <div class="card-body">
            <div class="input-group has-validation mb-3">
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea class="form-control" id="comment" name="text" rows="3" required></textarea>
                @error('comment')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
</div>
