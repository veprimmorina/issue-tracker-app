@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Issues</h1>

    <a href="{{ route('issues.create') }}" class="btn btn-primary mb-3">Create New Issue</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Title</th>
            <th>Project</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Tags</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($issues as $issue)
            <tr>
                <td>{{ $issue->title }}</td>
                <td>{{ $issue->project->name }}</td>
                <td>{{ $issue->status }}</td>
                <td>{{ $issue->priority }}</td>
                <td>
                    @foreach($issue->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('issues.show', $issue) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('issues.edit', $issue) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('issues.destroy', $issue) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $issues->links() }}
@endsection
