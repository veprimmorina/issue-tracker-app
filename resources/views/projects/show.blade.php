@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $project->name }}</h1>
        <p>{{ $project->description }}</p>
        <p>
            <strong>Start:</strong> {{ $project->start_date }}
            | <strong>Deadline:</strong> {{ $project->deadline }}
        </p>

        <hr>

        <h3>Issues</h3>
        @if($project->issues->isEmpty())
            <p>No issues found for this project.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Tags</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($project->issues as $issue)
                    <tr>
                        <td>{{ $issue->title }}</td>
                        <td>{{ ucfirst($issue->status) }}</td>
                        <td>{{ ucfirst($issue->priority) }}</td>
                        <td>
                            @foreach($issue->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('issues.show', $issue) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('issues.edit', $issue) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
@endsection
