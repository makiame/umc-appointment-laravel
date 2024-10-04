<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetNomenclatureRequest extends FormRequest
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
            'clinicUid' => ['required', 'string', 'uuid'],
        ];
    }

    public function messages(): array
    {
        return [
            'clinicUid.uuid' => 'clinicUid должен быть валидным uuid',
            'clinicUid.required' => 'clinicUid - обязаельный параметр'
        ];
    }
}
