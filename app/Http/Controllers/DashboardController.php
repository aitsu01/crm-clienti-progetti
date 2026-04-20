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
        $recentClients = Client::latest()
            ->take(5)
            ->get()
            ->map(fn ($client) => [
                'id' => $client->id,
                'name' => trim($client->first_name . ' ' . $client->last_name),
                'type' => $client->type,
                'created_at' => optional($client->created_at)->format('d/m/Y H:i'),
            ])
            ->values();

        $recentProjects = Project::latest()
            ->take(5)
            ->get()
            ->map(fn ($project) => [
                'id' => $project->id,
                'name' => $project->name,
                'status' => $project->status,
                'created_at' => optional($project->created_at)->format('d/m/Y H:i'),
            ])
            ->values();

        $recentTasks = Task::with('project:id,name')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn ($task) => [
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'priority' => $task->priority,
                'project' => $task->project ? [
                    'id' => $task->project->id,
                    'name' => $task->project->name,
                ] : null,
                'created_at' => optional($task->created_at)->format('d/m/Y H:i'),
            ])
            ->values();

        return Inertia::render('Dashboard', [
            'stats' => [
                'clients' => Client::count(),
                'projects' => Project::count(),
                'tasks' => Task::count(),
                'tasks_completed' => Task::where('status', 'completata')->count(),
                'tasks_in_progress' => Task::where('status', 'in_corso')->count(),
            ],
            'recentClients' => $recentClients,
            'recentProjects' => $recentProjects,
            'recentTasks' => $recentTasks,
        ]);
    }
}