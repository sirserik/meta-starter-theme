{{--
    Generic header — brand logo + main menu + (optional) language switcher + apply CTA.

    Renders meta/admin-core MenuItem tree if available. Site can override by
    creating `resources/views/components/header.blade.php` — Laravel view
    finder picks the local copy first.

    Expected (optional) variables:
      $menuItemsAll  — Collection<MenuItem> keyed by slug, with translations eager-loaded
                       (HeaderComposer-style; sites that wire one get richer UX,
                       but the partial degrades gracefully if missing).
--}}
@php
    $locale     = app()->getLocale();
    $brandName  = config('theme.brand.name', 'Site');
    $brandLogo  = config('theme.brand.logo');
    $features   = config('theme.features', []);
    $menuRoot   = $menuItemsAll ?? null;

    $rootItems = collect();
    if ($menuRoot && method_exists($menuRoot, 'filter')) {
        $rootItems = $menuRoot
            ->filter(fn ($i) => empty($i->parent_id) && $i->is_published)
            ->sortBy('menu_order');
    }
@endphp

<header class="sticky top-0 z-40 backdrop-blur bg-white/85 border-b"
        style="border-color: var(--theme-border, #e5e7eb);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <a href="{{ url('/') }}" class="flex items-center gap-3 font-semibold"
               style="color: var(--theme-ink, #0f1a2b);">
                @if ($brandLogo)
                    <img src="{{ asset($brandLogo) }}" alt="{{ $brandName }}" class="h-8 w-auto">
                @endif
                <span class="text-lg">{{ $brandName }}</span>
            </a>

            @if ($rootItems->isNotEmpty())
                <nav class="hidden lg:flex items-center gap-1" aria-label="{{ __('theme::nav.primary') ?: 'Главное меню' }}">
                    @foreach ($rootItems as $item)
                        @php
                            $title = method_exists($item, 'translate')
                                ? ($item->translate('title', $locale) ?? $item->slug)
                                : $item->slug;
                            $url   = method_exists($item, 'translate')
                                ? ($item->translate('url',   $locale) ?? '#')
                                : '#';
                        @endphp
                        <a href="{{ $url }}"
                           class="px-3 py-2 rounded-md text-sm font-medium transition"
                           style="color: var(--theme-ink, #0f1a2b);">
                            {{ $title }}
                        </a>
                    @endforeach
                </nav>
            @endif

            <div class="flex items-center gap-2">
                @if ($features['language_switcher'] ?? true)
                    @includeIf('components.language-switcher')
                @endif

                @if ($features['apply_form'] ?? true)
                    <button type="button"
                            x-data
                            @click="$dispatch('open-modal', { modal: 'apply' })"
                            class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg font-semibold text-sm transition"
                            style="background: var(--theme-primary); color: var(--theme-on-primary);">
                        {{ __('theme::nav.apply') ?: 'Подать заявку' }}
                    </button>
                @endif

                <button type="button"
                        x-data="{ open: false }"
                        @click="open = !open; $dispatch('toggle-mobile-menu')"
                        class="lg:hidden p-2 rounded-md"
                        style="color: var(--theme-ink, #0f1a2b);"
                        aria-label="{{ __('theme::nav.menu') ?: 'Меню' }}">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>
