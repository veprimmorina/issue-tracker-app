@extends('layouts.app')

@section('title', 'Create Issue')

@section('content')
    <div class="max-w-3xl mx-auto mt-6 bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Create New Issue</h1>

        <form action="{{ route('issues.store') }}" method="POST" class="max-w-md mx-auto space-y-4">
            @csrf

            @include('issues.form', ['buttonText' => 'Create Issue'])
        </form>
    </div>
@endsection
