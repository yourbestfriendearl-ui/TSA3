<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Capture one Manila calendar day so the fixtures agree across midnight.
        $today = Carbon::today(config('app.timezone'));
        $records = [
            [1, 'Review database schema', 'completed', -1],
            [2, 'Organize project files', 'completed', -1],
            [3, 'Review Laravel routes', 'pending', 0],
            [4, 'Prepare database backup', 'pending', 0],
            [5, 'Check the profile page', 'completed', 0],
            [6, 'Write README setup steps', 'pending', 0],
            [7, 'Review the task list', 'pending', 1],
            [8, 'Prepare project presentation', 'pending', 1],
        ];

        foreach ($records as [$id, $title, $status, $offset]) {
            Task::updateOrCreate(['id' => $id], [
                'title' => $title,
                'status' => $status,
                'task_date' => $today->copy()->addDays($offset)->toDateString(),
            ]);
        }
    }
}
