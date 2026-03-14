<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_project_and_is_set_as_owner(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/projects', [
            'name' => 'Project Hub API',
            'description' => 'Core API for project management.',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('data.name', 'Project Hub API')
            ->assertJsonPath('data.owner_id', $user->id);

        $this->assertDatabaseHas('projects', [
            'name' => 'Project Hub API',
            'owner_id' => $user->id,
        ]);
    }

    public function test_projects_index_returns_tasks_relationship(): void
    {
        $owner = User::factory()->create();
        Project::create([
            'name' => 'Website Redesign',
            'description' => 'Refresh UI and UX.',
            'owner_id' => $owner->id,
        ]);

        $response = $this->getJson('/api/projects');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'description',
                        'owner_id',
                        'tasks',
                    ],
                ],
            ]);
    }
}
