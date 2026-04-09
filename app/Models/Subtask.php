<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'title',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    // Relationships
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Helpers
    public function isCompleted(): bool
    {
        return $this->is_completed;
    }

    public function toggleCompletion(): void
    {
        $this->update(['is_completed' => !$this->is_completed]);
    }
}
