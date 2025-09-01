@forelse($issues as $issue)
    <tr>
        <td>{{ $issue->title }}</td>
        <td>{{ $issue->project->name }}</td>
        <td>{{ ucfirst($issue->status) }}</td>
        <td>{{ ucfirst($issue->priority) }}</td>
        <td>
            @foreach($issue->tags as $tag)
                <span class="badge bg-secondary">{{ $tag->name }}</span>
            @endforeach
        </td>
        {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('Y-m-d') : 'N/A' }}
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
@empty
    <tr><td colspan="7" class="text-center">No issues found</td></tr>
@endforelse
