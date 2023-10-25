<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * Фасад сервиса генерации случайной строки
 */
class GeneratorServiceFacade extends Facade {
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'GeneratorService';
    }
}
