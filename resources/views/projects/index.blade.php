@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Projects</h1>
        <a href="{{ route('projects.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
            + New Project
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead>
            <tr class="bg-gray-100 text-left text-sm font-medium text-gray-700">
                <th class="px-6 py-3 border-b">Name</th>
                <th class="px-6 py-3 border-b">Deadline</th>
                <th class="px-6 py-3 border-b">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($projects as $project)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b">{{ $project->name }}</td>
                    <td class="px-6 py-4 border-b">{{ $project->deadline }}</td>
                    <td class="px-6 py-4 border-b space-x-2">
                        <a href="{{ route('projects.show', $project) }}"
                           class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('projects.edit', $project) }}"
                           class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('Delete this project?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No projects found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
@endsection
