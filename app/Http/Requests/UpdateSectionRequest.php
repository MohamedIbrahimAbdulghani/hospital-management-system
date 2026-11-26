<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
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
            'id' => 'required|exists:sections,id',
            'name' => 'required|string|max:255|unique:section_translations,name,' . $this->id . ',section_id',
        ];
    }

    /**
     * Custom validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => trans('sections.name_required'),
            'name.unique' => trans('sections.name_unique'),
            'id.required' => trans('sections.id_required'),
            'id.exists' => trans('sections.id_exists'),
        ];
    }
}
