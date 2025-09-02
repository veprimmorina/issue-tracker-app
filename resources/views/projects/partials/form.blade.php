<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
    <input type="text" name="name" id="name"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
        @error('name') border-red-500 @enderror"
           value="{{ old('name', $project->name ?? '') }}">
    @error('name')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="description" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
        @error('description') border-red-500 @enderror">{{ old('description', $project->description ?? '') }}</textarea>
    @error('description')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
    <input type="date" name="start_date" id="start_date"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
        @error('start_date') border-red-500 @enderror"
           value="{{ old('start_date', isset($project->start_date) ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}">
    @error('start_date')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
    <input type="date" name="deadline" id="deadline"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
        @error('deadline') border-red-500 @enderror"
           value="{{ old('deadline', isset($project->deadline) ? \Carbon\Carbon::parse($project->deadline)->format('Y-m-d') : '') }}">
    @error('deadline')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
