<?php

/**
 * Starter theme configuration.
 *
 * Consumer apps publish this with:
 *   php artisan vendor:publish --tag=starter-theme-config
 *
 * Overrides:
 *   - brand: site identity surfaced in <title>, OG, default favicon
 *   - tokens: CSS-variable values written to <style> in <head>
 *   - menu: which standard menu items render in the header/footer
 *   - features: toggle whole UI sections off (apply-form, ai-chat, etc.)
 */
return [

    'brand' => [
        'name'        => env('THEME_BRAND_NAME', config('app.name', 'Starter')),
        'tagline'     => env('THEME_BRAND_TAGLINE', ''),
        'logo'        => env('THEME_BRAND_LOGO', '/storage/logo.svg'),
        'logo_dark'   => env('THEME_BRAND_LOGO_DARK', '/storage/logo-dark.svg'),
        'favicon'     => env('THEME_BRAND_FAVICON', '/storage/favicon.ico'),
        'og_image'    => env('THEME_BRAND_OG_IMAGE', '/storage/og-default.jpg'),
    ],

    /**
     * Design tokens — written as CSS custom properties into the
     * theme's <head>. Every value here becomes `--theme-{key}: value;`.
     *
     * Tailwind preset (tailwind.preset.js) maps these to utility names
     * so `bg-primary` / `text-on-primary` always resolve to the
     * currently-configured value with no recompile needed.
     */
    'tokens' => [
        // Colour palette
        'primary'         => '#C41E3A',
        'primary-hover'   => '#A01830',
        'on-primary'      => '#FFFFFF',
        'accent'          => '#F5B400',
        'surface'         => '#FFFFFF',
        'surface-2'       => '#F8F9FB',
        'ink'             => '#0F1A2B',
        'ink-muted'       => '#6B7280',
        'border'          => '#E5E7EB',
        'success'         => '#16A34A',
        'warning'         => '#F59E0B',
        'danger'          => '#DC2626',

        // Typography
        'font-sans'       => '"Inter", system-ui, sans-serif',
        'font-display'    => '"Inter", system-ui, sans-serif',

        // Radius & shadow
        'radius-sm'       => '0.375rem',
        'radius-md'       => '0.75rem',
        'radius-lg'       => '1.5rem',
        'shadow-sm'       => '0 1px 2px rgba(15, 26, 43, 0.06)',
        'shadow-md'       => '0 4px 16px rgba(15, 26, 43, 0.08)',
        'shadow-lg'       => '0 20px 40px rgba(15, 26, 43, 0.12)',
    ],

    /**
     * Standard public pages the theme provides routes/views for.
     * Set to false to silence; the site can still register its own.
     */
    'pages' => [
        'home'           => true,
        'search'         => true,
        'sitemap'        => true,
        'errors'         => true,   // 403/404/419/429/500/503
    ],

    /**
     * Optional UI features wired into the theme's components.
     * Each may be disabled site-wide here, or programmatically.
     */
    'features' => [
        'apply_form'     => true,
        'info_form'      => true,
        'language_switcher' => true,
        'search_widget'  => true,
    ],

    /**
     * Where the theme expects to find user-supplied menu data.
     * Defaults match meta/admin-core's MenuItem model.
     */
    'menu' => [
        'header_slug'    => 'main',
        'footer_slug'    => 'footer',
    ],
];
