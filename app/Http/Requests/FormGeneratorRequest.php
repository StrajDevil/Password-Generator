<?php

namespace App\Http\Requests;

use App\Rules\MaxNumber;
use App\Rules\MinNumber;
use App\Services\GeneratorService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Правила проверки формы для генерации случайной строки
 */
class FormGeneratorRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'character-count' => [
                'required',
                'not_in:0',
                'numeric',
                new MinNumber($this->input('symbols')),
                new MaxNumber($this->input('symbols'))
            ],
            'symbols' => [
                'required',
                'min:1'
            ],
            'symbols.*' => [
                Rule::in(array_keys(GeneratorService::TYPES_OF_SYMBOLS))
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'character-count' => '"Type number of symbols"',
            'symbols' => '"Types of symbols"',
            'symbols.*' => '"Types of symbols"',
        ];
    }
}
