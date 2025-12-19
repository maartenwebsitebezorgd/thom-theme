@php
// Get ACF fields from post
$detailHeading = get_field('detail_heading');
$mainImage = get_field('main_image');
$introduction = get_field('introduction');
$readTime = get_field('read_time');
$relatedPosts = get_field('related_posts');
$teamMemberAuthorId = get_field('team_member_author');

// Get Theme Options settings
$headerTheme = get_field('single_header_theme', 'option') ?: 'grey';
$headerAlignment = get_field('single_header_alignment', 'option') ?: 'text-center';
$headerLayout = get_field('single_header_layout', 'option') ?: 'full-width';
$headerMaxWidth = get_field('single_header_max_width', 'option') ?: 'max-w-[70ch]';
$imageAspectRatio = get_field('single_image_aspect_ratio', 'option') ?: 'aspect-[16/9]';
$stretchToContent = get_field('single_stretch_to_content', 'option') ?? true;
$contentTheme = get_field('single_content_theme', 'option') ?: 'light';
$contentMaxWidth = get_field('single_content_max_width', 'option') ?: 'max-w-[80ch]';

// Visibility settings
$showBreadcrumbs = get_field('show_breadcrumbs', 'option') ?? true;
$showCategories = get_field('show_categories', 'option') ?? true;
$showAuthor = get_field('show_author', 'option') ?? true;
$showDate = get_field('show_date', 'option') ?? true;
$showReadTime = get_field('show_read_time', 'option') ?? true;
$showFeaturedImage = get_field('show_featured_image', 'option') ?? true;
$showRelatedPosts = get_field('show_related_posts', 'option') ?? true;
$showPostNavigation = get_field('show_post_navigation', 'option') ?? true;
$relatedPostsTheme = get_field('related_posts_theme', 'option') ?: 'grey';
$relatedPostsCount = get_field('related_posts_count', 'option') ?: 3;
$relatedPostsColumns = get_field('related_posts_columns', 'option') ?: 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3';

// Title and image
$title = $detailHeading ?: get_the_title();

$headerImage = null;
if ($showFeaturedImage) {
$headerImage = $mainImage;
if (!$headerImage && has_post_thumbnail()) {
$thumbnailId = get_post_thumbnail_id();
$headerImage = [
'ID' => $thumbnailId,
'id' => $thumbnailId,
'url' => wp_get_attachment_image_url($thumbnailId, 'full'),
'alt' => get_post_meta($thumbnailId, '_wp_attachment_image_alt', true),
];
}
}

$categories = get_the_category();

// Auto-calculate read time if not set
if (!$readTime) {
$content = get_post_field('post_content', get_the_ID());
$wordCount = str_word_count(strip_tags($content));
$readTime = max(1, ceil($wordCount / 200));
}

$blogUrl = get_option('page_for_posts') ? get_permalink(get_option('page_for_posts')) : home_url('/blog');

// Determine if split layout
$isSplitLayout = in_array($headerLayout, ['split', 'split-reverse']);
$isReverse = $headerLayout === 'split-reverse';
@endphp

<article {!! post_class('h-entry') !!} itemscope itemtype="https://schema.org/BlogPosting">

  @if($showBreadcrumbs)
  <nav data-theme="dark" class="u-section pt-section-small pb-u-3 pt-u-3" aria-label="Breadcrumb">
    <div class="u-container max-w-container-main">
      <ol class="breadcrumb flex flex-row gap-u-2 items-center u-text-style-small u-text-trim-off" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <a href="{{ home_url('/') }}" itemprop="item" class="hover:underline">
            <span itemprop="name">Home</span>
          </a>
          <meta itemprop="position" content="1" />
        </li>
        <li aria-hidden="true">/</li>
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <a href="{{ $blogUrl }}" itemprop="item" class="hover:underline">
            <span itemprop="name">Blog</span>
          </a>
          <meta itemprop="position" content="2" />
        </li>
        <li aria-hidden="true">/</li>
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
          <span itemprop="name" class="opacity-70">{!! get_the_title() !!}</span>
          <meta itemprop="position" content="3" />
        </li>
      </ol>
    </div>
  </nav>
  @endif

  <header data-theme="{{ $headerTheme }}" class="u-section pt-section-main pb-section-main">
    <div class="u-container max-w-container-main">
      @if($isSplitLayout && $headerImage)
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-u-8 items-center {{ $isReverse ? 'lg:flex-row-reverse' : '' }}">
        <div class="{{ $isReverse ? 'lg:order-2' : 'lg:order-1' }}">
          <div class="post-header_content u-margin-trim {{ $headerAlignment === 'text-center' ? 'mx-auto' : '' }} {{ $headerMaxWidth }}">
            @include('partials.content-single-header-content')
          </div>
        </div>

        <div class="{{ $isReverse ? 'lg:order-1' : 'lg:order-2' }}">
          <x-visual :visual="[
              'media_type' => 'image',
              'image' => $headerImage,
              'aspect_ratio' => $imageAspectRatio,
              'stretch_to_content' => $stretchToContent,
            ]" />
        </div>
      </div>
      @else
      <div class="post-header_content-wrapper">
        <div class="post-header_content u-margin-trim {{ $headerMaxWidth }} {{ $headerAlignment === 'text-center' ? 'mx-auto' : '' }} {{ $headerAlignment }}">
          @include('partials.content-single-header-content')
        </div>
      </div>

      @if($headerImage)
      <div class="post-header_visual-wrap mt-u-8">
        <x-visual :visual="[
            'media_type' => 'image',
            'image' => $headerImage,
            'aspect_ratio' => $imageAspectRatio,
          ]" />
      </div>
      @endif
      @endif
    </div>
  </header>

  <section data-theme="{{ $contentTheme }}" class="e-content u-section pt-section-main pb-section-tiny" itemprop="articleBody">
    <div class="u-container max-w-container-main">
      <div class="prose prose-lg {{ $contentMaxWidth }} mx-auto">
        @php
        the_content();
        @endphp
      </div>
    </div>
  </section>

  {{-- Author Section --}}
  @if($teamMemberAuthorId)
  @php
  // Get author data
  $authorName = get_the_title($teamMemberAuthorId);
  $authorJobTitle = get_field('job_title', $teamMemberAuthorId);
  $authorHeadshot = get_field('headshot', $teamMemberAuthorId);
  $authorBio = get_the_excerpt($teamMemberAuthorId);
  $authorSocialLinks = get_field('social_links', $teamMemberAuthorId);
  @endphp

  <section data-theme="{{ $contentTheme }}" class="u-section pt-section-tiny pb-section-main">
    <div class="u-container max-w-container-main ">
      <div class="{{ $contentMaxWidth }} mx-auto pt-u-5 border-t border-neutral-300">
        <h3 class="u-text-style-h5 mb-u-5">Geschreven door</h3>

        <div class="author-card flex flex-col md:flex-row gap-u-5 items-top">
          @if($authorHeadshot)
          <div class="author-photo shrink-0">
            <div class="aspect-square w-u-8 overflow-hidden rounded-full border-1 border-[var(--theme-accent)]">
              <img
                src="{{ $authorHeadshot['sizes']['medium'] ?? $authorHeadshot['url'] }}"
                alt="{{ $authorHeadshot['alt'] ?: $authorName }}"
                class="w-full h-full object-cover"
                loading="lazy" />
            </div>
          </div>
          @endif

          <div class="author-info flex-1 u-margin-trim">
            <h4 class="u-text-style-h6 mb-u-3">{{ $authorName }}</h4>

            @if($authorJobTitle)
            <p class="u-text-style-main text-[var(--theme-text)]/60 mb-u-4">{{ $authorJobTitle }}</p>
            @endif

            @if($authorBio)
            <div class="u-text-style-small mb-u-4 text-[var(--theme-text)]/60">
              {!! wpautop($authorBio) !!}
            </div>
            @endif

            @if($authorSocialLinks && is_array($authorSocialLinks) && count($authorSocialLinks) > 0)
            <div class="author-socials flex gap-u-3">
              @foreach($authorSocialLinks as $social)
              @if($social['url'])
              <a
                href="{{ $social['url'] }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center w-u-4 h-u-4 rounded-full bg-[var(--theme-text)]/10 hover:bg-[var(--theme-accent)] transition-colors"
                aria-label="{{ $social['platform'] ?? 'Social link' }}">
                @if($social['platform'] === 'facebook')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                @elseif($social['platform'] === 'instagram')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
                @elseif($social['platform'] === 'tiktok')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                </svg>
                @elseif($social['platform'] === 'threads')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 6.504 3.616 8.914 3.589 12c.027 3.086.718 5.496 2.057 7.164 1.43 1.781 3.631 2.695 6.54 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.3-1.634-1.75-.192 1.352-.622 2.446-1.284 3.272-.886 1.102-2.14 1.704-3.73 1.79-1.202.065-2.361-.218-3.259-.801-1.063-.689-1.685-1.74-1.752-2.964-.065-1.19.408-2.285 1.33-3.082.88-.76 2.119-1.207 3.583-1.291a13.853 13.853 0 0 1 3.02.142l-.126.742a13.08 13.08 0 0 0-2.858-.13c-1.268.07-2.309.436-3.02 1.061-.687.606-1.031 1.4-.974 2.24.05.867.506 1.606 1.28 2.08.688.424 1.592.635 2.545.592 1.279-.057 2.283-.555 2.99-1.482.65-.85 1.031-1.998 1.135-3.419l.017-.204c0-.027.006-.054.008-.082l.156-.003c.11-.008.22-.016.332-.022.11-.006.22-.011.332-.015l.149-.001c1.398 0 2.531.363 3.367 1.081.845.724 1.341 1.767 1.475 3.106.135 1.339-.225 2.573-.995 3.573-1.021 1.324-2.552 2.024-4.559 2.08l-.007.001zM8.52 9.227c-.403-.152-.797-.332-1.18-.538l-.044-.024C7.023 8.477 6.764 8.31 6.52 8.133c-.242-.175-.477-.364-.698-.564-.45-.404-.814-.875-1.083-1.401a4.29 4.29 0 0 1-.448-1.92c0-1.152.433-2.23 1.218-3.036.786-.807 1.839-1.252 2.964-1.252.618 0 1.214.142 1.771.422.558.28 1.047.686 1.454 1.206.409.522.705 1.131.881 1.812.177.682.208 1.398.091 2.13-.234 1.456-.919 2.594-2.037 3.382-.559.395-1.182.697-1.858.9l.145-.782z" />
                </svg>
                @else
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 0C5.372 0 0 5.373 0 12s5.372 12 12 12 12-5.373 12-12S18.628 0 12 0zm5.696 9.344c-.013 4.826-3.403 6.797-7.154 6.797-1.421 0-2.742-.416-3.854-1.127 1.324.156 2.646-.211 3.696-1.03-.915-.016-1.688-.621-1.954-1.451.131.025.264.038.401.038.195 0 .384-.027.563-.075-.956-.192-1.676-.981-1.676-1.992v-.025c.282.157.605.251.947.262-.56-.375-.93-.994-.93-1.704 0-.375.101-.726.277-1.029.954 1.17 2.38 1.94 3.987 2.02-.083-.355-.127-.725-.127-1.106 0-1.152.934-2.085 2.086-2.085.6 0 1.142.253 1.522.658.475-.094.921-.268 1.324-.507-.156.486-.487.894-.918 1.151.421-.051.823-.163 1.196-.33-.279.418-.632.786-1.04 1.08z" />
                </svg>
                @endif
              </a>
              @endif
              @endforeach
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  {{-- Split Form Section from Theme Options --}}
  @php
  $formHeading = get_field('single_form_heading', 'option');
  $formParagraph = get_field('single_form_paragraph', 'option');
  $formGravityFormId = get_field('single_form_gravity_form', 'option');

  if ($formGravityFormId) {
  // Build content block structure matching ContentWrapper component
  $contentBlock = [
  'heading' => $formHeading,
  'heading_tag' => 'h2',
  'heading_text_style' => 'u-text-style-h2',
  'paragraph' => $formParagraph,
  'paragraph_text_style' => 'u-text-style-main',
  'alignment' => 'text-left',
  'margin_bottom' => 'mb-0',
  ];

  // Build style settings with default values
  $styleSettings = [
  'theme' => 'accent-light',
  'padding_top' => 'pt-section-main',
  'padding_bottom' => 'pb-section-main',
  'container_size' => 'max-w-container-main',
  ];

  // Set view data
  $splitFormData = [
  'contentBlock' => $contentBlock,
  'showContactPerson' => false,
  'contactPersonId' => null,
  'gravityFormId' => $formGravityFormId,
  'formTitle' => false,
  'formDescription' => false,
  'styleSettings' => $styleSettings,
  'contentLayout' => 'form-right',
  'verticalAlignment' => 'items-top',
  'gapSize' => 'gap-u-8',
  'columnWidth' => '1:1',
  ];

  // Render the split_form template
  echo view('flexible.split_form', $splitFormData)->render();
  }
  @endphp

  @if($showRelatedPosts && $relatedPosts && count($relatedPosts) > 0)
  <section data-theme="{{ $relatedPostsTheme }}" class="related-posts u-section pt-section-main pb-section-main">
    <div class="u-container max-w-container-main">
      <h2 class="u-text-style-h3 mb-u-6 text-center">Ook interessant</h2>

      <div class="grid {{ $relatedPostsColumns }} gap-u-6">
        @foreach(array_slice($relatedPosts, 0, $relatedPostsCount) as $relatedPost)
        @php
        global $post;
        $post = $relatedPost;
        setup_postdata($post);

        $sectionTheme = $relatedPostsTheme;
        $cardTheme = 'light';
        $imageAspectRatio = 'aspect-[3/2]'; // aspect ratio
        $showExcerpt = true;
        $showCategory = true;
        $makeCardClickable = true;
        @endphp

        @include('partials.content')
        @endforeach

        @php(wp_reset_postdata())
      </div>
    </div>
  </section>
  @endif

  @if($showPostNavigation && get_the_post_navigation())
  <footer data-theme="light" class="u-section pt-section-small pb-section-small border-t">
    <div class="u-container max-w-container-main">
      <nav class="post-navigation flex justify-between gap-u-4" aria-label="Post navigation">
        @if($prevPost = get_previous_post())
        <a href="{{ get_permalink($prevPost) }}" rel="prev" class="flex-1 p-u-4 border rounded hover:bg-gray-50 transition-colors">
          <span class="u-text-style-small text-gray-600 block mb-u-2">← Previous Post</span>
          <span class="u-text-style-main font-medium">{{ get_the_title($prevPost) }}</span>
        </a>
        @else
        <div class="flex-1"></div>
        @endif

        @if($nextPost = get_next_post())
        <a href="{{ get_permalink($nextPost) }}" rel="next" class="flex-1 p-u-4 border rounded hover:bg-gray-50 transition-colors text-right">
          <span class="u-text-style-small text-gray-600 block mb-u-2">Next Post →</span>
          <span class="u-text-style-main font-medium">{{ get_the_title($nextPost) }}</span>
        </a>
        @else
        <div class="flex-1"></div>
        @endif
      </nav>
    </div>
  </footer>
  @endif
</article>