# Nova Poshta shipping module for OpenCart 2.3

Модуль для **OpenCart 2.3.x**, який:

1. додає метод доставки **Nova Poshta** у checkout;
2. дає змогу відслідковувати ТТН через CRM Open API (`/open-api`).

## Що входить

### 1) Метод доставки (Shipping Extension)

- Адмін-налаштування: API URL, API token, базова вартість доставки, Geo Zone, статус, сортування.
- Вітрина: метод доставки `Nova Poshta` у блоці вибору доставки.

### 2) Відслідковування ТТН (Front Module)

- Форма для введення номера накладної (ТТН).
- POST-запит до API: `POST {api_url}/nova-poshta/track`.
- Вивід статусу, міста відправника/одержувача, одержувача, часу оновлення.

## Файли

- `admin/controller/extension/shipping/codex_novaposhta.php`
- `admin/language/english/extension/shipping/codex_novaposhta.php`
- `admin/view/template/extension/shipping/codex_novaposhta.tpl`
- `catalog/model/extension/shipping/codex_novaposhta.php`
- `catalog/language/english/extension/shipping/codex_novaposhta.php`
- `catalog/controller/extension/module/codex_novaposhta_tracking.php`
- `catalog/language/english/extension/module/codex_novaposhta_tracking.php`
- `catalog/view/theme/default/template/extension/module/codex_novaposhta_tracking.tpl`

## Встановлення

1. Скопіюйте файли у корінь OpenCart 2.3.
2. Адмінка → **Extensions → Shipping** → встановіть **Nova Poshta (CRM API)**.
3. Натисніть **Edit**, заповніть:
   - API base URL: `https://crm.sitniks.com/open-api`
   - API key/token (якщо потрібен)
   - default cost та інші параметри
4. Увімкніть метод доставки.
5. Додайте модуль трекінгу на потрібну сторінку через **Extensions → Modules** (або вставте route вручну у ваш шаблон/контролер).

## Примітка по API

Оскільки схема API може змінюватись, контролер трекінгу робить м'який парсинг відповіді і підтримує ключі `data.status` або `data.current_status`.
