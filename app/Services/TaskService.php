<?php

namespace App\Services;

use App\Models\Task;

class TaskService extends BaseService
{
    public function __construct(protected Task $task) {}

    public function getModel(): Task
    {
        return $this->task;
    }

    public function changeStatus($taskId, $status)
    {
        $task = $this->find($taskId);

        $task->update([
            'status' => $status,
        ]);

        return $task;
    }
}
