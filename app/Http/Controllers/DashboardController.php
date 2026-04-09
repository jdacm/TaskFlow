<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $userId = Auth::id();

        $stats = [
            'total'       => Task::forUser($userId)->count(),
            'pending'     => Task::forUser($userId)->byStatus('pending')->count(),
            'in_progress' => Task::forUser($userId)->byStatus('in_progress')->count(),
            'completed'   => Task::forUser($userId)->byStatus('completed')->count(),
            'overdue'     => Task::forUser($userId)
                ->where('status', '!=', 'completed')
                ->whereDate('due_date', '<', now())
                ->count(),
        ];

        $recentTasks = Task::with(['subject', 'priority'])
            ->forUser($userId)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $upcomingTasks = Task::with(['subject', 'priority'])
            ->forUser($userId)
            ->where('status', '!=', 'completed')
            ->whereDate('due_date', '>=', now())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        // Recent completed tasks (history)
        $recentCompleted = Task::with(['subject', 'priority'])
            ->forUser($userId)
            ->byStatus('completed')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Today's tasks
        $todaysTasks = Task::with(['subject', 'priority'])
            ->forUser($userId)
            ->whereDate('due_date', today())
            ->orderBy('due_date')
            ->get();

        return view('dashboard', compact('stats', 'recentTasks', 'upcomingTasks', 'recentCompleted', 'todaysTasks'));
    }
}
