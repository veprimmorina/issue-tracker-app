@extends('layouts.app')

@section('title', 'Edit Issue')

@section('content')
    <div class="max-w-3xl mx-auto mt-6 bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Edit Issue</h1>

        <form action="{{ route('issues.update', $issue) }}" method="POST" class="max-w-md mx-auto space-y-4">
            @csrf
            @method('PUT')
            @include('issues.form', ['buttonText' => 'Update Issue'])
        </form>
    </div>
@endsection
