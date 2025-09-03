@extends('layouts.app')

@section('title', $issue->title)

@section('content')
    <div class="max-w-3xl mx-auto mt-6 bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">{{ $issue->title }}</h1>

        <div class="mb-4 space-y-1 text-sm text-gray-700">
            <p><strong>Project:</strong> {{ $issue->project->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($issue->status) }}</p>
            <p><strong>Priority:</strong> {{ ucfirst($issue->priority) }}</p>
            <p><strong>Due Date:</strong> {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('Y-m-d') : 'N/A' }}</p>
        </div>

        <div class="mb-4 text-gray-800">
            <p>{{ $issue->description }}</p>
        </div>

        <hr class="my-4">

        <h3 class="mb-2 font-semibold text-gray-800">Tags</h3>
        <div id="tags-list" class="mb-3 flex flex-wrap gap-2">
            @foreach($issue->tags as $tag)
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-medium">
                {{ $tag->name }}
                <button type="button"
                        class="text-indigo-500 hover:text-indigo-700 text-xs font-bold remove-tag"
                        data-tag-id="{{ $tag->id }}">
                    ✕
                </button>
            </span>
            @endforeach
        </div>

        <div class="mb-4 flex items-center gap-2">
            <select id="tag-select"
                    class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <option value="">Select tag</option>
            </select>
            <button type="button" id="attach-tag-btn"
                    class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                Attach Tag
            </button>
        </div>

        <hr class="my-4">

        <h3 class="mb-2 font-semibold text-gray-800">Comments</h3>
        <div id="comments-list" class="mb-3"></div>

        <h5 class="mb-2 font-medium text-gray-700">Add a Comment</h5>
        <form id="comment-form" class="mb-4 space-y-2">
            @csrf
            <div>
                <input type="text" name="author_name" id="author_name"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                       placeholder="Your name" required>
                <div class="text-red-600 text-xs mt-1" id="author_name_error"></div>
            </div>
            <div>
            <textarea name="body" id="body"
                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                      placeholder="Comment" required></textarea>
                <div class="text-red-600 text-xs mt-1" id="body_error"></div>
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                Add Comment
            </button>
        </form>

        <hr class="my-4">

        <div class="flex gap-2 mb-4">
            <a href="{{ route('issues.edit', $issue) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                Edit Issue
            </a>
            <form action="{{ route('issues.destroy', $issue) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                        onclick="return confirm('Are you sure?')">
                    Delete Issue
                </button>
            </form>
        </div>

        <h3 class="mb-2 font-semibold text-gray-800">Assigned Members</h3>
        <ul id="member-list" class="mb-3 space-y-1 text-sm text-gray-700">
            @foreach($issue->users as $member)
                <li class="flex items-center justify-between">
                    <span>{{ $member->name }} ({{ $member->email }})</span>
                    <button class="px-2 py-1 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 transition detach-member"
                            data-user-id="{{ $member->id }}">
                        Remove
                    </button>
                </li>
            @endforeach
        </ul>

        <form id="add-member-form" class="mb-4 flex gap-2 items-center">
            @csrf
            <select name="user_id" id="user_id"
                    class="border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm flex-1">
                <option value="">-- Select User --</option>
                @foreach(\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                Add Member
            </button>
        </form>
    </div>

    <script>
        const issueId = {{ $issue->id }};
        let attachedTags = @json($issue->tags);
        const allTags = @json($tags);

        function updateTagSelect(attached = []) {
            const tagSelect = document.getElementById('tag-select');
            tagSelect.innerHTML = '<option value="">Select tag</option>';
            allTags.forEach(tag => {
                if (!attached.some(t => t.id === tag.id)) {
                    const option = document.createElement('option');
                    option.value = tag.id;
                    option.text = tag.name;
                    tagSelect.appendChild(option);
                }
            });
        }
        updateTagSelect(attachedTags);

        document.getElementById('attach-tag-btn').addEventListener('click', function () {
            const tagId = document.getElementById('tag-select').value;
            if (!tagId) return alert('Select a tag first');

            fetch(`/issues/${issueId}/attach-tag`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ tag_id: tagId })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.ok) {
                        const attachedTag = data.tags.find(t => t.id == tagId);
                        if (attachedTag) {
                            attachedTags = data.tags;
                            const tagHtml = `<span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-medium">
                            ${attachedTag.name}
                            <button type="button" class="text-indigo-500 hover:text-indigo-700 text-xs font-bold remove-tag" data-tag-id="${attachedTag.id}">✕</button>
                        </span>`;
                            document.getElementById('tags-list').insertAdjacentHTML('beforeend', tagHtml);
                            updateTagSelect(attachedTags);
                        }
                    }
                });
        });

        document.getElementById('tags-list').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-tag')) {
                const tagId = e.target.dataset.tagId;
                fetch(`/issues/${issueId}/detach-tag`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ tag_id: tagId })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.ok) {
                            attachedTags = data.tags;
                            e.target.parentElement.remove();
                            updateTagSelect(attachedTags);
                        }
                    });
            }
        });

        function loadComments() {
            fetch("{{ route('issues.comments', $issue->id) }}")
                .then(res => res.text())
                .then(html => document.getElementById('comments-list').innerHTML = html);
        }
        document.addEventListener('DOMContentLoaded', loadComments);

        document.getElementById('comment-form').addEventListener('submit', function (e) {
            e.preventDefault();
            document.getElementById('author_name_error').innerText = '';
            document.getElementById('body_error').innerText = '';

            const data = {
                author_name: document.getElementById('author_name').value,
                body: document.getElementById('body').value
            };

            fetch("{{ route('issues.comments.store', $issue->id) }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            })
                .then(res => {
                    if (res.status === 422) {
                        return res.json().then(errors => {
                            if (errors.errors.author_name) {
                                document.getElementById('author_name_error').innerText = errors.errors.author_name[0];
                            }
                            if (errors.errors.body) {
                                document.getElementById('body_error').innerText = errors.errors.body[0];
                            }
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        const commentHtml = `<div class="mb-2 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <strong class="text-gray-800">${data.comment.author_name}</strong>
                <p class="text-gray-700 mt-1">${data.comment.body}</p>
                <small class="text-gray-500">Just now</small>
            </div>`;
                        document.getElementById('comments-list').insertAdjacentHTML('afterbegin', commentHtml);
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
                .then(data => {
                    if (data.success) location.reload();
                });
        });

        document.querySelectorAll('.detach-member').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.dataset.userId;
                fetch("{{ url('/issues/'.$issue->id.'/users') }}/" + userId, {
                    method: "DELETE",
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(res => res.json())
                    .then(data => {
                        if (data.success) location.reload();
                    });
            });
        });
    </script>
@endsection
