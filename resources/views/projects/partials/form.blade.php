<div class="mb-3">
    <label for="name" class="form-label">Project Name</label>
    <input type="text" name="name" id="name" class="form-control"
           value="{{ old('name', $project->name ?? '') }}">
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control">{{ old('description', $project->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="start_date" class="form-label">Start Date</label>
    <input type="date" name="start_date" id="start_date" class="form-control"
           value="{{ old('start_date', isset($project->start_date) ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}">
</div>

<div class="mb-3">
    <label for="deadline" class="form-label">Deadline</label>
    <input type="date" name="deadline" id="deadline" class="form-control"
           value="{{ old('deadline', isset($project->deadline) ? \Carbon\Carbon::parse($project->deadline)->format('Y-m-d') : '') }}">
</div>
