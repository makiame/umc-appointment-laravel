<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'refUid'               => ['required', 'string', 'uuid'],
            'name'                 => ['required', 'string', 'max:100'],
            'lastName'             => ['required', 'string', 'max:100'],
            'secondName'           => ['required', 'string', 'max:100'],
            'timeBegin'            => ['required', 'date_format:Y-m-d\TH:i:s'],
            'phone'                => ['required', 'string', 'max:20'],
            'email'                => ['nullable', 'string', 'email'],
            'address'              => ['nullable', 'string', 'max:255'],
            'clinicUid'            => ['required', 'string', 'uuid'],
            'comment'              => ['nullable', 'string', 'max:500'],
            'services'             => ['nullable', 'array'],
            'clientBirthday'       => ['nullable', 'date_format:d.m.Y'],
            'appointmentDuration'  => ['nullable', 'integer', 'min:0'],
            'orderUid'             => ['nullable', 'string', 'uuid'],
            'code'                 => ['nullable', 'string', 'max:6'],
            'DoctorCode'           => ['nullable', 'string', 'max:6']
        ];
    }

    /**
     * Сообщения об ошибках валидации.
     */
    public function messages(): array
    {
        return [
            'employeeUid.required' => 'Параметр employeeUid обязателен для заполнения.',
            'employeeUid.uuid' => 'Параметр employeeUid должен быть валидным UUID.',
            'name.required' => 'Имя клиента обязательно для заполнения.',
            'name.max' => 'Имя не должно превышать 100 символов.',
            'lastName.required' => 'Фамилия клиента обязательна для заполнения.',
            'lastName.max' => 'Фамилия не должна превышать 100 символов.',
            'secondName.max' => 'Отчество не должно превышать 100 символов.',
            'timeBegin.required' => 'Параметр dateTimeBegin обязателен для заполнения.',
            'timeBegin.date_format' => 'Параметр dateTimeBegin должен быть в формате "день.месяц.год часы:минуты:секунды".',
            'phone.required' => 'Параметр phone обязателен для заполнения.',
            'email.email' => 'Параметр email должен быть валидным email адресом.',
            'address.max' => 'Адрес не должен превышать 255 символов.',
            'clinicUid.required' => 'Параметр clinicUid обязателен для заполнения.',
            'clinicUid.uuid' => 'Параметр clinicUid должен быть валидным UUID.',
            'comment.max' => 'Комментарий не должен превышать 500 символов.',
            'services.required' => 'Параметр services обязателен для заполнения.',
            'services.array' => 'Параметр services должен быть массивом.',
            'clientBirthday.date_format' => 'Параметр clientBirthday должен быть в формате "день.месяц.год".',
            'appointmentDuration.integer' => 'Параметр appointmentDuration должен быть числом.',
            'appointmentDuration.min' => 'Параметр appointmentDuration должен быть больше или равен 0.',
            'orderUid.uuid' => 'Параметр orderUid должен быть валидным UUID.',
            'code.max' => 'Параметр code должен быть не больше 6 символов',
            'DoctorCode.max' => 'Параметр code должен быть не больше 6 символов',

        ];
    }
}
