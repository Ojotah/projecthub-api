<?php

namespace App\Services;

use App\Models\Project;

class ProjectService extends BaseService
{
    public function __construct(protected Project $project)
    {
    }

    public function addMember($projectId, $userId)
    {
        $project = $this->find($projectId);

        $project->members()->attach($userId);

        return $project;
    }
}
