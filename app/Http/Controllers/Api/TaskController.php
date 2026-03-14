<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        return $this->taskService->filter($request->all());
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['created_by'] = auth()->id();

        return $this->taskService->create($data);
    }

    public function show($id)
    {
        return $this->taskService->find($id, ['project', 'assignedUser', 'comments']);
    }

    public function update(Request $request, $id)
    {
        return $this->taskService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->taskService->delete($id);
    }

    public function changeStatus(Request $request, $id)
    {
        return $this->taskService->changeStatus($id, $request->status);
    }
}
