<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReserveRequest extends FormRequest
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
            'dateTimeBegin' => ['required', 'date_format:d.m.Y H:i:s'],
            'clinicUid'     => ['required', 'string', 'uuid'],
            'specialtyName' => ['nullable', 'string', 'max:255'],
            'employeeUid'   => ['required', 'string', 'uuid'],
        ];
    }

    /**
     * Сообщения об ошибках валидации.
     */
    public function messages(): array
    {
        return [
            'dateTimeBegin.required' => 'Параметр dateTimeBegin обязателен для заполнения.',
            'dateTimeBegin.date_format' => 'Параметр dateTimeBegin должен быть в формате "день.месяц.год часы:минуты:секунды".',
            'clinicUid.required' => 'Параметр clinicUid обязателен для заполнения.',
            'clinicUid.uuid' => 'Параметр clinicUid должен быть валидным UUID.',
            'specialtyName.max' => 'Параметр specialtyName не должен превышать 255 символов.',
            'employeeUid.required' => 'Параметр employeeUid обязателен для заполнения.',
            'employeeUid.uuid' => 'Параметр employeeUid должен быть валидным UUID.',
        ];
    }
}
