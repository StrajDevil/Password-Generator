<?php

namespace App\Rules;

use Closure;
use GeneratorService;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Правило проверки на максимальное число символов для случайной строки
 */
class MaxNumber implements ValidationRule
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
        $countSymbols = 0;
        foreach ($this->symbols as $type) {
            $symbol = GeneratorService::getType($type);
            $countSymbols += $symbol->getCount();
        }
        if ($value > $countSymbols && $countSymbols > 0) {
            $fail("The :attribute field must not be greater than $countSymbols.");
        }
    }
}
