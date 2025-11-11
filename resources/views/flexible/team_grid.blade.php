@php
/**
 * Team Grid Section
 * Displays team members in a responsive grid layout
 */

// Get field values
$contentBlock = get_sub_field('content_block');
$useAllTeam = get_sub_field('use_all_team');
$selectedTeam = get_sub_field('selected_team');
$numberOfTeam = get_sub_field('number_of_team') ?? 4;
$cardLayout = get_sub_field('card_layout') ?? 'standard';
$imageAspectRatio = get_sub_field('image_aspect_ratio') ?? 'aspect-[4/5]';
$showEmail = get_sub_field('show_email');
$showPhone = get_sub_field('show_phone');
$showSocials = get_sub_field('show_socials');
$makeCardsClickable = get_sub_field('make_cards_clickable');
$styleSettings = get_sub_field('style_settings');

// Grid settings
$gridColumnsDesktop = get_sub_field('grid_columns_desktop') ?? 'grid-cols-4';
$gridColumnsTablet = get_sub_field('grid_columns_tablet') ?? 'grid-cols-2';
$gridColumnsMobile = get_sub_field('grid_columns_mobile') ?? 'grid-cols-1';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-4';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';

// Get team members
if ($useAllTeam) {
    $teamPosts = get_posts([
        'post_type' => 'team',
        'posts_per_page' => $numberOfTeam,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);
} else {
    $teamPosts = [];
    if ($selectedTeam) {
        foreach ($selectedTeam as $teamId) {
            $post = get_post($teamId);
            if ($post) {
                $teamPosts[] = $post;
            }
        }
    }
}

// Build team members array
$teamMembers = [];

foreach ($teamPosts as $post) {
    // Get ACF fields
    $headshot = get_field('headshot', $post->ID);
    $jobTitle = get_field('job_title', $post->ID);
    $email = get_field('email', $post->ID);
    $phone = get_field('phone', $post->ID);
    $socialLinks = get_field('social_links', $post->ID);

    $teamMembers[] = [
        'ID' => $post->ID,
        'name' => $post->post_title,
        'post_title' => $post->post_title,
        'job_title' => $jobTitle,
        'headshot' => $headshot,
        'email' => $email,
        'phone' => $phone,
        'social_links' => $socialLinks,
        'permalink' => get_permalink($post->ID),
    ];
}
@endphp

<section data-theme="{{ $theme }}" class="team-grid u-section {{ $paddingTop }} {{ $paddingBottom }}">
    <div class="u-container">

        {{-- Section Content (Heading, Paragraph, Buttons) --}}
        @if ($contentBlock)
            <div class="mb-u-6">
                <x-content-wrapper :content="$contentBlock" />
            </div>
        @endif

        {{-- Team Grid --}}
        @if ($teamMembers)
            <div class="team-grid-wrapper">
                <div class="grid {{ $gridColumnsMobile }} md:{{ $gridColumnsTablet }} lg:{{ $gridColumnsDesktop }} {{ $gapSize }}">
                    @foreach ($teamMembers as $member)
                        <div>
                            @include('partials.content-team', [
                                'member' => $member,
                                'layout' => $cardLayout,
                                'imageAspectRatio' => $imageAspectRatio,
                                'showEmail' => $showEmail,
                                'showPhone' => $showPhone,
                                'showSocials' => $showSocials,
                                'makeCardClickable' => $makeCardsClickable,
                                'sectionTheme' => $theme,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>
