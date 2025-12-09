<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    protected TaskService $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $tasks = $this->service->listTasks()->map(fn($task) => $this->formatTask($task));

        return response()->json(['data' => $tasks]);
    }

    public function stats(): JsonResponse
    {
        return response()->json(['data' => $this->service->stats()]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->service->createTask($request->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $this->formatTask($task)
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $task = $this->service->showTask($task);

        return response()->json(['data' => $this->formatTask($task)]);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task = $this->service->updateTask($task, $request->validated());

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $this->formatTask($task)
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->service->deleteTask($task);

        return response()->json(['message' => 'Task deleted successfully']);
    }

    private function formatTask(Task $task): array
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'priority' => $task->priority,
            'due_date' => $task->due_date?->format('d M Y'),
            'created_at' => $task->created_at->format('d M Y, h:i A'),
            'updated_at' => $task->updated_at->format('d M Y, h:i A'),
        ];
    }
}
