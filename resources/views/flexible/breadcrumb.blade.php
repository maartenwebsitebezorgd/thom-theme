@php
/**
 * Breadcrumb Section
 * Displays hierarchical navigation trail
 */

// Get field values
$breadcrumbType = get_sub_field('breadcrumb_type') ?? 'auto';
$showHome = get_sub_field('show_home');
$showCurrent = get_sub_field('show_current');
$separator = get_sub_field('separator') ?? '/';
$textAlignment = get_sub_field('text_alignment') ?? 'justify-start';
$textStyle = get_sub_field('text_style') ?? 'u-text-style-small';
$manualItems = get_sub_field('manual_items');
$styleSettings = get_sub_field('style_settings');

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-small';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-small';
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';

// Map separator to display character
$separatorMap = [
    '/' => '/',
    '>' => '>',
    'arrow' => '→',
    'pipe' => '|',
    'dot' => '•',
];
$separatorChar = $separatorMap[$separator] ?? '/';

// Generate breadcrumbs
$breadcrumbs = [];

if ($breadcrumbType === 'manual' && $manualItems) {
    // Manual breadcrumbs
    foreach ($manualItems as $item) {
        $breadcrumbs[] = [
            'label' => $item['label'],
            'url' => $item['link']['url'] ?? null,
        ];
    }
} else {
    // Auto-generate breadcrumbs
    if ($showHome) {
        $breadcrumbs[] = [
            'label' => 'Home',
            'url' => home_url('/'),
        ];
    }

    // Get current post/page
    global $post;

    if ($post) {
        // For pages, get parent hierarchy
        if (is_page()) {
            $ancestors = array_reverse(get_post_ancestors($post->ID));
            foreach ($ancestors as $ancestor) {
                $breadcrumbs[] = [
                    'label' => get_the_title($ancestor),
                    'url' => get_permalink($ancestor),
                ];
            }
        }

        // For posts, add blog page and category
        elseif (is_single()) {
            // Add blog page if set
            $blogPage = get_option('page_for_posts');
            if ($blogPage) {
                $breadcrumbs[] = [
                    'label' => get_the_title($blogPage),
                    'url' => get_permalink($blogPage),
                ];
            }

            // Add primary category
            $categories = get_the_category($post->ID);
            if (!empty($categories)) {
                $primaryCategory = $categories[0];
                $breadcrumbs[] = [
                    'label' => $primaryCategory->name,
                    'url' => get_category_link($primaryCategory->term_id),
                ];
            }
        }

        // For custom post types
        elseif (is_singular() && !is_page() && !is_single()) {
            $postType = get_post_type_object(get_post_type());
            if ($postType && $postType->has_archive) {
                $breadcrumbs[] = [
                    'label' => $postType->labels->name,
                    'url' => get_post_type_archive_link(get_post_type()),
                ];
            }
        }

        // Add current page/post
        if ($showCurrent) {
            $breadcrumbs[] = [
                'label' => get_the_title($post->ID),
                'url' => null, // Current page has no link
            ];
        }
    }

    // For archives
    elseif (is_archive()) {
        if (is_category()) {
            $category = get_queried_object();
            $breadcrumbs[] = [
                'label' => $category->name,
                'url' => null,
            ];
        } elseif (is_post_type_archive()) {
            $postType = get_queried_object();
            $breadcrumbs[] = [
                'label' => $postType->labels->name,
                'url' => null,
            ];
        }
    }
}

// Build schema.org structured data
$schemaItems = [];
foreach ($breadcrumbs as $index => $crumb) {
    $schemaItems[] = [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $crumb['label'],
        'item' => $crumb['url'] ?? '',
    ];
}

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $schemaItems,
];
@endphp

@if(!empty($breadcrumbs))
<section data-theme="{{ $theme }}" class="breadcrumb u-section {{ $paddingTop }} {{ $paddingBottom }}">
    <div class="u-container {{ $containerSize }}">
        <nav aria-label="Breadcrumb" class="flex {{ $textAlignment }}">
            <ol class="flex items-center gap-u-3 flex-wrap {{ $textStyle }}" itemscope itemtype="https://schema.org/BreadcrumbList">
                @foreach($breadcrumbs as $index => $crumb)
                    <li class="flex items-center gap-u-3" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        @if($crumb['url'])
                            <a
                                href="{{ $crumb['url'] }}"
                                class="text-[var(--theme-accent)] hover:underline transition-all duration-200"
                                itemprop="item"
                            >
                                <span itemprop="name">{{ $crumb['label'] }}</span>
                            </a>
                        @else
                            <span class="text-[var(--theme-text)]" itemprop="name">
                                {{ $crumb['label'] }}
                            </span>
                        @endif

                        <meta itemprop="position" content="{{ $index + 1 }}" />

                        @if($index < count($breadcrumbs) - 1)
                            <span class="text-[var(--theme-text)] opacity-60" aria-hidden="true">
                                {{ $separatorChar }}
                            </span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>

        {{-- Schema.org JSON-LD structured data --}}
        <script type="application/ld+json">
            {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </div>
</section>
@endif
