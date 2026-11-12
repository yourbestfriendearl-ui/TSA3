<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function welcome(): View
    {
        $today = Carbon::today(config('app.timezone'));
        $tasks = Task::query()
            ->whereDate('task_date', $today->toDateString())
            ->orderBy('id')
            ->get();

        return view('welcome', compact('tasks', 'today'));
    }

    public function index(): View
    {
        $tasks = Task::query()->orderBy('task_date')->orderBy('id')->get();

        return view('tasks.index', compact('tasks'));
    }
}
