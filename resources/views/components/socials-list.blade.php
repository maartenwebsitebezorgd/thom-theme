@php
// Get location context (header or footer)
$location = $location ?? 'footer';

// Get display settings from Theme Options
$showInHeader = get_field('show_social_header', 'option');
$showInFooter = get_field('show_social_footer', 'option');

// Check if we should display in this location
$shouldDisplay = ($location === 'header' && $showInHeader) || ($location === 'footer' && $showInFooter);

// Get social media links from Theme Options
$facebookUrl = get_field('facebook_url', 'option');
$twitterUrl = get_field('twitter_url', 'option');
$instagramUrl = get_field('instagram_url', 'option');
$linkedinUrl = get_field('linkedin_url', 'option');
$youtubeUrl = get_field('youtube_url', 'option');
$customSocialLinks = get_field('custom_social_links', 'option');

// Link styling
$linkClasses = 'text-[var(--theme-text)]/70 hover:text-[var(--theme-text)] transition-colors duration-200';

// Check if any social links exist
$hasSocialLinks = $facebookUrl || $twitterUrl || $instagramUrl || $linkedinUrl || $youtubeUrl || !empty($customSocialLinks);
@endphp

@if($shouldDisplay && $hasSocialLinks)
<div class="flex gap-x-6">
    @if($facebookUrl)
    <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer" class="{{ $linkClasses }}">
        <span class="sr-only">Facebook</span>
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6">
            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" fill-rule="evenodd" />
        </svg>
    </a>
    @endif

    @if($twitterUrl)
    <a href="{{ $twitterUrl }}" target="_blank" rel="noopener noreferrer" class="{{ $linkClasses }}">
        <span class="sr-only">X (Twitter)</span>
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6">
            <path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218H13.6823ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z" />
        </svg>
    </a>
    @endif

    @if($instagramUrl)
    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="{{ $linkClasses }}">
        <span class="sr-only">Instagram</span>
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6">
            <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" fill-rule="evenodd" />
        </svg>
    </a>
    @endif

    @if($linkedinUrl)
    <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="{{ $linkClasses }}">
        <span class="sr-only">LinkedIn</span>
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6">
            <path d="M20.5 2h-17A1.5 1.5 0 002 3.5v17A1.5 1.5 0 003.5 22h17a1.5 1.5 0 001.5-1.5v-17A1.5 1.5 0 0020.5 2zM8 19H5v-9h3zM6.5 8.25A1.75 1.75 0 118.3 6.5a1.78 1.78 0 01-1.8 1.75zM19 19h-3v-4.74c0-1.42-.6-1.93-1.38-1.93A1.74 1.74 0 0013 14.19a.66.66 0 000 .14V19h-3v-9h2.9v1.3a3.11 3.11 0 012.7-1.4c1.55 0 3.36.86 3.36 3.66z" />
        </svg>
    </a>
    @endif

    @if($youtubeUrl)
    <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer" class="{{ $linkClasses }}">
        <span class="sr-only">YouTube</span>
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6">
            <path d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" fill-rule="evenodd" />
        </svg>
    </a>
    @endif

    @if(!empty($customSocialLinks))
        @foreach($customSocialLinks as $social)
            @if(!empty($social['url']))
            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" class="{{ $linkClasses }}">
                <span class="sr-only">{{ $social['platform'] ?? 'Social Media' }}</span>
                @if(!empty($social['icon_class']))
                    <i class="{{ $social['icon_class'] }} size-6" aria-hidden="true"></i>
                @else
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="size-6">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                @endif
            </a>
            @endif
        @endforeach
    @endif
</div>
@endif
