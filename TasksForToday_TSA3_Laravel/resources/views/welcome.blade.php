@extends('layouts.app')
@section('title', 'Welcome')
@section('table-caption', 'Tasks scheduled for today')
@section('content')
<p class="eyebrow">WELCOME BACK</p>
<div class="page-heading">
    <div><h1>Today’s tasks</h1><p class="description">{{ $today->format('l, F j, Y') }}</p></div>
    <p class="record-count">{{ $tasks->count() }} scheduled today</p>
</div>
<p class="intro">Your tasks for today, together in one place.</p>
@include('tasks._table', ['tasks' => $tasks, 'emptyMessage' => 'No tasks are scheduled for today.'])
<a class="text-link" href="{{ route('tasks.index') }}">View the complete task list</a>
@endsection
