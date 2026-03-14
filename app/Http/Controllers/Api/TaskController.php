<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->integer('per_page', 15);
        $tasks = $this->taskService->paginate($perPage, ['project', 'comments']);

        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        $data['created_by'] = auth()->id();

        $task = $this->taskService->create($data);

        return new TaskResource($task->loadMissing(['project', 'comments']));
    }

    public function show($id)
    {
        $task = $this->taskService->find($id, ['project', 'comments']);

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        $task = $this->taskService->update($id, $request->validated());

        return new TaskResource($task->loadMissing(['project', 'comments']));
    }

    public function destroy($id)
    {
        $this->taskService->delete($id);

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }

    public function changeStatus(Request $request, $id)
    {
        $task = $this->taskService->changeStatus($id, $request->status);

        return new TaskResource($task->loadMissing(['project', 'comments']));
    }
}
