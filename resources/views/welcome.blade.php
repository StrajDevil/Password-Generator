<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Password Generator</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <link type="text/css" href="/css/tailwind.css" rel="stylesheet"/>
    <link type="text/css" href="/css/main.css" rel="stylesheet"/>
</head>
<body class="antialiased">
<div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <form method="POST" action="/" id="generator" class="flex justify-center">
            @csrf
            <label for="character-count">Type number of symbols</label>
            <input id="character-count"
                   type="number"
                   name="character-count"
                   value="{{ old('character-count', request('character-count', 1)) }}"/>
            @foreach(\App\Services\GeneratorService::TYPES_OF_SYMBOLS as $type => $text)
                <label for="{{ $type }}">
                    <input id="{{ $type }}"
                           type="checkbox"
                           name="symbols[]"
                           value="{{ $type }}"
                           @if(is_array(old('symbols')) &&
                                in_array($type, old('symbols')) ||
                                in_array($type, request()->input('symbols', [])))
                                checked
                           @endif
                    />
                    Enable {{ $text }}
                </label>
            @endforeach
        </form>
        <button type="submit" form="generator">Generate</button>
        <div class="info flex justify-center">
            @isset($password)
                <strong>{{ $password }}</strong>
            @endisset
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @isset($info)
                <div>
                    {{ $info }}
                </div>
            @endisset
        </div>
    </div>
</body>
</html>
