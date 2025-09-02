@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $project->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $project->description }}</p>

            <p class="text-gray-700">
                <strong class="font-semibold">Start:</strong> {{ $project->start_date }}
                <span class="mx-2">|</span>
                <strong class="font-semibold">Deadline:</strong> {{ $project->deadline }}
            </p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Issues</h3>

            @if($project->issues->isEmpty())
                <p class="text-gray-500">No issues found for this project.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                        <tr class="text-left text-gray-700 text-sm">
                            <th class="px-4 py-2 border">Title</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Priority</th>
                            <th class="px-4 py-2 border">Tags</th>
                            <th class="px-4 py-2 border">Due Date</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($project->issues as $issue)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $issue->title }}</td>
                                <td class="px-4 py-2 capitalize">{{ $issue->status }}</td>
                                <td class="px-4 py-2 capitalize">{{ $issue->priority }}</td>
                                <td class="px-4 py-2 space-x-1">
                                    @foreach($issue->tags as $tag)
                                        <span class="inline-block px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2">
                                    {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('issues.show', $issue) }}"
                                       class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                                        View
                                    </a>
                                    <a href="{{ route('issues.edit', $issue) }}"
                                       class="px-3 py-1 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('issues.destroy', $issue) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600"
                                                onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        @if ($errors->any())
            <div class="mt-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
                <strong class="font-semibold">Please fix the following errors:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('projects.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
                Back
            </a>
        </div>
    </div>
@endsection
