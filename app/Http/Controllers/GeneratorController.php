<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormGeneratorRequest;
use GeneratorService;
use Illuminate\Contracts\View\View;

/**
 * Контроллер Генератора случайной строки
 */
class GeneratorController extends Controller
{
    /**
     * Страница с формой
     *
     * @return View
     */
    public function index(): View
    {
        return view('welcome');
    }

    /**
     * Возврат результата случайной строки
     *
     * @param FormGeneratorRequest $request
     * @return View
     */
    public function generate(FormGeneratorRequest $request): View
    {
        $validated = $request->validated();

        $generator = GeneratorService::init(
            $validated['character-count'],
            $validated['symbols']
        );

        $password = $generator->generate();

        return view('welcome', [
            'password' => empty($password) ? '-' : $password,
            'info' => $password ? 'Password generated!' : 'No unique combinations left.'
        ]);
    }
}
