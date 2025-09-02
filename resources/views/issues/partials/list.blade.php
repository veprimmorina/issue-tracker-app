@foreach($issues as $issue)
    <tr class="hover:bg-gray-50">
        <td class="px-4 py-2 text-sm text-gray-800">{{ $issue->title }}</td>
        <td class="px-4 py-2 text-sm text-gray-600">{{ $issue->project->name ?? '-' }}</td>

        <td class="px-4 py-2">
            @php
                $statusColors = [
                    'open' => 'bg-green-100 text-green-800',
                    'in_progress' => 'bg-yellow-100 text-yellow-800',
                    'closed' => 'bg-red-100 text-red-800',
                ];
            @endphp
            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$issue->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
            </span>
        </td>

        <td class="px-4 py-2">
            @php
                $priorityColors = [
                    'low' => 'bg-blue-100 text-blue-800',
                    'medium' => 'bg-yellow-100 text-yellow-800',
                    'high' => 'bg-red-100 text-red-800',
                ];
            @endphp
            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $priorityColors[$issue->priority] ?? 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($issue->priority) }}
            </span>
        </td>

        <td class="px-4 py-2 space-x-1">
            @foreach($issue->tags as $tag)
                <span class="inline-block px-2 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-medium">
                    {{ $tag->name }}
                </span>
            @endforeach
        </td>

        <td class="px-4 py-2 text-sm text-gray-600">
            {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('Y-m-d') : 'N/A' }}
        </td>

        <td class="px-4 py-2 text-right text-sm">
            <a href="{{ route('issues.show', $issue) }}"
               class="text-indigo-600 hover:text-indigo-900 font-medium">View</a>
        </td>
    </tr>
@endforeach
