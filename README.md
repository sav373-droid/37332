# Nova Poshta module for OpenCart 2.3 (independent)

Це **незалежний модуль тільки для OpenCart 2.3.x**, без прив’язки до CRM.
Для роботи використовується **офіційний API Нової пошти**: `https://api.novaposhta.ua/v2.0/json/`.

## Що реалізовано

1. **Метод доставки Nova Poshta** у checkout.
2. **Кабінет Нової пошти в адмінці**:
   - налаштування API key, Geo Zone, вартості, статусу, сортування;
   - API Console для виклику **будь-якого** методу API (`modelName`, `calledMethod`, `methodProperties`);
   - Action Log, де фіксуються всі API-виклики (запит/відповідь/помилка).
3. **Фронтенд-відстеження ТТН** через `TrackingDocument/getStatusDocuments`.

## Файли Nova Poshta

- `admin/controller/extension/shipping/codex_novaposhta.php`
- `admin/model/extension/shipping/codex_novaposhta.php`
- `admin/language/english/extension/shipping/codex_novaposhta.php`
- `admin/view/template/extension/shipping/codex_novaposhta.tpl`
- `catalog/model/extension/shipping/codex_novaposhta.php`
- `catalog/language/english/extension/shipping/codex_novaposhta.php`
- `catalog/controller/extension/module/codex_novaposhta_tracking.php`
- `catalog/language/english/extension/module/codex_novaposhta_tracking.php`
- `catalog/view/theme/default/template/extension/module/codex_novaposhta_tracking.tpl`

## Встановлення

1. Скопіюйте файли у корінь OpenCart 2.3.
2. Адмінка → **Extensions → Shipping** → встановіть **Nova Poshta Cabinet**.
3. Увійдіть в налаштування і вкажіть **Nova Poshta API key**.
4. За потреби налаштуйте Geo Zone, вартість, статус, сортування.
5. Для перевірки/інтеграції додаткових сценаріїв відкрийте вкладку **API console** і викликайте потрібні методи API.
6. Для перегляду історії дій відкрийте вкладку **Action log**.

## Примітка

При встановленні створюється таблиця логів:
`oc_codex_novaposhta_action` (з префіксом вашої БД).
