<?php

namespace App\Services;

use App\Interfaces\SymbolsInterface;
use Exception;

/**
 * Блок с цифрами
 */
class Numbers implements SymbolsInterface
{
    /**
     * Базовый набор символов
     *
     * @var array
     */
    private array $symbols;

    /**
     * Текущий набор символов на основе базового
     *
     * @var array
     */
    private array $currentSymbols;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->set();
        $this->currentSymbols = $this->symbols;
    }

    /**
     * @inheritDoc
     */
    public function set(): void
    {
        $this->symbols = range(0, 9);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getSymbol(): string
    {
        $symbol = '';
        $count = count($this->currentSymbols);
        if ($count !== 0) {
            $index = random_int(0, $count - 1);
            $symbol = $this->currentSymbols[$index];
            array_splice($this->currentSymbols, $index, 1);
        }

        return $symbol;
    }

    /**
     * @inheritDoc
     */
    public function getCount(): int
    {
        return count($this->symbols);
    }
}
