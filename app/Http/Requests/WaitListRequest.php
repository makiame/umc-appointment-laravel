<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WaitListRequest extends FormRequest
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
            'dateTimeBegin' => ['required', 'date_format:d.m.Y H:i:s'], // Обязательный параметр, формат "день.месяц.год часы:минуты:секунды"
            'clinicUid'     => ['required', 'string', 'uuid'],          // Обязательный параметр, должен быть строкой и валидным UUID
            'specialtyName' => ['nullable', 'string', 'max:255'],       // Обязательный параметр, строка, не более 255 символов
            'name'          => ['required', 'string', 'max:100'],       // Обязательный параметр, строка, не более 100 символов
            'lastName'      => ['required', 'string', 'max:100'],       // Обязательный параметр, строка, не более 100 символов
            'secondName'    => ['required', 'string', 'max:100'],       // Необязательный параметр, строка, не более 100 символов
            'phone'         => ['required', 'string', 'regex:/^\+7 \(\d{3}\) \d{7}$/'], // Обязательный параметр, строка, формат телефона +7 (XXX) XXXXXXX
            'email'         => ['nullable', 'string', 'email'],         // Обязательный параметр, должен быть валидным email
            'address'       => ['nullable', 'string', 'max:255'],       // Необязательный параметр, строка, не более 255 символов
            'comment'       => ['nullable', 'string', 'max:500'],       // Необязательный параметр, строка, не более 500 символов
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
            'name.required' => 'Параметр name обязателен для заполнения.',
            'name.max' => 'Параметр name не должен превышать 100 символов.',
            'lastName.required' => 'Параметр lastName обязателен для заполнения.',
            'lastName.max' => 'Параметр lastName не должен превышать 100 символов.',
            'secondName.required' => 'Параметр secondName обязателен для заполнения.',
            'secondName.max' => 'Параметр secondName не должен превышать 100 символов.',
            'phone.required' => 'Параметр phone обязателен для заполнения.',
            'phone.regex' => 'Параметр phone должен быть в формате "+7 (XXX) XXXXXXX".',
            'email.email' => 'Параметр email должен быть валидным email адресом.',
            'address.max' => 'Параметр address не должен превышать 255 символов.',
            'comment.max' => 'Параметр comment не должен превышать 500 символов.',
        ];
    }
}
