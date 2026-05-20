{{--
    Generic dispatcher for PageBlock collections.

    Usage:
        @include('components.page-blocks', ['blocks' => $blocks])

    `$blocks` is a Collection of PageBlock-like rows with `block_type` /
    `data` columns. Each row is rendered via Meta\AdminCore's BlockRegistry —
    the same registry that AdminCore::useBlocks() populates from your
    AppServiceProvider.

    Unknown block_type ⇒ silently logged, empty string rendered (registry
    handles this so a typo doesn't 500 the whole page).

    Site can override per-block by creating
    `resources/views/blocks/v2/{handle}.blade.php`, which the view finder
    picks before falling back to the package's default.
--}}
@php
    /** @var \Illuminate\Support\Collection|iterable $blocks */
    $blocks = $blocks ?? collect();
    $registry = app(\Meta\AdminCore\Blocks\BlockRegistry::class);
    $locale = app()->getLocale();
@endphp

@foreach ($blocks as $block)
    @php
        $handle = $block->block_type ?? null;
        $data   = is_array($block->data ?? null) ? $block->data : [];

        // Translatable Setter columns (title/subtitle/content) are merged
        // into data so block render() receives one flat array per render.
        foreach (['title', 'subtitle', 'content'] as $f) {
            if (! array_key_exists($f, $data) && isset($block->{$f})) {
                $data[$f] = $block->{$f};
            }
        }
    @endphp

    @if ($handle && $registry->has($handle))
        {!! $registry->render($handle, $data, $locale) !!}
    @endif
@endforeach
