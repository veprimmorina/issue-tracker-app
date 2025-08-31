<div class="container">
    <h1>Projects</h1>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">New Project</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Deadline</th>
            <th>Actions</th>
        </tr>
        @foreach ($projects as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->deadline }}</td>
                <td>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this project?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $projects->links() }}
</div>
