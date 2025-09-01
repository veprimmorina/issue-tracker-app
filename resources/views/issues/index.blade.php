@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Issues</h1>

        <div class="mb-3">
            <input type="text" id="issue-search" class="form-control" placeholder="Search issues...">
        </div>

        <form method="GET" action="{{ route('issues.index') }}" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Filter by Status --</option>
                    <option value="open" {{ request('status')=='open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="priority" class="form-select">
                    <option value="">-- Filter by Priority --</option>
                    <option value="low" {{ request('priority')=='low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority')=='medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority')=='high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="tag_id" class="form-select">
                    <option value="">-- Filter by Tag --</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('issues.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Project</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Tags</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="issues-body">
            @include('issues.partials.list', ['issues' => $issues])
            </tbody>
        </table>

        <div>
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
