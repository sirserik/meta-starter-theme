<?php

namespace Meta\StarterTheme;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider for meta/starter-theme.
 *
 * Registers:
 *  - `theme` config (mergeConfigFrom; publishable)
 *  - Blade views as a *low-priority* path so any consumer template
 *    in `resources/views/` wins automatically (no `vendor:publish` needed).
 *  - Anonymous component namespace `<x-theme::header />` etc.
 *  - `@theme('key.path', 'default')` Blade directive for design-token /
 *    config lookup inside templates.
 *  - Tailwind preset + tokens.css publishable to the consumer's
 *    `resources/css/`.
 *  - JS bundle (apply-form, lightbox glue) publishable to `resources/js/`.
 */
class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/theme.php', 'theme');
    }

    public function boot(): void
    {
        // Views as low-priority. Local `resources/views/layouts/public.blade.php`
        // overrides theme's by sheer virtue of being earlier in the finder
        // path stack — Laravel default behaviour, no extra wiring needed.
        $this->callAfterResolving('view', function ($view) {
            $view->addLocation(__DIR__ . '/../resources/views');
        });

        // Namespaced views — explicit `theme::layouts.public` form for
        // child themes / packages that want to extend the starter
        // without colliding with the local resources/views/ layer.
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'theme');

        // Anonymous component namespace: <x-theme::header />,
        // <x-theme::modals.apply-form />, etc.
        Blade::anonymousComponentNamespace(
            __DIR__ . '/../resources/views/components',
            'theme'
        );

        // @theme('brand.name', 'Fallback') — short-hand for
        // {{ config('theme.brand.name', 'Fallback') }}, used heavily
        // in shipped templates.
        Blade::directive('theme', function ($expression) {
            return "<?php echo e(config('theme.' . " . $expression . ")); ?>";
        });

        // Publishables.
        $this->publishes([
            __DIR__ . '/../config/theme.php' => config_path('theme.php'),
        ], 'starter-theme-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/theme'),
        ], 'starter-theme-views');

        $this->publishes([
            __DIR__ . '/../resources/css' => resource_path('css/theme'),
        ], 'starter-theme-css');

        $this->publishes([
            __DIR__ . '/../resources/js'  => resource_path('js/theme'),
        ], 'starter-theme-js');

        // Tokens injected into <head> via Blade composer so templates
        // can read `--theme-primary` etc. without the site touching
        // a single line of CSS.
        View::composer('layouts.public', function ($view) {
            $view->with('themeTokens', $this->buildTokensCss());
        });
    }

    /**
     * Compose the `:root { --theme-…: … }` rule from config('theme.tokens').
     * Keeps brand-config out of CSS files so the only artefact to ship
     * per site is `config/theme.php`.
     */
    protected function buildTokensCss(): string
    {
        $tokens = (array) config('theme.tokens', []);
        if (empty($tokens)) {
            return '';
        }

        $lines = [':root {'];
        foreach ($tokens as $key => $value) {
            $lines[] = sprintf('  --theme-%s: %s;', $key, $value);
        }
        $lines[] = '}';

        return implode("\n", $lines);
    }
}
