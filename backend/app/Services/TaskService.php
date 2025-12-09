<?php

namespace App\Services;


use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * List all tasks for authenticated user.
     */
    public function listTasks()
    {
        return Auth::user()->tasks()->latest()->get();
    }

    /**
     * Get task stats.
     */
    public function stats()
    {
        $user = Auth::user();

        return [
            'total' => $user->tasks()->count(),
            'pending' => $user->tasks()->where('status', 'pending')->count(),
            'in_progress' => $user->tasks()->where('status', 'in_progress')->count(),
            'completed' => $user->tasks()->where('status', 'completed')->count(),
        ];
    }

    /**
     * Create a new task.
     */
    public function createTask(array $data): Task
    {
        $data['due_date'] = isset($data['due_date'])
            ? Carbon::parse($data['due_date'])->format('Y-m-d')
            : null;
        return Auth::user()->tasks()->create($data);
    }

    /**
     * Update a task.
     */
    public function updateTask(Task $task, array $data): Task
    {
        $this->authorizeTask($task);
        $task->update($data);

        return $task;
    }

    /**
     * Delete a task.
     */
    public function deleteTask(Task $task): void
    {
        $this->authorizeTask($task);
        $task->delete();
    }

    /**
     * Show a single task.
     */
    public function showTask(Task $task): Task
    {
        $this->authorizeTask($task);
        return $task;
    }

    /**
     * Ensure task belongs to authenticated user.
     */
    protected function authorizeTask(Task $task)
    {
        if ($task->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
    }
}
