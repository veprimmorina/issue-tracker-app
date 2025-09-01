@foreach($comments as $comment)
    <div class="card mb-2">
        <div class="card-body">
            <strong>{{ $comment->author_name }}</strong>
            <p>{{ $comment->body }}</p>
            <small>{{ $comment->created_at->diffForHumans() }}</small>
        </div>
    </div>
@endforeach

@if(method_exists($comments, 'links'))
    {{ $comments->links() }}
@endif
