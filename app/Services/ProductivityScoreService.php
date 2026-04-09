<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;

class ProductivityScoreService
{
    /**
     * Calculate weekly productivity score for a user
     * 
     * @param int $userId
     * @return array
     */
    public function calculateWeeklyScore($userId): array
    {
        $now = Carbon::now();
        $weekStart = $now->copy()->startOfWeek(); // Monday
        $weekEnd = $now->copy()->endOfWeek();     // Sunday

        // Get all tasks for the current week
        $tasksThisWeek = Task::forUser($userId)
            ->whereBetween('due_date', [$weekStart, $weekEnd])
            ->get();

        // Categorize tasks
        $completedTasks = $tasksThisWeek->where('status', 'completed')->count();
        $overdueTasks = $tasksThisWeek->filter(fn($task) => $task->isOverdue())->count();
        $pendingTasks = $tasksThisWeek->where('status', 'pending')->count();
        $inProgressTasks = $tasksThisWeek->where('status', 'in_progress')->count();

        // Total non-overdue tasks (used for score calculation)
        $totalTasksForScore = $tasksThisWeek->filter(fn($task) => !$task->isOverdue())->count();

        // Calculate productivity score
        $productivityScore = $totalTasksForScore > 0 
            ? round(($completedTasks / $totalTasksForScore) * 100) 
            : 0;

        return [
            'productivity_score' => $productivityScore,
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
            'in_progress_tasks' => $inProgressTasks,
            'overdue_tasks' => $overdueTasks,
            'total_tasks' => $totalTasksForScore,
            'week_start' => $weekStart->format('M d'),
            'week_end' => $weekEnd->format('M d'),
        ];
    }

    /**
     * Get color class based on productivity score
     * 
     * @param int $score
     * @return array
     */
    public function getScoreColors($score): array
    {
        return match(true) {
            $score >= 75 => [
                'bg_color' => 'bg-emerald-500/10',
                'text_color' => 'text-emerald-400',
                'progress_color' => 'bg-emerald-500',
                'border_color' => 'border-emerald-500/20',
            ],
            $score >= 40 => [
                'bg_color' => 'bg-amber-500/10',
                'text_color' => 'text-amber-400',
                'progress_color' => 'bg-amber-500',
                'border_color' => 'border-amber-500/20',
            ],
            default => [
                'bg_color' => 'bg-red-500/10',
                'text_color' => 'text-red-400',
                'progress_color' => 'bg-red-500',
                'border_color' => 'border-red-500/20',
            ],
        };
    }

    /**
     * Get motivational message based on score
     * 
     * @param int $score
     * @return string
     */
    public function getMotivationalMessage($score): string
    {
        return match(true) {
            $score >= 75 => '🎉 Great job! You\'re highly productive.',
            $score >= 40 => '💪 You\'re doing okay, keep going.',
            default => '📈 You need to improve task completion.',
        };
    }
}
