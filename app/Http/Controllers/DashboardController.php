<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'clients' => Client::count(),
                'projects' => Project::count(),
                'tasks' => Task::count(),
                'tasks_completed' => Task::where('status', 'completata')->count(),
                'tasks_in_progress' => Task::where('status', 'in_corso')->count(),
            ],
        ]);
    }
}