@extends('layouts.public')

{{--
    Shared error-page layout — used by 403/404/419/429/500/503 children.
    Children supply: $code, $heading, $body, optional $primaryAction / $secondaryAction.

    Strings prefer `lang/*/errors.php` translations:
      lang/{ru,kk,en}/errors.php
      [
        '404' => ['heading' => '…', 'body' => '…'],
        ...
      ]

    Children pass raw arrays so a site without translations still renders.
--}}

@php
    /** @var string $code */
    /** @var string|array $heading */
    /** @var string|array $body */
    $locale = app()->getLocale();
    $resolve = fn ($v) => is_array($v) ? ($v[$locale] ?? $v['ru'] ?? $v['en'] ?? '') : (string) $v;
@endphp

@section('title', $code . ' — ' . config('theme.brand.name'))

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-20"
         style="background: linear-gradient(135deg, var(--theme-surface-2), var(--theme-surface));">
    <div class="text-center px-4">
        <div class="text-9xl font-black mb-6"
             style="line-height: 1; color: var(--theme-primary);">
            {{ $code }}
        </div>

        <h1 class="text-2xl md:text-4xl font-semibold mb-4"
            style="color: var(--theme-ink);">
            {{ $resolve($heading) }}
        </h1>

        <p class="text-lg mb-10 max-w-md mx-auto"
           style="color: var(--theme-ink-muted);">
            {{ $resolve($body) }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg font-semibold transition"
               style="background: var(--theme-primary); color: var(--theme-on-primary);">
                <i class="fas fa-home"></i>
                {{ __('theme::errors.go_home') ?: 'На главную' }}
            </a>

            @if (Route::has('search'))
                <a href="{{ route('search') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg font-semibold border transition"
                   style="border-color: var(--theme-border); color: var(--theme-ink);">
                    <i class="fas fa-search"></i>
                    {{ __('theme::errors.search') ?: 'Поиск' }}
                </a>
            @endif
        </div>
    </div>
</section>
@endsection
