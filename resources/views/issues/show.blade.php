@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3">{{ $issue->title }}</h1>

        <p><strong>Project:</strong> {{ $issue->project->name }}</p>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $issue->status)) }}</p>
        <p><strong>Priority:</strong> {{ ucfirst($issue->priority) }}</p>
        <p><strong>Due Date:</strong> {{ $issue->due_date ?? '-' }}</p>
        <p><strong>Description:</strong> {{ $issue->description ?? '-' }}</p>

        {{-- Tags --}}
        <h3 class="mt-4">Tags</h3>
        <div id="tags-list" class="mb-2">
            @foreach($issue->tags as $tag)
                <span class="badge bg-secondary me-1">
                {{ $tag->name }}
                <button class="btn-close btn-close-white btn-sm remove-tag" data-tag-id="{{ $tag->id }}"></button>
            </span>
            @endforeach
        </div>

        <h5>Attach Tag</h5>
        <div class="d-flex align-items-center mb-4">
            <select id="attach-tag" class="form-select w-25 me-2">
                <option value="">Select Tag</option>
                @foreach($tags as $tag)
                    @if(!$issue->tags->contains($tag->id))
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endif
                @endforeach
            </select>
            <button id="attach-btn" class="btn btn-primary">Attach</button>
        </div>

        {{-- Comments --}}
        <h3>Comments</h3>
        <div id="comments-list" class="mb-3">
            {{-- Comments will be loaded via AJAX --}}
        </div>

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
    </div>
@endsection

@section('scripts')
    <script>
        // --- TAGS ---
        document.getElementById('attach-btn').addEventListener('click', function() {
            let tagId = document.getElementById('attach-tag').value;
            if(!tagId) return;

            fetch("{{ route('issues.attachTag', $issue->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tag_id: tagId })
            })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        let tagList = document.getElementById('tags-list');
                        tagList.innerHTML += `<span class="badge bg-secondary me-1">
                ${data.tag.name}
                <button class="btn-close btn-close-white btn-sm remove-tag" data-tag-id="${data.tag.id}"></button>
            </span>`;
                        document.getElementById('attach-tag').querySelector(`option[value="${tagId}"]`).remove();
                    }
                });
        });

        // Remove tag
        document.getElementById('tags-list').addEventListener('click', function(e){
            if(e.target.classList.contains('remove-tag')){
                let tagId = e.target.dataset.tagId;
                fetch("{{ route('issues.detachTag', $issue->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ tag_id: tagId })
                })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            e.target.parentElement.remove();
                            let select = document.getElementById('attach-tag');
                            select.innerHTML += `<option value="${data.tag.id}">${data.tag.name}</option>`;
                        }
                    });
            }
        });

        // --- COMMENTS ---
        function loadComments() {
            fetch("{{ route('issues.comments', $issue->id) }}")
                .then(res => res.text())
                .then(html => {
                    document.getElementById('comments-list').innerHTML = html;
                });
        }

        document.addEventListener('DOMContentLoaded', loadComments);

        document.getElementById('comment-form').addEventListener('submit', function(e){
            e.preventDefault();

            document.getElementById('author_name_error').innerText = '';
            document.getElementById('body_error').innerText = '';

            let data = {
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
                        let commentsList = document.getElementById('comments-list');
                        let commentHtml = `<div class="card mb-2">
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
    </script>
@endsection
