<?php

namespace App\Services;

use App\Interfaces\SymbolsInterface;
use Exception;
use Illuminate\Support\Facades\Cache;

/**
 * Сервис генерации случайных строк на основе входных данных
 */
class GeneratorService
{
    /**
     * Список кодов типов наборов символов
     */
    CONST TYPES_OF_SYMBOLS = [
        'numbers' => 'numbers',
        'big-letters' => 'big letters',
        'small-letters' => 'small letters'
    ];

    /**
     * Требуемая длинна сгенерируемой строки
     *
     * @var int
     */
    private int $length;

    /**
     * Набор типов символов из которых будем генерировать строку
     *
     * @var array
     */
    private array $currentTypesOfSymbols;

    /**
     * Хеш пользователя и его сгенерированная строка, чтобы максимально исключить дубликаты
     *
     * @var string
     */
    private string $hash;

    /**
     * Используемые типы символов
     *
     * @var array
     */
    private array $usedOfTypes = [];

    /**
     * Сгенерированная строка
     *
     * @var string
     */
    private string $randomString = '';

    /**
     * Получение и установка хеша для пользователя
     */
    private function setHash()
    {
        $this->hash = md5(request()->userAgent() . request()->ip());
    }

    /**
     * Выбор из какого типа символов будем выбирать символ
     *
     * @throws Exception
     */
    private function choiceOfType(): SymbolsInterface
    {
        if (strlen($this->randomString) < count($this->currentTypesOfSymbols)) {
            $type = $this->currentTypesOfSymbols[strlen($this->randomString)];
        } else {
            $type = $this->currentTypesOfSymbols[random_int(0, count($this->currentTypesOfSymbols) - 1)];
        }

        if (!isset($this->usedOfTypes[$type])) {
            $this->usedOfTypes[$type] = $this->getType($type);
        }

        return $this->usedOfTypes[$type];
    }

    /**
     * Получение количества вариаций из выбранных типов и количества символов заданного пользователем
     * @return int
     */
    private function getVariations(): int
    {
        $countSymbols = 0;
        foreach ($this->currentTypesOfSymbols as $type) {
            $symbol = $this->getType($type);
            $countSymbols += $symbol->getCount();
        }

        return gmp_intval(
            gmp_fact($countSymbols) /
            (
                gmp_fact($countSymbols - $this->length) * gmp_fact($this->length)
            )
        );
    }

    /**
     * Генерируем и записываем случайную строку
     *
     * @throws Exception
     */
    private function setRandomString()
    {
        for ($i = 0; $i < $this->length; $i++) {
            $symbols = $this->choiceOfType();
            $this->randomString .= $symbols->getSymbol();
        }
        $this->randomString = str_shuffle($this->randomString);
    }

    /**
     * Сброс используемых типов символов и полученной строки
     */
    private function reset()
    {
        $this->usedOfTypes = [];
        $this->randomString = '';
    }

    /**
     * Инициализация входных данных для сервиса
     *
     * @param int $length Желаемая длина строки
     * @param array $typesOfSymbols Выбранные типы символов
     * @return $this
     */
    public function init(int $length, array $typesOfSymbols): GeneratorService
    {
        $this->length = $length;
        $this->currentTypesOfSymbols = $typesOfSymbols;
        $this->setHash();

        return $this;
    }

    /**
     * Получение набора символов по коду типа
     *
     * @param string $type Код типа символов
     * @return SymbolsInterface
     */
    public function getType(string $type): SymbolsInterface
    {
        return match ($type) {
            'numbers' => new Numbers(),
            'big-letters' => new BigLetters(),
            'small-letters' => new SmallLetters(),
        };
    }

    /**
     * Метод для генерации случайной строки с учетом разных ограничений
     *
     * @throws Exception
     */
    public function generate(): string
    {
        $variations = $this->getVariations();
        while ($variations > 0) {
            $this->setRandomString();
            if ($this->checkUnique()) {
                $this->save();
                break;
            }
            $this->reset();
            $variations--;
        }

        return $this->randomString;
    }

    /**
     * Проверка уникальности случайной строки для пользователя
     *
     * @return bool
     */
    public function checkUnique(): bool
    {
        return !Cache::has($this->hash . $this->randomString);
    }

    /**
     * Сохранение уникальной сгенерированной строки для пользователя
     */
    public function save()
    {
        Cache::put($this->hash . $this->randomString, $this->randomString, now()->addWeek());
    }
}
