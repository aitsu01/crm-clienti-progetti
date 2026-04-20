<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ClientController extends Controller
{
    public function index(): Response
{
    $clients = Client::with('projects:id,name')
        ->latest()
        ->get()
        ->map(function (Client $client) {
            return [
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'full_name' => trim($client->first_name . ' ' . $client->last_name),
                'type' => $client->type,
                'vat_number' => $client->vat_number,
                'tax_code' => $client->tax_code,
                'address' => $client->address,
                'email' => $client->email,
                'projects' => $client->projects->map(fn ($project) => [
                    'id' => $project->id,
                    'name' => $project->name,
                ])->values(),
            ];
        });

    return Inertia::render('clients/Index', [
        'clients' => $clients,
    ]);
}
    public function create(): Response
    {
        $projects = Project::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return Inertia::render('clients/Create', [
            'projects' => $projects,
            'clientTypes' => [
                ['label' => 'Privato', 'value' => 'privato'],
                ['label' => 'Azienda', 'value' => 'azienda'],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateClient($request);

        $client = Client::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'type' => $validated['type'],
            'vat_number' => $validated['vat_number'] ?? null,
            'tax_code' => $validated['tax_code'] ?? null,
            'address' => $validated['address'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        $client->projects()->sync($validated['project_ids'] ?? []);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente creato con successo.');
    }

    public function show(Client $client): Response
    {
        $client->load('projects:id,name,status');

        return Inertia::render('clients/Show', [
            'client' => [
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'full_name' => $client->full_name,
                'type' => $client->type,
                'vat_number' => $client->vat_number,
                'tax_code' => $client->tax_code,
                'address' => $client->address,
                'email' => $client->email,
                'projects' => $client->projects->map(fn ($project) => [
                    'id' => $project->id,
                    'name' => $project->name,
                    'status' => $project->status,
                ])->values(),
            ],
        ]);
    }

    public function edit(Client $client): Response
    {
        $client->load('projects:id,name');

        $projects = Project::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return Inertia::render('clients/Edit', [
            'client' => [
                'id' => $client->id,
                'first_name' => $client->first_name,
                'last_name' => $client->last_name,
                'type' => $client->type,
                'vat_number' => $client->vat_number,
                'tax_code' => $client->tax_code,
                'address' => $client->address,
                'email' => $client->email,
                'project_ids' => $client->projects->pluck('id')->values(),
            ],
            'projects' => $projects,
            'clientTypes' => [
                ['label' => 'Privato', 'value' => 'privato'],
                ['label' => 'Azienda', 'value' => 'azienda'],
            ],
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $this->validateClient($request);

        $client->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'type' => $validated['type'],
            'vat_number' => $validated['vat_number'] ?? null,
            'tax_code' => $validated['tax_code'] ?? null,
            'address' => $validated['address'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        $client->projects()->sync($validated['project_ids'] ?? []);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente aggiornato con successo.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente eliminato con successo.');
    }

    private function validateClient(Request $request): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['privato', 'azienda'])],
            'vat_number' => [
                'nullable',
                'string',
                'max:50',
                Rule::requiredIf(fn () => $request->input('type') === 'azienda'),
            ],
            'tax_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::requiredIf(fn () => $request->input('type') === 'privato'),
            ],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'project_ids' => ['nullable', 'array'],
            'project_ids.*' => ['integer', 'exists:projects,id'],
        ], [
            'first_name.required' => 'Il nome è obbligatorio.',
            'last_name.required' => 'Il cognome è obbligatorio.',
            'type.required' => 'Il tipo cliente è obbligatorio.',
            'vat_number.required' => 'La partita IVA è obbligatoria per le aziende.',
            'tax_code.required' => 'Il codice fiscale è obbligatorio per i privati.',
            'email.email' => 'Inserisci un indirizzo email valido.',
        ]);
    }
}