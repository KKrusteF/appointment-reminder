<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Validation\Rule;
use App\Enums\AppointmentStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->appointment->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'                   => ['sometimes', 'required', 'string', 'max:255'],
            'description'             => ['nullable', 'string'],
            'start_time'              => ['sometimes', 'required', Rule::date()],
            'reminder_offset_minutes' => ['nullable', 'integer', 'min:1'],
            'recurrence_rule'         => ['nullable', 'string'],
            'client_id'               => ['sometimes', 'required', Rule::exists(Client::class, 'id')],
            'status'                  => ['nullable', new Enum(AppointmentStatus::class)],
        ];
    }
}
