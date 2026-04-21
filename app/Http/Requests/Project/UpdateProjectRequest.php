<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $project = $this->route('project');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                Rule::unique('projects', 'name')->ignore($project?->id),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['da_fare', 'in_corso', 'completato', 'sospeso'])],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'client_ids' => ['nullable', 'array'],
            'client_ids.*' => ['integer', 'exists:clients,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Il nome progetto è obbligatorio.',
            'name.min' => 'Il nome progetto deve contenere almeno 2 caratteri.',
            'name.unique' => 'Esiste già un progetto con questo nome.',

            'status.required' => 'Lo stato è obbligatorio.',
            'status.in' => 'Lo stato selezionato non è valido.',

            'start_date.required' => 'La data inizio è obbligatoria.',
            'start_date.date' => 'La data inizio non è valida.',

            'end_date.date' => 'La data fine non è valida.',
            'end_date.after' => 'La data fine deve essere successiva alla data inizio.',

            'client_ids.array' => 'I clienti associati non sono validi.',
            'client_ids.*.exists' => 'Uno dei clienti selezionati non esiste.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->name ? trim($this->name) : null,
            'description' => $this->description ? trim($this->description) : null,
        ]);
    }
}