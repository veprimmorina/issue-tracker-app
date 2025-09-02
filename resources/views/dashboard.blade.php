@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Dashboard</h2>
            <p class="text-gray-600 mb-6">You're logged in!</p>

            <div class="flex space-x-4">
                <a href="{{ route('projects.index') }}"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    Go to Projects
                </a>

                <a href="{{ route('issues.index') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
                    Go to Issues
                </a>

                <a href="{{ route('tags.index') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
                    Go to Tags
                </a>
            </div>
        </div>
    </div>
@endsection
