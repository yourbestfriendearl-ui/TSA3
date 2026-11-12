@extends('layouts.app')
@section('title', 'Task List')
@section('table-caption', 'All tasks ordered by date')
@section('content')
<p class="eyebrow">YOUR SCHEDULE</p>
<div class="page-heading">
    <div><h1>Task List</h1><p class="description">Every task, ordered by date.</p></div>
    <p class="record-count">{{ $tasks->count() }} total tasks</p>
</div>
@include('tasks._table', ['tasks' => $tasks, 'emptyMessage' => 'No tasks are available.'])
<a class="text-link" href="{{ route('welcome') }}">Return to today’s tasks</a>
@endsection
