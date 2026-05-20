# meta/starter-theme

«Twenty Twenty-Four» для сайтов на `meta/admin-core`.
Composer-пакет: layouts, header/footer/modals, error pages, design tokens, Tailwind preset.

## Установка

```bash
composer require meta/starter-theme
```

ServiceProvider auto-discovered. Никаких ручных регистраций.

## Что даёт

- `layouts/public.blade.php` — публичный shell сайта с SEO/OG/Twitter/canonical/hreflang/JSON-LD slots, accessibility-prefs, дизайн-токенами в `<head>`.
- `errors/{403,404,419,429,500,503}.blade.php` — единый стиль через `errors/__layout.blade.php`, трилингвальные строки прямо в файлах.
- `components/header.blade.php` — sticky-header с brand-логотипом, главным меню из admin-core `MenuItem`, языкопереключателем и apply-CTA.
- `components/footer.blade.php` — brand + контакты (из admin-core `Contact`) + privacy/terms ссылки.
- `components/modals.blade.php` — apply + info формы с honeypot.
- `components/page-blocks.blade.php` — generic-dispatcher блоков через `Meta\AdminCore\Blocks\BlockRegistry`.
- `resources/css/tokens.css` — fallback CSS-переменные.
- `tailwind.preset.js` — utility-классы привязаны к CSS-токенам (zero-recompile при смене темы).

## Локальный override

Любой view темы переопределяется бесплатно — Laravel view finder берёт сначала локальный, потом package fallback. Положи свой:
```
resources/views/components/header.blade.php
resources/views/errors/404.blade.php
resources/views/blocks/v2/hero.blade.php
```
— и Laravel автоматически выберет его. `vendor:publish` нужен только если хочется иметь стартовую копию для редактирования.

## Конфигурация

```bash
php artisan vendor:publish --tag=starter-theme-config
```

Создаёт `config/theme.php`:

```php
return [
    'brand' => [
        'name'      => env('THEME_BRAND_NAME', 'Мой сайт'),
        'tagline'   => env('THEME_BRAND_TAGLINE', ''),
        'logo'      => env('THEME_BRAND_LOGO', '/storage/logo.svg'),
        'favicon'   => env('THEME_BRAND_FAVICON', '/favicon.ico'),
        'og_image'  => env('THEME_BRAND_OG_IMAGE', '/storage/og-default.jpg'),
    ],
    'tokens' => [
        'primary'    => '#C41E3A',
        'on-primary' => '#FFFFFF',
        // ...
    ],
    'pages' => [
        'home' => true, 'search' => true, 'sitemap' => true, 'errors' => true,
    ],
    'features' => [
        'apply_form' => true, 'info_form' => true,
        'language_switcher' => true, 'search_widget' => true,
    ],
];
```

Все `tokens.*` автоматически инжектятся в `<head>` как `:root { --theme-<key>: <value> }`. Tailwind preset (`tailwind.preset.js`) маппит их на utility-классы (`bg-primary`, `text-on-primary`, `rounded-md`).

## Tailwind preset

```js
// tailwind.config.js
import preset from '../../meta-starter-theme/tailwind.preset.js';
export default {
    presets: [preset],
    content: ['./resources/**/*.blade.php', './resources/**/*.js'],
};
```

## Тематизация в `<head>`

Theme-токены пишутся `ThemeServiceProvider::buildTokensCss()` в момент рендера `layouts/public.blade.php` — `$themeTokens` шарится через `View::composer`. Это значит:

- Смена `config('theme.tokens.primary')` → следующий рендер уже другой цвет.
- Никаких npm/vite пересборок при ребрендинге.
- CSS-переменные используются и в Blade (`style="background: var(--theme-primary)"`), и в Tailwind preset.

## Зависимости

- PHP `^8.2`
- Laravel `^11|^12`
- `meta/admin-core` `^1.0` — для `BlockRegistry`, `MenuItem`, `Contact`.

## Версионирование

Pre-1.0 (`0.1.x`), API ещё может ломаться. Релиз 1.0 — после двух consumer-сайтов на одном пакете.

## License

Proprietary.
