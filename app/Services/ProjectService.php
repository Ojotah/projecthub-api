<?php

namespace App\Services;

use App\Models\Project;

class ProjectService extends BaseService
{
    public function __construct(protected Project $project) {}

    public function getModel(): Project
    {
        return $this->project;
    }

    /**
     * TODO:
     * Later we will override getQuery() here to add
     * ProjectFilter when we implement API filtering.
     */
    public function addMember($projectId, $userId)
    {
        $project = $this->find($projectId);

        $project->members()->attach($userId);

        return $project;
    }
}
