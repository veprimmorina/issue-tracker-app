@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Issues</h1>

        <div class="mb-4">
            <input type="text" id="issue-search"
                   placeholder="Search issues..."
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <form method="GET" action="{{ route('issues.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <select name="status"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">-- Filter by Status --</option>
                <option value="open" {{ request('status')=='open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Closed</option>
            </select>

            <select name="priority"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">-- Filter by Priority --</option>
                <option value="low" {{ request('priority')=='low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('priority')=='medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('priority')=='high' ? 'selected' : '' }}>High</option>
            </select>

            <select name="tag_id"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">-- Filter by Tag --</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>

            <div class="flex space-x-2">
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700">
                    Apply
                </button>
                <a href="{{ route('issues.index') }}"
                   class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md shadow hover:bg-gray-400 text-center">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Project</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Priority</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Tags</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Due Date</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold text-gray-600">Actions</th>
                </tr>
                </thead>
                <tbody id="issues-body" class="divide-y divide-gray-200">
                @include('issues.partials.list', ['issues' => $issues])
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $issues->links() }}
        </div>
    </div>

    <script>
        function debounce(func, delay = 300) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        const searchInput = document.getElementById('issue-search');

        searchInput.addEventListener('input', debounce(function() {
            const query = this.value;

            fetch("{{ route('issues.search') }}?q=" + encodeURIComponent(query))
                .then(res => res.text())
                .then(html => {
                    document.getElementById('issues-body').innerHTML = html;
                    console.log("Search results updated");
                })
                .catch(err => console.error(err));
        }, 300));
    </script>
@endsection
