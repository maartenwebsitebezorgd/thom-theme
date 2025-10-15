@php
$styleSettings = get_sub_field('style_settings');

// Style Settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
// Card styling (section level)
$cardTheme = get_sub_field('card_theme') ?? 'inherit';

// Get cards
$cards = get_sub_field('cards');

// Heading content
$headingContent = get_sub_field('heading_content');
$headingText = $headingContent['heading_text'] ?? 'Direct benieuwd naar onze diensten?';
$linkText = $headingContent['link_text'] ?? '';
$link = $headingContent['link'] ?? null;

// Process heading with inline link
$processedHeading = $headingText;
if (!empty($linkText) && !empty($link['url']) && str_contains($headingText, $linkText)) {
    $linkUrl = $link['url'];
    $linkTarget = $link['target'] ?? '_self';
    $linkRel = $linkTarget === '_blank' ? ' rel="noopener noreferrer"' : '';
    $linkAriaLabel = $linkTarget === '_blank' ? ' aria-label="' . esc_attr($linkText) . ' (opens in new tab)"' : '';

    // Replace the link text with an anchor tag
    $anchorTag = sprintf(
        '<a href="%s" target="%s"%s%s class="underline hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-current rounded transition-all">%s</a>',
        esc_url($linkUrl),
        esc_attr($linkTarget),
        $linkRel,
        $linkAriaLabel,
        esc_html($linkText)
    );

    $processedHeading = str_replace($linkText, $anchorTag, $headingText);
}

@endphp

<section data-theme="{{ $theme }}" class="u-section {{ $paddingTop }} {{ $paddingBottom }} @if ($bgColor) {{ $bgColor }} @endif">
    <div class="u-container">
        <div class="service-line_layout">
            <div class="service-line_main-wrap flex flex-row gap-u-4 items-center justify-between flex-wrap">
                <div class="service-line_heading-wrap flex flex-row gap-u-1 shrink items-center u-text-style-main">
                    <span class="service-Line_icon-wrap size-u-3 shrink-0 flex flex-col justify-center" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" role="presentation">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                    </span> {!! $processedHeading !!}
                </div>


                <div class="flex flex-row flex-wrap gap-u-5 md:gap-u-3 xl:gap-u-6 items-center">
                    @foreach ($cards as $cardItem)
                    <x-service-line
                        :card="$cardItem['service_card']"
                        :card-theme="$cardTheme" />
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>