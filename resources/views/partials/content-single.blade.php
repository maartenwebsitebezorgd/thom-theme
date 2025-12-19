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
    @include('partials.author-card', [
      'teamMemberAuthorId' => $teamMemberAuthorId,
      'contentTheme' => $contentTheme,
      'contentMaxWidth' => $contentMaxWidth,
    ])
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
  'showBackground' => true,
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