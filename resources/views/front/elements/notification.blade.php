<div class="alert alert-{{ $notification->read_at ? 'secondary' : $notification->data['type'] }} alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
    <div>{!! $notification->data['message'] !!}</div>
    @if(!$notification->read_at)
    <a href="{{ route('admin.notification_read', $notification->id) }}" type="button" class="close btn btn-outline-primary">
        <span aria-hidden="true">Read</span>
    </a>
    @endif
</div>