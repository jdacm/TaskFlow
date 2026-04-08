<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Priority;
use App\Models\Subject;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks (with search & filter).
     */
    public function index(Request $request)
    {
        $query = Task::with(['subject', 'priority'])
            ->forUser(Auth::id())
            ->orderBy('due_date');

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->bySubject($request->subject_id);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $tasks    = $query->paginate(10)->withQueryString();
        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('tasks.index', compact('tasks', 'subjects'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $subjects   = Subject::where('user_id', Auth::id())->get();
        $priorities = Priority::orderBy('level')->get();

        return view('tasks.create', compact('subjects', 'priorities'));
    }

    /**
     * Store a newly created task.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            Task::create([
                ...$request->validated(),
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('tasks.index')
                ->with('success', 'Task created successfully! 🎉');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create task. Please try again.');
        }
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $this->authorizeTask($task);

        $task->load(['subject', 'priority', 'comments.user']);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the task.
     */
    public function edit(Task $task)
    {
        $this->authorizeTask($task);

        $subjects   = Subject::where('user_id', Auth::id())->get();
        $priorities = Priority::orderBy('level')->get();

        return view('tasks.edit', compact('task', 'subjects', 'priorities'));
    }

    /**
     * Update the specified task.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorizeTask($task);

        try {
            $task->update($request->validated());

            return redirect()->route('tasks.show', $task)
                ->with('success', 'Task updated successfully! ✅');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update task. Please try again.');
        }
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        try {
            $task->delete();

            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete task. Please try again.');
        }
    }

    /**
     * Toggle task completion status.
     */
    public function toggleComplete(Task $task)
    {
        $this->authorizeTask($task);

        $task->update([
            'status' => $task->isCompleted() ? 'pending' : 'completed',
        ]);

        return back()->with('success', $task->isCompleted()
            ? 'Task marked as completed! ✅'
            : 'Task marked as pending.'
        );
    }

    /**
     * Add a comment to a task.
     */
    public function addComment(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'body'    => $request->body,
        ]);

        return back()->with('success', 'Comment added.');
    }

    /**
     * Ensure the authenticated user owns the task.
     */
    private function authorizeTask(Task $task): void
    {
        abort_if($task->user_id !== Auth::id(), 403, 'You do not own this task.');
    }
}
