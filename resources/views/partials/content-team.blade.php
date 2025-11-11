@php
/**
* Team Member Card Partial
* Works in two modes:
* 1. With explicit $member array passed (e.g., from TeamGrid)
* 2. With WordPress global $post (e.g., from MultiSlider)
*/

// Check if $member array is provided, otherwise use global post
if (!isset($member) || empty($member)) {
// Get data from WordPress global post
$post_id = get_the_ID();
$name = get_the_title();
$jobTitle = get_field('job_title', $post_id);
$headshot = get_field('headshot', $post_id);
$email = get_field('email', $post_id);
$phone = get_field('phone', $post_id);
$socialLinks = get_field('social_links', $post_id);
$permalink = get_permalink($post_id);
} else {
// Get data from passed $member array
$name = $member['name'] ?? $member['post_title'] ?? '';
$jobTitle = $member['job_title'] ?? '';
$headshot = $member['headshot'] ?? [];
$email = $member['email'] ?? '';
$phone = $member['phone'] ?? '';
$socialLinks = $member['social_links'] ?? [];
$permalink = $member['permalink'] ?? get_permalink($member['ID'] ?? null);
}

// Get settings from parent scope or use defaults
$layout = $layout ?? 'standard'; // 'standard' or 'overlay'
$sectionTheme = $sectionTheme ?? 'inherit';
$cardTheme = $cardTheme ?? 'auto';
$imageAspectRatio = $imageAspectRatio ?? 'aspect-[4/5]';
$showEmail = $showEmail ?? false;
$showPhone = $showPhone ?? false;
$showSocials = $showSocials ?? false;
$makeCardClickable = $makeCardClickable ?? false;
$partialClasses = $partialClasses ?? '';

// Auto theme logic
if ($cardTheme === 'auto') {
$cardTheme = match($sectionTheme) {
'light' => 'grey',
'grey' => 'light',
'accent-light' => 'light',
'dark' => 'accent-light',
'accent' => 'light',
default => 'inherit',
};
}

// Generate unique ID for accessibility
$uniqueId = uniqid('team-card-');
@endphp

@if($layout === 'overlay')
{{-- Overlay Layout: Image covering with content overlaid --}}
@if($makeCardClickable && $permalink)
<a
    href="{{ $permalink }}"
    class="team-card team-card--overlay group block relative overflow-hidden {{ $imageAspectRatio }} {{ $partialClasses }}"
    data-theme="{{ $cardTheme }}"
    aria-labelledby="{{ $uniqueId }}-name">
    {{-- Background Image --}}
    @if(!empty($headshot))
    <div class="absolute inset-0 team-card-image-zoom">
        <img
            src="{{ $headshot['sizes']['card'] ?? $headshot['url'] }}"
            srcset="{{ $headshot['sizes']['card'] ?? $headshot['url'] }} 600w,
                                {{ $headshot['sizes']['medium_large'] ?? $headshot['url'] }} 768w,
                                {{ $headshot['url'] }} 1200w"
            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
            alt="{{ $headshot['alt'] ?? $name }}"
            class="w-full h-full object-cover"
            loading="lazy" />
    </div>
    @endif

    {{-- Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

    {{-- Content Overlay --}}
    <div class="absolute inset-0 flex flex-col justify-end p-u-4">
        <h3 id="{{ $uniqueId }}-name" class="u-text-style-h5 text-white u-margin-trim mb-u-3">
            {{ $name }}
        </h3>
        @if($jobTitle)
        <p class="u-text-style-small text-white/90">
            {{ $jobTitle }}
        </p>
        @endif
    </div>
</a>
@else
<div
    class="team-card team-card--overlay group relative overflow-hidden {{ $imageAspectRatio }} {{ $partialClasses }}"
    data-theme="{{ $cardTheme }}">
    {{-- Background Image --}}
    @if(!empty($headshot))
    <div class="absolute inset-0 team-card-image-zoom">
        <img
            src="{{ $headshot['sizes']['card'] ?? $headshot['url'] }}"
            srcset="{{ $headshot['sizes']['card'] ?? $headshot['url'] }} 600w,
                                {{ $headshot['sizes']['medium_large'] ?? $headshot['url'] }} 768w,
                                {{ $headshot['url'] }} 1200w"
            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
            alt="{{ $headshot['alt'] ?? $name }}"
            class="w-full h-full object-cover"
            loading="lazy" />
    </div>
    @endif

    {{-- Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

    {{-- Content Overlay --}}
    <div class="absolute inset-0 flex flex-col justify-end p-u-4">
        <h3 id="{{ $uniqueId }}-name" class="u-text-style-h5 text-white u-margin-trim mb-u-2">
            {{ $name }}
        </h3>
        @if($jobTitle)
        <p class="u-text-style-small text-white/90">
            {{ $jobTitle }}
        </p>
        @endif

        {{-- Contact Info (shown on hover) --}}
        @if($showEmail || $showPhone || $showSocials)
        <div class="mt-u-3 opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
            @if($showEmail && $email)
            <a href="mailto:{{ $email }}" class="block text-white/90 hover:text-white u-text-style-small mb-u-2">
                {{ $email }}
            </a>
            @endif
            @if($showPhone && $phone)
            <a href="tel:{{ $phone }}" class="block text-white/90 hover:text-white u-text-style-small mb-u-2">
                {{ $phone }}
            </a>
            @endif
            @if($showSocials && !empty($socialLinks))
            <div class="flex gap-u-2 mt-u-2">
                @foreach($socialLinks as $social)
                <a
                    href="{{ $social['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-white/90 hover:text-white transition-colors"
                    aria-label="{{ $social['platform'] }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z" />
                    </svg>
                </a>
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endif

@else
{{-- Standard Layout: Image on top, content below --}}
@if($makeCardClickable && $permalink)
<a
    href="{{ $permalink }}"
    class="team-card team-card--standard group block {{ $partialClasses }}"
    data-theme="{{ $cardTheme }}"
    aria-labelledby="{{ $uniqueId }}-name">
    {{-- Image --}}
    @if(!empty($headshot))
    <div class="relative overflow-hidden {{ $imageAspectRatio }} mb-u-4">
        <img
            src="{{ $headshot['sizes']['card'] ?? $headshot['url'] }}"
            srcset="{{ $headshot['sizes']['card'] ?? $headshot['url'] }} 600w,
                                {{ $headshot['sizes']['medium_large'] ?? $headshot['url'] }} 768w,
                                {{ $headshot['url'] }} 1200w"
            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
            alt="{{ $headshot['alt'] ?? $name }}"
            class="w-full h-full object-cover team-card-image-zoom"
            loading="lazy" />
    </div>
    @endif

    {{-- Content --}}
    <div class="px-u-3 pb-u-3 u-margin-trim">
        <h3 id="{{ $uniqueId }}-name" class="team-card-title u-text-style-h5 text-[var(--theme-heading)] mb-u-3">
            {{ $name }}
        </h3>
        @if($jobTitle)
        <p class="u-text-style-main text-[var(--theme-text)] mb-u-3">
            {{ $jobTitle }}
        </p>
        @endif

        {{-- Contact Info --}}
        @if($showEmail || $showPhone || $showSocials)
        <div class="space-y-1">
            @if($showEmail && $email)
            <p class="u-text-style-small text-[var(--theme-text)]">
                <a href="mailto:{{ $email }}" class="text-[var(--theme-accent)] hover:underline">
                    {{ $email }}
                </a>
            </p>
            @endif
            @if($showPhone && $phone)
            <p class="u-text-style-small text-[var(--theme-text)]">
                <a href="tel:{{ $phone }}" class="text-[var(--theme-accent)] hover:underline">
                    {{ $phone }}
                </a>
            </p>
            @endif
            @if($showSocials && !empty($socialLinks))
            <div class="flex gap-u-2 mt-u-2">
                @foreach($socialLinks as $social)
                <a
                    href="{{ $social['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-[var(--theme-accent)] hover:text-[var(--theme-heading)] transition-colors"
                    aria-label="{{ $social['platform'] }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z" />
                    </svg>
                </a>
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>
</a>
@else
<div
    class="team-card team-card--standard group {{ $partialClasses }}"
    data-theme="{{ $cardTheme }}">
    {{-- Image --}}
    @if(!empty($headshot))
    <div class="relative overflow-hidden {{ $imageAspectRatio }} mb-u-4">
        <img
            src="{{ $headshot['sizes']['card'] ?? $headshot['url'] }}"
            srcset="{{ $headshot['sizes']['card'] ?? $headshot['url'] }} 600w,
                                {{ $headshot['sizes']['medium_large'] ?? $headshot['url'] }} 768w,
                                {{ $headshot['url'] }} 1200w"
            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
            alt="{{ $headshot['alt'] ?? $name }}"
            class="w-full h-full object-cover team-card-image-zoom"
            loading="lazy" />
    </div>
    @endif

    {{-- Content --}}
    <div class="px-u-3 pb-u-3 u-margin-trim">
        <h3 id="{{ $uniqueId }}-name" class="u-text-style-h5 text-[var(--theme-heading)] mb-u-3">
            {{ $name }}
        </h3>
        @if($jobTitle)
        <p class="u-text-style-main text-[var(--theme-text)] mb-u-3">
            {{ $jobTitle }}
        </p>
        @endif

        {{-- Contact Info --}}
        @if($showEmail || $showPhone || $showSocials)
        <div class="space-y-1">
            @if($showEmail && $email)
            <p class="u-text-style-small text-[var(--theme-text)]">
                <a href="mailto:{{ $email }}" class="text-[var(--theme-accent)] hover:underline">
                    {{ $email }}
                </a>
            </p>
            @endif
            @if($showPhone && $phone)
            <p class="u-text-style-small text-[var(--theme-text)]">
                <a href="tel:{{ $phone }}" class="text-[var(--theme-accent)] hover:underline">
                    {{ $phone }}
                </a>
            </p>
            @endif
            @if($showSocials && !empty($socialLinks))
            <div class="flex gap-u-2 mt-u-2">
                @foreach($socialLinks as $social)
                <a
                    href="{{ $social['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-[var(--theme-accent)] hover:text-[var(--theme-heading)] transition-colors"
                    aria-label="{{ $social['platform'] }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z" />
                    </svg>
                </a>
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endif
@endif