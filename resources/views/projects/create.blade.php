<!DOCTYPE html>
<html>
<head>
    <title>Create Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Create Project</h1>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        @if(View::exists('projects.partials.form'))
            @include('projects.partials.form')
        @else
            <div class="mb-3">
                <label for="name" class="form-label">Project Name</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" name="deadline" class="form-control" id="deadline">
            </div>
        @endif

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
</body>
</html>
