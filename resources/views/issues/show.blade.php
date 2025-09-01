@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $issue->title }}</h1>
        <p><strong>Project:</strong> {{ $issue->project->name }}</p>
        <p><strong>Status:</strong> {{ ucfirst($issue->status) }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($issue->priority) }}</p>
        <p><strong>Due Date:</strong> {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('Y-m-d') : 'N/A' }}</p>
        <p>{{ $issue->description }}</p>

        <hr>

        <h3>Tags</h3>
        <div id="tags-list" class="mb-3">
            @foreach($issue->tags as $tag)
                <span class="badge bg-secondary me-1">
            {{ $tag->name }}
            <button type="button" class="btn-close btn-close-white btn-sm remove-tag" data-tag-id="{{ $tag->id }}"></button>
        </span>
            @endforeach
        </div>

        <div class="mb-3">
            <select id="tag-select" class="form-select" style="width: auto; display:inline-block;">
                <option value="">Select tag</option>
            </select>
            <button type="button" id="attach-tag-btn" class="btn btn-primary btn-sm">Attach Tag</button>
        </div>

        <hr>

        <h3>Comments</h3>
        <div id="comments-list" class="mb-3"></div>

        <h5>Add a Comment</h5>
        <form id="comment-form">
            @csrf
            <div class="mb-2">
                <input type="text" name="author_name" id="author_name" class="form-control" placeholder="Your name" required>
                <div class="text-danger" id="author_name_error"></div>
            </div>
            <div class="mb-2">
                <textarea name="body" id="body" class="form-control" placeholder="Comment" required></textarea>
                <div class="text-danger" id="body_error"></div>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>

        <hr>

        <a href="{{ route('issues.edit', $issue) }}" class="btn btn-warning">Edit Issue</a>
        <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Issue</button>
        </form>

        <h3>Assigned Members</h3>
        <ul id="member-list">
            @foreach($issue->users as $member)
                <li>
                    {{ $member->name }} ({{ $member->email }})
                    <button class="btn btn-sm btn-danger detach-member" data-user-id="{{ $member->id }}">Remove</button>
                </li>
            @endforeach
        </ul>

        <form id="add-member-form">
            @csrf
            <div class="input-group">
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">-- Select User --</option>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Add Member</button>
            </div>
        </form>
    </div>

    <script>
        const issueId = {{ $issue->id }};
        const allTags = @json($tags);
        let attachedTags = @json($issue->tags);

        function updateTagSelect(attached = []) {
            const tagSelect = document.getElementById('tag-select');
            tagSelect.innerHTML = '<option value="">Select tag</option>';
            allTags.forEach(tag => {
                if(!attached.some(t => t.id === tag.id)){
                    const option = document.createElement('option');
                    option.value = tag.id;
                    option.text = tag.name;
                    tagSelect.appendChild(option);
                }
            });
        }
        updateTagSelect(attachedTags);

        document.getElementById('attach-tag-btn').addEventListener('click', function(){
            const tagSelect = document.getElementById('tag-select');
            const tagId = tagSelect.value;
            if(!tagId) return alert('Select a tag first');

            fetch(`/issues/${issueId}/attach-tag`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({tag_id: tagId})
            })
                .then(res => res.json())
                .then(data => {
                    if(data.ok){
                        const attachedTag = data.tags.find(t => t.id == tagId);
                        if(attachedTag){
                            attachedTags = data.tags;
                            const tagHtml = `<span class="badge bg-secondary me-1">
                        ${attachedTag.name}
                        <button type="button" class="btn-close btn-close-white btn-sm remove-tag" data-tag-id="${attachedTag.id}"></button>
                    </span>`;
                            document.getElementById('tags-list').insertAdjacentHTML('beforeend', tagHtml);
                            updateTagSelect(attachedTags);
                        }
                    }
                });
        });

        document.getElementById('tags-list').addEventListener('click', function(e){
            if(e.target.classList.contains('remove-tag')){
                const tagId = e.target.dataset.tagId;
                fetch(`/issues/${issueId}/detach-tag`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({tag_id: tagId})
                })
                    .then(res => res.json())
                    .then(data => {
                        if(data.ok){
                            attachedTags = data.tags;
                            e.target.parentElement.remove();
                            updateTagSelect(attachedTags);
                        }
                    });
            }
        });

        function loadComments(){
            fetch("{{ route('issues.comments', $issue->id) }}")
                .then(res => res.text())
                .then(html => document.getElementById('comments-list').innerHTML = html);
        }
        document.addEventListener('DOMContentLoaded', loadComments);

        document.getElementById('comment-form').addEventListener('submit', function(e){
            e.preventDefault();
            document.getElementById('author_name_error').innerText = '';
            document.getElementById('body_error').innerText = '';

            const data = {
                author_name: document.getElementById('author_name').value,
                body: document.getElementById('body').value
            };

            fetch("{{ route('issues.comments.store', $issue->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(res => {
                    if(res.status === 422){
                        return res.json().then(errors => {
                            if(errors.errors.author_name) document.getElementById('author_name_error').innerText = errors.errors.author_name[0];
                            if(errors.errors.body) document.getElementById('body_error').innerText = errors.errors.body[0];
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    if(data.success){
                        const commentsList = document.getElementById('comments-list');
                        const commentHtml = `<div class="card mb-2">
                    <div class="card-body">
                        <strong>${data.comment.author_name}</strong>
                        <p>${data.comment.body}</p>
                        <small>Just now</small>
                    </div>
                </div>`;
                        commentsList.insertAdjacentHTML('afterbegin', commentHtml);
                        document.getElementById('author_name').value = '';
                        document.getElementById('body').value = '';
                    }
                });
        });

        document.getElementById('add-member-form').addEventListener('submit', function(e){
            e.preventDefault();
            const formData = new FormData(this);

            fetch("{{ route('issues.users.attach', $issue) }}", {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            }).then(res => res.json())
                .then(data => { if(data.success) location.reload(); });
        });

        document.querySelectorAll('.detach-member').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.dataset.userId;
                fetch("{{ url('/issues/'.$issue->id.'/users') }}/" + userId, {
                    method: "DELETE",
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(res => res.json())
                    .then(data => { if(data.success) location.reload(); });
            });
        });
    </script>
@endsection
