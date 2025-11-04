@props([
'card' => [],
'sectionTheme' => 'inherit',
'cardTheme' => 'auto',
])

@php
$icon = $card['icon'] ?? null;
$heading = $card['heading'] ?? '';
$text = $card['text'] ?? '';
$link = $card['link'] ?? null;
$makeCardClickable = $card['make_card_clickable'] ?? true;

$linkUrl = $link['url'] ?? null;
$linkTarget = $link['target'] ?? '_self';
$linkTitle = $link['title'] ?? 'Learn more';

// Generate unique ID for aria-labelledby
$uniqueId = uniqid('service-');

// Determine if icon is decorative or meaningful
$iconAlt = $icon['alt'] ?? '';
$isIconDecorative = empty($iconAlt) && !empty($heading);
@endphp

@if($link && $makeCardClickable)
{{-- Fully clickable card version --}}
<div data-theme="{{ $cardTheme }}" class="service-line_component flex-1 md:shrink-0 md:flex-none">
    <a
        href="{{ $linkUrl }}"
        target="{{ $linkTarget }}"
        @if($linkTarget==='_blank' ) rel="noopener noreferrer" @endif
        class="service-line_inner-wrap service-line_clickable flex flex-row gap-u-2 items-start group focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-4 focus-visible:ring-current rounded transition-all hover:opacity-80"
        aria-labelledby="{{ $uniqueId }}-title"
        @if($linkTarget==='_blank' ) aria-describedby="{{ $uniqueId }}-external" @endif>
        <div class="service-line_icon-wrap mt-[-0.25em] size-u-4 shrink-0 flex flex-col justify-center" aria-hidden="true">
            <img
                src="{{ $icon['url'] }}"
                alt="{{ $isIconDecorative ? '' : ($iconAlt ?: $heading) }}"
                class="w-full h-full object-contain"
                loading="lazy"
                @if($isIconDecorative) role="presentation" @endif>
        </div>
        <div class="service-line_text-wrap flex-1 u-margin-trim">
            @if ($heading)
            <h3 id="{{ $uniqueId }}-title" class="service-card-heading u-text-style-small !font-bold mb-u-2">
                <span class="service-card-heading-text">{{ $heading }}</span>
            </h3>
            @endif
            @if ($linkTitle)
            <span class="underline-offset-2 u-text-style-small underline ml-auto group-hover:no-underline" aria-hidden="true">
                {{ $linkTitle }}
            </span>
            @endif
            @if($linkTarget === '_blank')
            <span id="{{ $uniqueId }}-external" class="sr-only">Opens in new tab</span>
            @endif
        </div>
    </a>
</div>
@elseif($link && !$makeCardClickable)
{{-- Non-clickable card with inline link --}}
<div data-theme="{{ $cardTheme }}" class="service-line_component flex-1 md:shrink-0 md:flex-none">
    <div class="service-line_inner-wrap flex flex-row gap-u-2 items-start">
        <div class="service-line_icon-wrap mt-[-0.25em] size-u-4 shrink-0 flex flex-col justify-center" aria-hidden="true">
            <img
                src="{{ $icon['url'] }}"
                alt="{{ $isIconDecorative ? '' : ($iconAlt ?: $heading) }}"
                class="w-full h-full object-contain"
                loading="lazy"
                @if($isIconDecorative) role="presentation" @endif>
        </div>
        <div class="service-line_text-wrap flex-1 u-margin-trim">
            @if ($heading)
            <h3 class="service-card-heading u-text-style-small !font-bold mb-u-2">
                <span class="service-card-heading-text">{{ $heading }}</span>
            </h3>
            @endif
            <a
                href="{{ $linkUrl }}"
                target="{{ $linkTarget }}"
                @if($linkTarget==='_blank' ) rel="noopener noreferrer" aria-label="{{ $linkTitle }} (opens in new tab)" @endif
                class="underline-offset-2 u-text-style-small underline ml-auto focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-current rounded transition-all hover:no-underline">
                {{ $linkTitle }}
            </a>
        </div>
    </div>
</div>
@else
{{-- No link version --}}
<div data-theme="{{ $cardTheme }}" class="service-line_component flex-1 md:shrink-0 md:flex-none">
    <div class="service-line_inner-wrap flex flex-row gap-u-2 items-center">
        <div class="service-line_icon-wrap mt-[-0.25em] size-u-4 shrink-0 flex flex-col justify-center" aria-hidden="true">
            <img
                src="{{ $icon['url'] }}"
                alt="{{ $isIconDecorative ? '' : ($iconAlt ?: $heading) }}"
                class="w-full h-full object-contain"
                loading="lazy"
                @if($isIconDecorative) role="presentation" @endif>
        </div>
        <div class="service-line_text-wrap flex-1 u-margin-trim">
            @if ($heading)
            <h3 class="service-card-heading u-text-style-small !font-bold">
                <span class="service-card-heading-text">{{ $heading }}</span>
            </h3>
            @endif
        </div>
    </div>
</div>
@endif