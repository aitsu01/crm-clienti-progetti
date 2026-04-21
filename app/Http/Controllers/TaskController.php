<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;


class TaskController extends Controller
{
  public function index(): Response
{
    $tasks = Task::with('project:id,name')
        ->latest()
        ->get()
        ->map(function (Task $task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'due_date' => $task->due_date?->format('Y-m-d'),
                'project' => $task->project ? [
                    'id' => $task->project->id,
                    'name' => $task->project->name,
                ] : null,
            ];
        })
        ->values();

    return Inertia::render('tasks/Index', [
        'tasks' => $tasks,
        'statuses' => [
            ['label' => 'Da fare', 'value' => 'da_fare'],
            ['label' => 'In corso', 'value' => 'in_corso'],
            ['label' => 'In revisione', 'value' => 'in_revisione'],
            ['label' => 'Completata', 'value' => 'completata'],
            ['label' => 'Bloccata', 'value' => 'bloccata'],
        ],
    ]);
}

    public function create(Request $request): Response
{
    $projects = Project::query()
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

    return Inertia::render('tasks/Create', [
        'projects' => $projects,
        'selectedProjectId' => $request->integer('project_id') ?: null,
        'statuses' => [
            ['label' => 'Da fare', 'value' => 'da_fare'],
            ['label' => 'In corso', 'value' => 'in_corso'],
            ['label' => 'In revisione', 'value' => 'in_revisione'],
            ['label' => 'Completata', 'value' => 'completata'],
            ['label' => 'Bloccata', 'value' => 'bloccata'],
        ],
        'priorities' => [
            ['label' => 'Bassa', 'value' => 'bassa'],
            ['label' => 'Media', 'value' => 'media'],
            ['label' => 'Alta', 'value' => 'alta'],
        ],
    ]);
}

   public function store(StoreTaskRequest $request)
{
    $validated = $request->validated();

    Task::create([
        'project_id' => $validated['project_id'],
        'title' => $validated['title'],
        'description' => $validated['description'] ?? null,
        'status' => $validated['status'],
        'priority' => $validated['priority'],
        'due_date' => $validated['due_date'] ?? null,
    ]);

    return redirect()
        ->route('tasks.index')
        ->with('success', 'Task creata con successo.');
}
    public function show(Task $task): Response
    {
        $task->load('project:id,name');

        return Inertia::render('tasks/Show', [
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'due_date' => $task->due_date?->format('Y-m-d'),
                'project' => $task->project ? [
                    'id' => $task->project->id,
                    'name' => $task->project->name,
                ] : null,
            ],
        ]);
    }

    public function edit(Task $task): Response
    {
        $projects = Project::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return Inertia::render('tasks/Edit', [
            'task' => [
                'id' => $task->id,
                'project_id' => $task->project_id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'due_date' => $task->due_date?->format('Y-m-d'),
            ],
            'projects' => $projects,
            'statuses' => [
                ['label' => 'Da fare', 'value' => 'da_fare'],
                ['label' => 'In corso', 'value' => 'in_corso'],
                ['label' => 'In revisione', 'value' => 'in_revisione'],
                ['label' => 'Completata', 'value' => 'completata'],
                ['label' => 'Bloccata', 'value' => 'bloccata'],
            ],
            'priorities' => [
                ['label' => 'Bassa', 'value' => 'bassa'],
                ['label' => 'Media', 'value' => 'media'],
                ['label' => 'Alta', 'value' => 'alta'],
            ],
        ]);
    }

   public function update(UpdateTaskRequest $request, Task $task)
{
    $validated = $request->validated();

    $task->update([
        'project_id' => $validated['project_id'],
        'title' => $validated['title'],
        'description' => $validated['description'] ?? null,
        'status' => $validated['status'],
        'priority' => $validated['priority'],
        'due_date' => $validated['due_date'] ?? null,
    ]);

    return redirect()
        ->route('tasks.index')
        ->with('success', 'Task aggiornata con successo.');
}
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task eliminata con successo.');
    }

   

    public function updateStatus(Request $request, Task $task)
{
    $validated = $request->validate([
        'status' => ['required', Rule::in([
            'da_fare',
            'in_corso',
            'in_revisione',
            'completata',
            'bloccata',
        ])],
    ], [
        'status.required' => 'Lo stato è obbligatorio.',
        'status.in' => 'Lo stato selezionato non è valido.',
    ]);

    $task->update([
        'status' => $validated['status'],
    ]);

    return back()->with('success', 'Stato task aggiornato con successo.');
}



}
