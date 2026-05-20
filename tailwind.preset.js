/**
 * Starter theme — Tailwind v3+ preset.
 *
 * Maps CSS-variable tokens (set by ThemeServiceProvider from
 * config/theme.php) to Tailwind utility class names. The colours/radii
 * here are AI of the CSS variables — Tailwind generates classes like
 * `bg-primary`, `text-on-primary`, `rounded-md`, but the *actual value*
 * comes from the variable at render time. No recompile when tokens
 * change in config.
 *
 * Consumer site usage:
 *
 *   // tailwind.config.js
 *   import preset from '../../meta-starter-theme/tailwind.preset.js';
 *   export default {
 *     presets: [preset],
 *     content: ['./resources/**\/*.blade.php', './resources/**\/*.js'],
 *     // your site-specific overrides here
 *   };
 */
export default {
    theme: {
        extend: {
            colors: {
                primary:        'var(--theme-primary)',
                'primary-hover':'var(--theme-primary-hover)',
                'on-primary':   'var(--theme-on-primary)',
                accent:         'var(--theme-accent)',
                surface:        'var(--theme-surface)',
                'surface-2':    'var(--theme-surface-2)',
                ink:            'var(--theme-ink)',
                'ink-muted':    'var(--theme-ink-muted)',
                border:         'var(--theme-border)',
                success:        'var(--theme-success)',
                warning:        'var(--theme-warning)',
                danger:         'var(--theme-danger)',
            },
            fontFamily: {
                sans:    ['var(--theme-font-sans)'],
                display: ['var(--theme-font-display)'],
            },
            borderRadius: {
                DEFAULT: 'var(--theme-radius-md)',
                sm:      'var(--theme-radius-sm)',
                md:      'var(--theme-radius-md)',
                lg:      'var(--theme-radius-lg)',
            },
            boxShadow: {
                sm: 'var(--theme-shadow-sm)',
                md: 'var(--theme-shadow-md)',
                lg: 'var(--theme-shadow-lg)',
            },
        },
    },
};
