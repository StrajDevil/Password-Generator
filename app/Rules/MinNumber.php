<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Правило проверки на максимальное число символов для случайной строки
 */
class MinNumber implements ValidationRule
{
    /**
     * Выбранные блоки символов
     *
     * @var array
     */
    private array $symbols;

    /**
     * Конструктор
     *
     * @param array|null $symbols
     */
    public function __construct(?array $symbols) {
        $this->symbols = $symbols ?? [];
    }
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $countSymbols = count($this->symbols);
        if ($value < $countSymbols) {
            $fail("The :attribute field must be at least $countSymbols.");
        }
    }
}
