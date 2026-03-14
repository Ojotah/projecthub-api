<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task_for_project(): void
    {
        $creator = User::factory()->create();
        $assignee = User::factory()->create();
        $project = Project::create([
            'name' => 'Mobile App',
            'description' => 'Build MVP',
            'owner_id' => $creator->id,
        ]);

        $response = $this->actingAs($creator)->postJson('/api/tasks', [
            'title' => 'Implement authentication',
            'description' => 'Add login and registration flow.',
            'project_id' => $project->id,
            'assigned_to' => $assignee->id,
            'status' => 'todo',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.title', 'Implement authentication')
            ->assertJsonPath('data.created_by', $creator->id);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Implement authentication',
            'project_id' => $project->id,
            'assigned_to' => $assignee->id,
            'created_by' => $creator->id,
        ]);
    }

    public function test_task_status_can_be_changed(): void
    {
        $user = User::factory()->create();
        $project = Project::create([
            'name' => 'Backend API',
            'description' => 'Build endpoints',
            'owner_id' => $user->id,
        ]);
        $task = Task::create([
            'title' => 'Draft docs',
            'description' => 'Write API docs',
            'status' => 'todo',
            'project_id' => $project->id,
            'created_by' => $user->id,
        ]);

        $response = $this->patchJson("/api/tasks/{$task->id}/status", [
            'status' => 'done',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.status', 'done');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'done',
        ]);
    }
}
