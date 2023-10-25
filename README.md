## Password generator

Данный код реализует генерацию случайной строки по выбранному набору типов символов и желаемой длине строки.
### Особые ограничения:
- Символы не должны повторяться
- Случайная строка должна быть уникальна для пользователя (легко можно модернизировать для уникальности строки,
но тогда при выборе 1 символа только из цифр будет всего 10 комбинаций и потребуется логика работы в таком случае - 
сейчас выводим сообщение о том, что все комбинации закончились)
- Должен быть хотя бы один символ из выбранных типов символов

### Реализованные не стандартные проверки:
- Количество запрашиваемых символов не может быть меньше выбранного количества типов символов
- Количество запрашиваемых символов не может быть больше суммарного количества символов из всех выбранных типов символов

## Установка и запуск

В данном репозитории добавлена настройка докера, чтобы можно было сразу все запустить и проверить.

### Инструкция
1. Клонировать репозиторий
2. Скопировать **.env.example** в **.env**
3. При необходимости в .env поменять параметры
4. В папке **docker/nginx/sites** скопировать файл **site.conf.example** в, например, **generator.conf**
5. В **hosts** прописать **127.0.0.1 generator.loc**
6. Запустить **docker-compose up -d** (соберет, а потом и запустит контейнеры)
7. Открыть в браузере [generator.loc](http://generator.loc/)
8. После останавливаем контейнеры **docker-compose down**

## Расширяемость

Код написан в ключе расширения наборов символов, т.е. при необходимости можно легко:
- Добавить ограничения на список символов в наборе
- Добавить новый набор символов при этом не придется править blade шаблон
