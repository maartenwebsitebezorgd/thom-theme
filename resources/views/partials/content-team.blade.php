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

// Normalize social links data (handle old text format vs new select format)
if (!empty($socialLinks) && is_array($socialLinks)) {
    $socialLinks = array_map(function($social) {
        // Ensure platform exists and is accessible
        if (is_array($social)) {
            return $social;
        }
        // Handle case where social link is a string or malformed
        return ['platform' => 'website', 'url' => ''];
    }, $socialLinks);
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
{{-- ============================================
     OVERLAY LAYOUT
     - Full-bleed image with content overlaid at bottom
     - Dark gradient overlay for text readability
     - makeCardClickable option: When true, only the NAME (h3) becomes a clickable link to team member detail page
     - Contact info (email, phone, socials) is ALWAYS independently clickable when enabled, regardless of makeCardClickable setting
     ============================================ --}}
<div
    class="team-card team-card--overlay group relative overflow-hidden {{ $imageAspectRatio }} {{ $partialClasses }}"
    data-theme="{{ $cardTheme }}">

    {{-- Background Image: Full cover image --}}
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

    {{-- Gradient Overlay: Ensures text readability --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

    {{-- Content Overlay: Team member information positioned at bottom --}}
    <div class="absolute inset-0 flex flex-col justify-end p-u-5">

        {{-- Team Member Name: Conditionally clickable based on makeCardClickable --}}
        @if($makeCardClickable && $permalink)
        {{-- makeCardClickable = true: Name links to team member detail page --}}
        <a href="{{ $permalink }}" class="block mb-u-3" aria-labelledby="{{ $uniqueId }}-name">
            <h3 id="{{ $uniqueId }}-name" class="u-text-style-h5 text-white u-margin-trim">
                {{ $name }}
            </h3>
        </a>
        @else
        {{-- makeCardClickable = false: Name is plain text --}}
        <h3 id="{{ $uniqueId }}-name" class="u-text-style-h5 text-white u-margin-trim mb-u-3">
            {{ $name }}
        </h3>
        @endif

        {{-- Job Title --}}
        @if($jobTitle)
        <p class="u-text-style-small text-white/90 mb-u-4">
            {{ $jobTitle }}
        </p>
        @endif

        {{-- Contact Information: ALWAYS clickable when enabled (independent of makeCardClickable) --}}
        @if($showEmail || $showPhone || $showSocials)
        <div class="space-y-3">
            {{-- Email: Direct mailto link --}}
            @if($showEmail && $email)
            <a href="mailto:{{ $email }}" class="block text-white/90 hover:text-white u-text-style-small">
                {{ $email }}
            </a>
            @endif

            {{-- Phone: Direct tel link --}}
            @if($showPhone && $phone)
            <a href="tel:{{ $phone }}" class="block text-white/90 hover:text-white u-text-style-small">
                {{ $phone }}
            </a>
            @endif

            {{-- Social Links: External platform links --}}
            @if($showSocials && !empty($socialLinks))
            <div class="flex gap-u-2 mt-u-2">
                @foreach($socialLinks as $social)
                @if(is_array($social) && !empty($social['url']))
                <a
                    href="{{ $social['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-white/90 hover:text-white transition-colors"
                    aria-label="{{ $social['platform'] ?? 'Social Media' }}">
                    <x-social-icon :platform="$social['platform'] ?? 'website'" class="w-5 h-5" />
                </a>
                @endif
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

@else
{{-- ============================================
     STANDARD LAYOUT
     - Traditional card layout: Image on top, content below
     - makeCardClickable option: When true, entire card becomes clickable link
     - Contact info is embedded within the card structure
     ============================================ --}}
@if($makeCardClickable && $permalink)
<a
    href="{{ $permalink }}"
    class="team-card team-card--standard group block {{ $partialClasses }}"
    data-theme="{{ $cardTheme }}"
    aria-labelledby="{{ $uniqueId }}-name">
    {{-- Image --}}
    @if(!empty($headshot))
    <div class="relative overflow-hidden {{ $imageAspectRatio }}">
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
    <div class="py-u-4 u-margin-trim">
        <h3 id="{{ $uniqueId }}-name" class="team-card-title u-text-style-h5 text-[var(--theme-heading)] mb-u-3">
            {{ $name }}
        </h3>
        @if($jobTitle)
        <p class="u-text-style-small text-[var(--theme-text)] mb-u-4">
            {{ $jobTitle }}
        </p>
        @endif

        {{-- Contact Info --}}
        @if($showEmail || $showPhone || $showSocials)
        <div class="space-y-3">
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
                @if(is_array($social) && !empty($social['url']))
                <a
                    href="{{ $social['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-[var(--theme-accent)] hover:text-[var(--theme-heading)] transition-colors"
                    aria-label="{{ $social['platform'] ?? 'Social Media' }}">
                    <x-social-icon :platform="$social['platform'] ?? 'website'" class="w-5 h-5" />
                </a>
                @endif
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
                @if(is_array($social) && !empty($social['url']))
                <a
                    href="{{ $social['url'] }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-[var(--theme-accent)] hover:text-[var(--theme-heading)] transition-colors"
                    aria-label="{{ $social['platform'] ?? 'Social Media' }}">
                    <x-social-icon :platform="$social['platform'] ?? 'website'" class="w-5 h-5" />
                </a>
                @endif
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endif
@endif