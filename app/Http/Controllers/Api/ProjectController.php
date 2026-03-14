<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService) {}

    public function index()
    {
        return $this->projectService->all(['tasks']);
    }

    public function store(StoreProjectRequest $request)
    {
        return $this->projectService->create($request->all());
    }

    public function show($id)
    {
        return $this->projectService->find($id, ['tasks', 'members']);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        return $this->projectService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->projectService->delete($id);
    }
}
