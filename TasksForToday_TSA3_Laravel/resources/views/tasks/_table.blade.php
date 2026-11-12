<div class="table-container">
    <table>
        <caption class="sr-only">@yield('table-caption', 'Task records')</caption>
        <thead><tr><th scope="col">Task</th><th scope="col">Status</th><th scope="col">Date</th></tr></thead>
        <tbody>
        @forelse ($tasks as $task)
            <tr>
                <td class="task-title">{{ $task->title }}</td>
                <td><span class="status {{ $task->status === 'completed' ? 'done' : 'pending' }}">{{ ucfirst($task->status) }}</span></td>
                <td class="task-date"><time datetime="{{ $task->task_date->toDateString() }}">{{ $task->task_date->format('M j, Y') }}</time></td>
            </tr>
        @empty
            <tr><td class="empty-state" colspan="3">{{ $emptyMessage }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
