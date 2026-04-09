<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\ProductivityScoreService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private ProductivityScoreService $productivityService;

    public function __construct(ProductivityScoreService $productivityService)
    {
        $this->productivityService = $productivityService;
    }

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

        // Calculate productivity score
        $productivityData = $this->productivityService->calculateWeeklyScore($userId);
        $colors = $this->productivityService->getScoreColors($productivityData['productivity_score']);
        $message = $this->productivityService->getMotivationalMessage($productivityData['productivity_score']);

        return view('dashboard', compact(
            'stats', 
            'recentTasks', 
            'upcomingTasks', 
            'productivityData', 
            'colors', 
            'message'
        ));
    }
}
