<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in([
                'da_fare',
                'in_corso',
                'in_revisione',
                'completata',
                'bloccata',
            ])],
            'priority' => ['required', Rule::in(['bassa', 'media', 'alta'])],
            'due_date' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'Il progetto è obbligatorio.',
            'project_id.exists' => 'Il progetto selezionato non esiste.',

            'title.required' => 'Il titolo della task è obbligatorio.',
            'title.min' => 'Il titolo della task deve contenere almeno 2 caratteri.',

            'status.required' => 'Lo stato è obbligatorio.',
            'status.in' => 'Lo stato selezionato non è valido.',

            'priority.required' => 'La priorità è obbligatoria.',
            'priority.in' => 'La priorità selezionata non è valida.',

            'due_date.date' => 'La data di scadenza non è valida.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => $this->title ? trim($this->title) : null,
            'description' => $this->description ? trim($this->description) : null,
        ]);
    }
}