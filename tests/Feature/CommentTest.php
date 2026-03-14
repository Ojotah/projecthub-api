<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_comment_on_task(): void
    {
        $user = User::factory()->create();
        $project = Project::create([
            'name' => 'Documentation',
            'description' => 'Improve docs',
            'owner_id' => $user->id,
        ]);
        $task = Task::create([
            'title' => 'Write README',
            'description' => 'Project setup guide',
            'project_id' => $project->id,
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/comments', [
            'task_id' => $task->id,
            'content' => 'I have added all setup steps.',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.task_id', $task->id)
            ->assertJsonPath('data.user_id', $user->id)
            ->assertJsonPath('data.content', 'I have added all setup steps.');

        $this->assertDatabaseHas('comments', [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'content' => 'I have added all setup steps.',
        ]);
    }
}
