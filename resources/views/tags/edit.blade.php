@extends('layouts.app')

@section('title', 'Edit Tag')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Tag</h2>

            <form action="{{ route('tags.update', $tag) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Tag Name</label>
                    <input type="text" name="name" id="name"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror"
                           value="{{ old('name', $tag->name) }}" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="color" class="block text-sm font-medium text-gray-700">Color (Hex Code)</label>
                    <input type="color" name="color" id="color"
                           class="mt-1 h-10 w-20 cursor-pointer rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           value="{{ old('color', $tag->color) }}" required>
                </div>

                <div class="flex space-x-3">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700">
                        Update
                    </button>
                    <a href="{{ route('tags.index') }}"
                       class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-lg shadow hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
