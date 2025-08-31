@csrf

<div class="mb-3">
    <label for="project_id" class="form-label">Project</label>
    <select name="project_id" id="project_id" class="form-select" required>
        <option value="">Select Project</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ (isset($issue) && $issue->project_id == $project->id) ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
        @endforeach
    </select>
    @error('project_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ $issue->title ?? old('title') }}" required>
    @error('title')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control">{{ $issue->description ?? old('description') }}</textarea>
    @error('description')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <div class="mb-3">
        <label for="tags" class="form-label">Tags</label>
        <select name="tags[]" id="tags" class="form-select" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}"
                    {{ isset($issue) && $issue->tags->contains($tag->id) ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
        @error('tags')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-select" required>
        @foreach(['open', 'in_progress', 'closed'] as $status)
            <option value="{{ $status }}" {{ (isset($issue) && $issue->status == $status) ? 'selected' : '' }}>
                {{ ucfirst(str_replace('_', ' ', $status)) }}
            </option>
        @endforeach
    </select>
    @error('status')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="priority" class="form-label">Priority</label>
    <select name="priority" id="priority" class="form-select" required>
        @foreach(['low', 'medium', 'high'] as $priority)
            <option value="{{ $priority }}" {{ (isset($issue) && $issue->priority == $priority) ? 'selected' : '' }}>
                {{ ucfirst($priority) }}
            </option>
        @endforeach
    </select>
    @error('priority')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="due_date" class="form-label">Due Date</label>
    <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $issue->due_date ?? old('due_date') }}">
    @error('due_date')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
<a href="{{ route('issues.index') }}" class="btn btn-secondary">Cancel</a>
