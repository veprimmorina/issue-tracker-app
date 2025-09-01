@extends('layouts.app')

@section('title', 'Create Tag')

@section('content')
    <div class="container mt-4">
        <h2>Create New Tag</h2>

        <form action="{{ route('tags.store') }}" method="POST" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tag Name</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Color (Hex Code)</label>
                <input type="color" name="color" id="color"
                       class="form-control form-control-color"
                       value="{{ old('color', '#0d6efd') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('tags.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
