<?php

namespace App\Http\Controllers;

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
        });

    return Inertia::render('tasks/Index', [
        'tasks' => $tasks,
    ]);
}

    public function create(): Response
    {
        $projects = Project::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return Inertia::render('tasks/Create', [
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

    public function store(Request $request)
    {
        $validated = $this->validateTask($request);

        Task::create($validated);

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

    public function update(Request $request, Task $task)
    {
        $validated = $this->validateTask($request);

        $task->update($validated);

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

    private function validateTask(Request $request): array
    {
        return $request->validate([
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['da_fare', 'in_corso', 'in_revisione', 'completata', 'bloccata'])],
            'priority' => ['required', Rule::in(['bassa', 'media', 'alta'])],
            'due_date' => ['nullable', 'date'],
        ], [
            'project_id.required' => 'Il progetto è obbligatorio.',
            'title.required' => 'Il titolo della task è obbligatorio.',
            'status.required' => 'Lo stato è obbligatorio.',
            'priority.required' => 'La priorità è obbligatoria.',
        ]);
    }
}
