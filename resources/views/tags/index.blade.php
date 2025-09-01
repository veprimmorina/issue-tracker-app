@extends('layouts.app')

@section('title', 'Tags')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Tags</h2>
            <a href="{{ route('tags.create') }}" class="btn btn-primary">+ New Tag</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Color</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                    <td>
                        <span class="badge" style="background-color: {{ $tag->color }};">
                            {{ $tag->color }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('tags.destroy', $tag) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this tag?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No tags yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
