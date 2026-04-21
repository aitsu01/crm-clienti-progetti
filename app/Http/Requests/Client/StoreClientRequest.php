<?php

namespace App\Http\Requests\Client;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['privato', 'azienda'])],

            'vat_number' => [
                'nullable',
                'string',
                'regex:/^[0-9]{11}$/',
                Rule::requiredIf(fn () => $this->input('type') === 'azienda'),
            ],

            'tax_code' => [
                'nullable',
                'string',
                'size:16',
                'regex:/^[A-Z0-9]{16}$/i',
                Rule::requiredIf(fn () => $this->input('type') === 'privato'),
            ],

            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],

            'project_ids' => ['nullable', 'array'],
            'project_ids.*' => ['integer', 'exists:projects,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Il nome è obbligatorio.',
            'last_name.required' => 'Il cognome è obbligatorio.',
            'type.required' => 'Il tipo cliente è obbligatorio.',
            'type.in' => 'Il tipo cliente selezionato non è valido.',

            'vat_number.required' => 'La partita IVA è obbligatoria per un cliente azienda.',
            'vat_number.regex' => 'La partita IVA deve contenere esattamente 11 cifre.',

            'tax_code.required' => 'Il codice fiscale è obbligatorio per un cliente privato.',
            'tax_code.size' => 'Il codice fiscale deve essere lungo 16 caratteri.',
            'tax_code.regex' => 'Il codice fiscale non ha un formato valido.',

            'email.email' => 'Inserisci un indirizzo email valido.',
            'project_ids.*.exists' => 'Uno dei progetti selezionati non esiste.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name' => $this->first_name ? trim($this->first_name) : null,
            'last_name' => $this->last_name ? trim($this->last_name) : null,
            'vat_number' => $this->vat_number ? preg_replace('/\s+/', '', $this->vat_number) : null,
            'tax_code' => $this->tax_code ? strtoupper(trim($this->tax_code)) : null,
            'address' => $this->address ? trim($this->address) : null,
            'email' => $this->email ? trim($this->email) : null,
        ]);
    }
}