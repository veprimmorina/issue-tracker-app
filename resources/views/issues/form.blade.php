@extends('layouts.app')

@section('title', isset($issue) ? 'Edit Issue' : 'Create Issue')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">
            {{ isset($issue) ? 'Edit Issue' : 'Create New Issue' }}
        </h1>

        <form action="{{ isset($issue) ? route('issues.update', $issue) : route('issues.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($issue))
                @method('PUT')
            @endif

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $issue->title ?? '') }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                <select name="project_id" id="project_id"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select a project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $issue->project_id ?? '') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="open" {{ old('status', $issue->status ?? '') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ old('status', $issue->status ?? '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="closed" {{ old('status', $issue->status ?? '') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select name="priority" id="priority"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="low" {{ old('priority', $issue->priority ?? '') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $issue->priority ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $issue->priority ?? '') == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                <select name="tags[]" id="tags" multiple
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ (isset($issue) && $issue->tags->contains($tag->id)) || (collect(old('tags'))->contains($tag->id)) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $issue->due_date ?? '') }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('issues.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    {{ isset($issue) ? 'Update Issue' : 'Create Issue' }}
                </button>
            </div>
        </form>
    </div>
@endsection
