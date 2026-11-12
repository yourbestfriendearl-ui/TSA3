<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TasksForTodayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(Carbon::create(2026, 11, 12, 9, 0, 0, 'Asia/Manila'));
        $this->seed(DatabaseSeeder::class);
    }

    public function test_all_four_required_pages_are_available(): void
    {
        foreach (['/', '/tasks', '/profile', '/about'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_seed_has_eight_tasks_three_dates_and_one_user(): void
    {
        $this->assertDatabaseCount('tasks', 8);
        $this->assertDatabaseCount('users', 1);
        $this->assertSame(3, Task::query()->distinct()->count('task_date'));
        $this->assertSame(4, Task::query()->whereDate('task_date', '2026-11-12')->count());
    }

    public function test_welcome_only_receives_todays_eloquent_records(): void
    {
        $response = $this->get('/')->assertOk();
        $response->assertViewHas('tasks', fn ($rows) => $rows instanceof Collection && $rows->count() === 4);
        $this->assertSame([3, 4, 5, 6], $response->viewData('tasks')->pluck('id')->all());
        $response->assertSee('Review Laravel routes')->assertDontSee('Review database schema')->assertDontSee('Prepare project presentation');
    }

    public function test_task_list_has_all_records_in_date_order(): void
    {
        $response = $this->get('/tasks')->assertOk();
        $rows = $response->viewData('tasks');
        $this->assertInstanceOf(Collection::class, $rows);
        $this->assertCount(8, $rows);
        $dates = $rows->map(fn (Task $task) => $task->task_date->toDateString())->all();
        $sorted = $dates;
        sort($sorted);
        $this->assertSame($sorted, $dates);
        $response->assertSee('Review database schema')->assertSee('Prepare project presentation');
    }

    public function test_profile_displays_the_single_database_user(): void
    {
        $this->get('/profile')->assertOk()->assertViewHas('user', fn ($user) => $user instanceof User)
            ->assertSee('earl.velasquez')->assertSee('Earl Christian R. Velasquez')->assertSee('earl.velasquez@example.com');
    }

    public function test_today_follows_the_manila_calendar_at_midnight(): void
    {
        $this->travelTo(Carbon::create(2026, 11, 13, 0, 1, 0, 'Asia/Manila'));
        $response = $this->get('/')->assertOk();
        $this->assertSame([7, 8], $response->viewData('tasks')->pluck('id')->all());
        $response->assertDontSee('Review Laravel routes');
    }

    public function test_reseeding_on_a_later_day_keeps_eight_tasks_one_user_and_creation_time(): void
    {
        $createdAt = Task::findOrFail(3)->created_at->copy();
        $this->travelTo(Carbon::create(2026, 11, 14, 9, 0, 0, 'Asia/Manila'));
        $this->seed(DatabaseSeeder::class);
        $this->assertDatabaseCount('tasks', 8);
        $this->assertDatabaseCount('users', 1);
        $this->assertSame(3, Task::query()->distinct()->count('task_date'));
        $this->assertSame('2026-11-14', Task::findOrFail(3)->task_date->toDateString());
        $this->assertTrue(Task::findOrFail(3)->created_at->equalTo($createdAt));
    }

    public function test_status_defaults_to_pending(): void
    {
        $task = Task::create(['title' => 'Task without explicit status', 'task_date' => '2026-11-12']);
        $this->assertSame('pending', $task->refresh()->status);
    }

    public function test_views_show_database_changes_without_controller_edits(): void
    {
        Task::findOrFail(3)->update(['title' => 'Updated database task']);
        User::findOrFail(1)->update(['full_name' => 'Updated profile name']);
        $this->get('/')->assertSee('Updated database task');
        $this->get('/tasks')->assertSee('Updated database task');
        $this->get('/profile')->assertSee('Updated profile name');
    }

    public function test_empty_records_have_clear_messages(): void
    {
        Task::query()->delete();
        User::query()->delete();
        $this->get('/')->assertOk()->assertSee('No tasks are scheduled for today.');
        $this->get('/tasks')->assertOk()->assertSee('No tasks are available.');
        $this->get('/profile')->assertOk()->assertSee('No profile record is available.');
    }

    public function test_task_titles_are_html_escaped(): void
    {
        Task::findOrFail(3)->update(['title' => '<script>alert(1)</script>']);
        $this->get('/')->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_usernames_must_be_unique(): void
    {
        $this->expectException(QueryException::class);
        User::create(['username' => 'earl.velasquez', 'full_name' => 'Duplicate', 'email' => 'duplicate@example.com']);
    }
}
