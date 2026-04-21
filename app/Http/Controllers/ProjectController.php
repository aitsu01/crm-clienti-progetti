<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;


class ProjectController extends Controller
{
    public function index(): Response
    {
        $projects = Project::with('clients:id,first_name,last_name')
            ->latest()
            ->get()
            ->map(function (Project $project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,
                    'status' => $project->status,
                    'start_date' => $project->start_date?->format('Y-m-d'),
                    'end_date' => $project->end_date?->format('Y-m-d'),
                    'clients' => $project->clients->map(fn ($client) => [
                        'id' => $client->id,
                        'full_name' => trim($client->first_name . ' ' . $client->last_name),
                    ])->values(),
                ];
            });

        return Inertia::render('projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function create(): Response
    {
        $clients = Client::query()
            ->select('id', 'first_name', 'last_name')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(fn ($client) => [
                'id' => $client->id,
                'name' => trim($client->first_name . ' ' . $client->last_name),
            ])
            ->values();

        return Inertia::render('projects/Create', [
            'clients' => $clients,
            'statuses' => [
                ['label' => 'Da fare', 'value' => 'da_fare'],
                ['label' => 'In corso', 'value' => 'in_corso'],
                ['label' => 'Completato', 'value' => 'completato'],
                ['label' => 'Sospeso', 'value' => 'sospeso'],
            ],
        ]);
    }

   public function store(StoreProjectRequest $request)
{
    $validated = $request->validated();

    $project = Project::create([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'status' => $validated['status'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'] ?? null,
    ]);

    $project->clients()->sync($validated['client_ids'] ?? []);

    return redirect()
        ->route('projects.index')
        ->with('success', 'Progetto creato con successo.');
}

    public function show(Project $project): Response
    {
        $project->load([
            'clients:id,first_name,last_name',
            'tasks:id,project_id,title,status,priority,due_date',
        ]);

        return Inertia::render('projects/Show', [
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'status' => $project->status,
                'start_date' => $project->start_date?->format('Y-m-d'),
                'end_date' => $project->end_date?->format('Y-m-d'),
                'clients' => $project->clients->map(fn ($client) => [
                    'id' => $client->id,
                    'full_name' => trim($client->first_name . ' ' . $client->last_name),
                ])->values(),

                'tasks' => $project->tasks->map(fn ($task) => [
    'id' => $task->id,
    'title' => $task->title,
    'description' => $task->description,
    'status' => $task->status,
    'priority' => $task->priority,
    'due_date' => $task->due_date?->format('Y-m-d'),
])->values(),

                


            ],
        ]);
    }

    public function edit(Project $project): Response
    {
        $project->load('clients:id,first_name,last_name');

        $clients = Client::query()
            ->select('id', 'first_name', 'last_name')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get()
            ->map(fn ($client) => [
                'id' => $client->id,
                'name' => trim($client->first_name . ' ' . $client->last_name),
            ])
            ->values();

        return Inertia::render('projects/Edit', [
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'status' => $project->status,
                'start_date' => $project->start_date?->format('Y-m-d'),
                'end_date' => $project->end_date?->format('Y-m-d'),
                'client_ids' => $project->clients->pluck('id')->values(),
            ],
            'clients' => $clients,
            'statuses' => [
                ['label' => 'Da fare', 'value' => 'da_fare'],
                ['label' => 'In corso', 'value' => 'in_corso'],
                ['label' => 'Completato', 'value' => 'completato'],
                ['label' => 'Sospeso', 'value' => 'sospeso'],
            ],
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
{
    $validated = $request->validated();

    $project->update([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'status' => $validated['status'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'] ?? null,
    ]);

    $project->clients()->sync($validated['client_ids'] ?? []);

    return redirect()
        ->route('projects.index')
        ->with('success', 'Progetto aggiornato con successo.');
}
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Progetto eliminato con successo.');
    }

   
   
}