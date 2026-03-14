<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService) {}

    public function index()
    {
        $projects = $this->projectService->all(['tasks']);

        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $data['owner_id'] = auth()->id();

        $project = $this->projectService->create($data);

        return new ProjectResource($project->loadMissing(['tasks', 'members']));
    }

    public function show($id)
    {
        $project = $this->projectService->find($id, ['tasks', 'members']);

        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = $this->projectService->update($id, $request->validated());

        return new ProjectResource($project->loadMissing(['tasks', 'members']));
    }

    public function destroy($id)
    {
        $this->projectService->delete($id);

        return response()->json([
            'message' => 'Project deleted successfully',
        ]);
    }
}
