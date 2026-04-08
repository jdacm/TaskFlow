<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low',    'color' => '#22c55e', 'level' => 1],
            ['name' => 'Medium', 'color' => '#f59e0b', 'level' => 2],
            ['name' => 'High',   'color' => '#ef4444', 'level' => 3],
            ['name' => 'Urgent', 'color' => '#7c3aed', 'level' => 4],
        ];

        foreach ($priorities as $priority) {
            Priority::firstOrCreate(['name' => $priority['name']], $priority);
        }
    }
}
