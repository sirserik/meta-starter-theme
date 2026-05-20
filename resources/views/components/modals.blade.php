{{--
    Generic modals scaffold — apply + info forms.

    Open with: `$dispatch('open-modal', { modal: 'apply' })`.

    Both forms POST to consumer-defined routes:
        - route('apply.submit')  for application
        - route('info.submit')   for info request

    If those routes don't exist on the site, the form silently shows
    a generic mailto: fallback so the modal still works.

    For richer / branded modals: override at
    `resources/views/components/modals.blade.php` in your site.
--}}
@php
    $fallbackEmail = function_exists('contact')
        ? (contact('main_email') ?? 'info@example.com')
        : 'info@example.com';
    $applyUrl = Route::has('apply.submit') ? route('apply.submit') : 'mailto:' . $fallbackEmail;
    $infoUrl  = Route::has('info.submit')  ? route('info.submit')  : 'mailto:' . $fallbackEmail;
@endphp

<div x-data="{
        open: false,
        which: null,
        openModal(name) { this.which = name; this.open = true; document.body.style.overflow = 'hidden'; },
        close() { this.open = false; this.which = null; document.body.style.overflow = ''; }
    }"
     @open-modal.window="openModal($event.detail.modal)"
     @keydown.escape.window="if (open) close()"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-[9000] flex items-center justify-center p-4"
     style="display: none;">

    <div class="absolute inset-0 bg-black/60" @click="close()"></div>

    {{-- Apply form --}}
    <div x-show="which === 'apply'"
         x-transition
         class="relative rounded-2xl shadow-2xl max-w-md w-full p-6"
         style="background: var(--theme-surface, #fff);">
        <button type="button" class="absolute top-3 right-3 text-lg" @click="close()" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
        <h2 class="text-2xl font-bold mb-4" style="color: var(--theme-ink, #0f1a2b);">
            {{ __('theme::modals.apply.title') ?: 'Подать заявку' }}
        </h2>
        <form action="{{ $applyUrl }}" method="POST" class="space-y-3">
            @csrf
            <input type="hidden" name="website_url" value=""> {{-- honeypot --}}
            <input type="text"  name="name"  required placeholder="{{ __('theme::modals.apply.name')  ?: 'Имя' }}"  class="w-full px-3 py-2 rounded-lg border">
            <input type="tel"   name="phone" required placeholder="{{ __('theme::modals.apply.phone') ?: 'Телефон' }}" class="w-full px-3 py-2 rounded-lg border">
            <input type="email" name="email"          placeholder="{{ __('theme::modals.apply.email') ?: 'Email' }}"   class="w-full px-3 py-2 rounded-lg border">
            <button type="submit" class="w-full py-3 rounded-lg font-semibold"
                    style="background: var(--theme-primary); color: var(--theme-on-primary);">
                {{ __('theme::modals.apply.submit') ?: 'Отправить' }}
            </button>
        </form>
    </div>

    {{-- Info request form --}}
    <div x-show="which === 'info'"
         x-transition
         class="relative rounded-2xl shadow-2xl max-w-md w-full p-6"
         style="background: var(--theme-surface, #fff);">
        <button type="button" class="absolute top-3 right-3 text-lg" @click="close()" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
        <h2 class="text-2xl font-bold mb-4" style="color: var(--theme-ink, #0f1a2b);">
            {{ __('theme::modals.info.title') ?: 'Получить консультацию' }}
        </h2>
        <form action="{{ $infoUrl }}" method="POST" class="space-y-3">
            @csrf
            <input type="hidden" name="website_url" value="">
            <input type="text"  name="name"  required placeholder="{{ __('theme::modals.info.name')  ?: 'Имя' }}"  class="w-full px-3 py-2 rounded-lg border">
            <input type="tel"   name="phone" required placeholder="{{ __('theme::modals.info.phone') ?: 'Телефон' }}" class="w-full px-3 py-2 rounded-lg border">
            <textarea name="message" rows="4" placeholder="{{ __('theme::modals.info.message') ?: 'Сообщение' }}" class="w-full px-3 py-2 rounded-lg border"></textarea>
            <button type="submit" class="w-full py-3 rounded-lg font-semibold"
                    style="background: var(--theme-primary); color: var(--theme-on-primary);">
                {{ __('theme::modals.info.submit') ?: 'Отправить' }}
            </button>
        </form>
    </div>
</div>
