@extends('layouts.app')

@section('content')
    <h1>Create New Issue</h1>

    <form action="{{ route('issues.store') }}" method="POST">
        @include('issues.form', ['buttonText' => 'Create Issue'])
    </form>
@endsection
