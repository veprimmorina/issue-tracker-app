@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $project->name }}</h1>
        <p>{{ $project->description }}</p>
        <p><strong>Start:</strong> {{ $project->start_date }} | <strong>Deadline:</strong> {{ $project->deadline }}</p>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
<?php
