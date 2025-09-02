@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Project</h1>

        <form action="{{ route('projects.store') }}" method="POST" class="space-y-5">
            @csrf

            @include('projects.partials.form')

            <div class="flex justify-end space-x-3">
                <a href="{{ route('projects.index') }}"
                   class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 shadow">
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection
