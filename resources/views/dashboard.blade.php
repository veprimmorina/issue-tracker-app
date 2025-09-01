@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="mb-0">Dashboard</h2>
            </div>
            <div class="card-body">
                <p class="mb-3">You're logged in!</p>

                <a href="{{ route('projects.index') }}" class="btn btn-primary">
                    Go to Projects
                </a>

                <a href="{{ route('issues.index') }}" class="btn btn-secondary ms-2">
                    Go to Issues
                </a>

                <a href="{{ route('tags.index') }}" class="btn btn-secondary ms-2">
                    Go to Tags
                </a>
            </div>
        </div>
    </div>
@endsection
