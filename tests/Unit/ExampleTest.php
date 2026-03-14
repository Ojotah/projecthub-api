<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_service_changes_task_status(): void
    {
        $user = User::factory()->create();
        $project = Project::create([
            'name' => 'Analytics',
            'description' => 'Dashboard metrics',
            'owner_id' => $user->id,
        ]);
        $task = Task::create([
            'title' => 'Track KPI',
            'description' => 'Add KPI endpoint',
            'status' => 'todo',
            'project_id' => $project->id,
            'created_by' => $user->id,
        ]);

        $service = app(TaskService::class);
        $updatedTask = $service->changeStatus($task->id, 'in_progress');

        $this->assertSame('in_progress', $updatedTask->status);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'in_progress',
        ]);
    }
}
