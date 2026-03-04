# Codex OpenCart Module (OpenCart 2.3)

Минимальный модуль для **OpenCart 2.3.x**.

## Возможности

- Включение/выключение модуля.
- Настройка заголовка и текста через админку.
- Вывод блока на витрине через стандартный механизм модулей.

## Совместимость

- OpenCart 2.3.x
- Используются шаблоны `.tpl` и `token` в админ-роутах.

## Структура

- `admin/controller/extension/module/codex_opencart.php`
- `admin/language/english/extension/module/codex_opencart.php`
- `admin/view/template/extension/module/codex_opencart.tpl`
- `catalog/controller/extension/module/codex_opencart.php`
- `catalog/language/english/extension/module/codex_opencart.php`
- `catalog/view/theme/default/template/extension/module/codex_opencart.tpl`

## Установка

1. Скопируйте файлы в корень OpenCart 2.3.
2. В админке перейдите: **Extensions → Extensions → Modules**.
3. Найдите **Codex OpenCart Module**, нажмите **Install**.
4. Нажмите **Edit**, заполните поля и включите модуль.
5. Добавьте модуль в нужный layout (например, Home).
