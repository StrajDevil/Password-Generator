<?php

namespace App\Interfaces;

/**
 * Интрефейс для реализаций подключения наборов символов
 */
interface SymbolsInterface
{
    /**
     * Установка набора символов
     */
    public function set(): void;

    /**
     * Получение символа из набора
     *
     * @return int|string
     */
    public function getSymbol(): int|string;

    /**
     * Получение количества символов в наборе
     * @return int
     */
    public function getCount(): int;
}
