@extends('layouts.app')

@section('content')
    <h1>Edit Issue</h1>

    <form action="{{ route('issues.update', $issue) }}" method="POST">
        @method('PUT')
        @include('issues.form', ['buttonText' => 'Update Issue'])
    </form>
@endsection
