{{--
    Generic footer — brand + contacts (from meta/admin-core's Contact model if
    available) + social + copyright. Site can override by creating
    `resources/views/components/footer.blade.php`.
--}}
@php
    $brandName    = config('theme.brand.name', 'Site');
    $brandTagline = config('theme.brand.tagline', '');
    $year         = date('Y');

    $hasContacts  = function_exists('contact');
    $phone        = $hasContacts ? contact('main_phone') : null;
    $email        = $hasContacts ? contact('main_email') : null;
    $address      = $hasContacts ? contact('main_address') : null;
@endphp

<footer class="mt-20 border-t"
        style="background: var(--theme-surface-2, #f8f9fb); border-color: var(--theme-border, #e5e7eb);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid gap-8 md:grid-cols-3">

            <div>
                <div class="text-xl font-bold mb-2" style="color: var(--theme-ink, #0f1a2b);">
                    {{ $brandName }}
                </div>
                @if ($brandTagline)
                    <p class="text-sm" style="color: var(--theme-ink-muted, #6b7280);">
                        {{ $brandTagline }}
                    </p>
                @endif
            </div>

            <div>
                <div class="text-sm font-semibold mb-3 uppercase tracking-wide"
                     style="color: var(--theme-ink-muted, #6b7280);">
                    {{ __('theme::footer.contacts') ?: 'Контакты' }}
                </div>
                <ul class="space-y-2 text-sm" style="color: var(--theme-ink, #0f1a2b);">
                    @if ($phone)
                        <li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="hover:underline">{{ $phone }}</a></li>
                    @endif
                    @if ($email)
                        <li><a href="mailto:{{ $email }}" class="hover:underline">{{ $email }}</a></li>
                    @endif
                    @if ($address)
                        <li>{{ $address }}</li>
                    @endif
                </ul>
            </div>

            <div>
                @includeIf('components.footer-extras')
            </div>
        </div>

        <div class="mt-10 pt-6 border-t flex flex-col sm:flex-row justify-between items-center gap-4 text-xs"
             style="border-color: var(--theme-border, #e5e7eb); color: var(--theme-ink-muted, #6b7280);">
            <div>© {{ $year }} {{ $brandName }}. {{ __('theme::footer.all_rights_reserved') ?: 'Все права защищены.' }}</div>
            <div class="flex gap-4">
                @if (Route::has('privacy-policy'))
                    <a href="{{ route('privacy-policy') }}" class="hover:underline">{{ __('theme::footer.privacy') ?: 'Конфиденциальность' }}</a>
                @endif
                @if (Route::has('terms'))
                    <a href="{{ route('terms') }}" class="hover:underline">{{ __('theme::footer.terms') ?: 'Условия' }}</a>
                @endif
            </div>
        </div>
    </div>
</footer>
