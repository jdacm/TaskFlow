<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubtaskController extends Controller
{
    /**
     * Store a newly created subtask.
     */
    public function store(Request $request, Task $task)
    {
        // Authorize that the task belongs to authenticated user
        $this->authorizeTask($task);

        // Validate
        $validated = $request->validate([
            'title' => 'required|string|min:2|max:255',
        ]);

        try {
            $task->subtasks()->create($validated);

            return back()->with('success', 'Subtask added successfully! ✅');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to add subtask. Please try again.');
        }
    }

    /**
     * Toggle subtask completion status.
     */
    public function toggle(Subtask $subtask)
    {
        // Authorize that the task belongs to authenticated user
        $this->authorizeTask($subtask->task);

        try {
            $subtask->toggleCompletion();

            return back()->with('success', $subtask->is_completed
                ? 'Subtask marked as completed! ✅'
                : 'Subtask marked as incomplete.'
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update subtask. Please try again.');
        }
    }

    /**
     * Remove the specified subtask.
     */
    public function destroy(Subtask $subtask)
    {
        // Authorize that the task belongs to authenticated user
        $this->authorizeTask($subtask->task);

        try {
            $subtask->delete();

            return back()->with('success', 'Subtask deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete subtask. Please try again.');
        }
    }

    /**
     * Authorize task ownership.
     */
    private function authorizeTask(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
