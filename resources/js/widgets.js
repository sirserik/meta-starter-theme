/**
 * Starter theme — public-page JS glue.
 *
 * The theme intentionally ships almost nothing here — Alpine.js (loaded
 * by the consumer site's bundle) handles the interactivity declared in
 * the Blade components themselves via `x-data` / `$dispatch`.
 *
 * What lives here:
 *  - small helpers that aren't worth inlining in Blade
 *  - convention API site-side JS can consume
 *
 * Site usage: `import 'theme/widgets.js';` from resources/js/app.js
 */

/* Open a modal by name from non-Alpine code:
 *   import { openModal } from 'theme/widgets.js';
 *   openModal('apply');
 */
export function openModal(name) {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: { modal: name } }));
}

/* Soft-reload locale by appending ?lang=XX without nuking other query params.
 * Sites can re-export from their own helpers if they prefer hash routing or
 * server-side redirect.
 */
export function switchLocale(locale) {
    const url = new URL(window.location.href);
    url.searchParams.set('lang', locale);
    window.location.href = url.toString();
}
