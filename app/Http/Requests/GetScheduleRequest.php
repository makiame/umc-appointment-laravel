<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetScheduleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        return [
            'startDate' => ['nullable', 'date_format:d.m.Y'],
            'daysCount' => ['nullable', 'integer', 'min:1'],
            'clinicUid' => ['nullable', 'uuid'],
            'employeeUids' => ['nullable', 'array'],
            'employeeUids.*' => ['string', 'uuid'],
        ];
    }

    public function messages(): array
    {
        return [
            'startDate.date_format' => 'Параметр startDate должен быть в формате "день.месяц.год".',
            'daysCount.integer' => 'Параметр daysCount должен быть целым числом.',
            'daysCount.min' => 'Минимальное значение для daysCount - 1.',
            'clinicUid.uuid' => 'Параметр clinicUid должен быть валидным UUID.',
            'employeeUids.array' => 'Параметр employeeUids должен быть массивом.',
            'employeeUids.*.uuid' => 'Каждый элемент в employeeUids должен быть валидным UUID.',
        ];
    }
}
