<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'                   => ['required', 'string', 'max:255'],
            'description'             => ['nullable', 'string', 'max:1000'],
            'start_time'              => ['required', Rule::date()->afterOrEqual(now())],
            'reminder_offset_minutes' => ['nullable', 'integer', 'min:1'],
            'recurrence_rule'         => ['nullable', 'string'],
            'client_id'               => ['required', Rule::exists(Client::class, 'id')],
        ];
    }
}
