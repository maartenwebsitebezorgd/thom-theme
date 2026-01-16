@php
// Get whitepaper ACF fields
$formImage = get_field('form_image');
$gravityFormId = get_field('gravity_form');
$formHeading = get_field('form_heading') ?: 'Vraag de whitepaper aan';
$formParagraph = get_field('form_paragraph') ?: 'Laat je gegevens achter om de whitepaper te downloaden!';

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
$showFeaturedImage = get_field('show_featured_image', 'option') ?? true;

// Title and image
$title = get_the_title();

$headerImage = null;
if ($showFeaturedImage && has_post_thumbnail()) {
$thumbnailId = get_post_thumbnail_id();
$headerImage = [
'ID' => $thumbnailId,
'id' => $thumbnailId,
'url' => wp_get_attachment_image_url($thumbnailId, 'full'),
'alt' => get_post_meta($thumbnailId, '_wp_attachment_image_alt', true),
];
}

$whitepaperUrl = get_post_type_archive_link('whitepaper') ?: home_url('/whitepapers');

// Determine if split layout
$isSplitLayout = in_array($headerLayout, ['split', 'split-reverse']);
$isReverse = $headerLayout === 'split-reverse';
@endphp

<article {!! post_class('h-entry') !!} itemscope itemtype="https://schema.org/Article">

  @if($showBreadcrumbs)
  <nav data-theme="dark" class="u-section pt-u-3 pb-u-3" aria-label="Breadcrumb">
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
          <a href="{{ $whitepaperUrl }}" itemprop="item" class="hover:underline">
            <span itemprop="name">Whitepapers</span>
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
          <div class="whitepaper-header_content u-margin-trim {{ $headerAlignment === 'text-center' ? 'mx-auto' : '' }} {{ $headerMaxWidth }}">
            <h1 class="p-name u-text-style-h1 mb-u-4" itemprop="headline">{!! $title !!}</h1>

            @if(has_excerpt())
            <div class="u-text-style-large text-[var(--theme-text)]/80">
              {!! get_the_excerpt() !!}
            </div>
            @endif
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
      <div class="whitepaper-header_content-wrapper">
        <div class="whitepaper-header_content u-margin-trim {{ $headerMaxWidth }} {{ $headerAlignment === 'text-center' ? 'mx-auto' : '' }} {{ $headerAlignment }}">
          <h1 class="p-name u-text-style-h1 mb-u-4" itemprop="headline">{!! $title !!}</h1>

          @if(has_excerpt())
          <div class="u-text-style-large text-[var(--theme-text)]/80">
            {!! get_the_excerpt() !!}
          </div>
          @endif
        </div>
      </div>

      @if($headerImage)
      <div class="whitepaper-header_visual-wrap mt-u-8">
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

  {{-- Content --}}
  <section data-theme="{{ $contentTheme }}" class="e-content u-section pt-section-main pb-section-main" itemprop="articleBody">
    <div class="u-container max-w-container-main">
      <div class="prose prose-lg {{ $contentMaxWidth }} mx-auto">
        @php
        the_content();
        @endphp
      </div>
    </div>
  </section>

  {{-- Split Form Section --}}
  @if($gravityFormId)
  <section data-theme="accent-light" class="u-section pt-section-main pb-section-main">
    <div class="u-container max-w-container-main">
      <div class="split-form_background-wrap absolute inset-0 z-0 flex items-end overflow-clip">
        <div class="split-form_background-image w-1/6 max-h -mb-4  aspect-square  pointer-events-none opacity-20">
          <svg width="100%" height="100%" viewBox="0 0 182 179" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M168 91.4211C166.585 95.2271 165.928 99.8649 170.629 101.68C176.163 103.797 178.311 100.016 180.762 94.8995C181.192 93.9669 181.571 93.0595 182 92.1521L172.12 82.0195C170.224 86.1532 168.733 89.4551 168 91.4463V91.4211Z" fill="currentColor"></path>
            <path d="M138.256 167.994C139.419 173.111 139.292 180.295 147.354 178.505C154.404 176.942 151.801 170.591 150.993 166.079C145.661 136.916 144.321 108.107 157.69 80.4312C159.105 77.4821 160.57 74.5583 162.011 71.6345L152.13 61.502C134.188 95.025 129.791 130.489 138.256 168.02V167.994Z" fill="currentColor"></path>
            <path d="M68.2316 114.433C71.6937 77.558 82.5601 43.1779 102.448 10.4362L93.1991 0.958984C92.3146 2.06802 90.8995 4.28609 89.9139 6.00005C58.4013 60.1915 47.5096 117.811 58.3507 178.959H71.3905C67.5493 157.61 66.1847 136.16 68.2316 114.459V114.433Z" fill="currentColor"></path>
            <path d="M124.306 171.373C116.523 135.001 119.758 99.5879 134.566 62.5361C135.83 59.7383 137.902 54.7476 140.454 49.4797L131.281 40.0781C131.281 40.0781 130.043 42.271 129.487 43.3044C123.7 54.3191 119.126 66.947 115.285 79.1968C104.974 112.039 104.646 145.361 112.53 178.808C112.53 178.859 112.53 178.909 112.555 178.959H125.924C125.721 177.876 125.469 176.767 125.241 175.733C124.913 174.271 124.61 172.835 124.306 171.373Z" fill="currentColor"></path>
            <path d="M87.3354 142.94C83.0393 143.344 81.4725 146.746 81.7252 150.401C82.357 160.03 83.4942 169.557 85.3137 178.959H98.7072C96.7361 169.129 95.3715 159.173 94.1079 149.191C93.6278 145.31 91.6314 142.537 87.3606 142.94H87.3354Z" fill="currentColor"></path>
            <path d="M175.151 129.657C175.126 126.96 175.101 124.263 175.101 121.541C175.101 118.163 174.621 115.088 171.032 113.929C165.498 112.542 162.693 115.643 162.44 120.734C162.061 128.069 161.985 135.454 162.693 142.789C163.35 149.72 164.714 157.257 166.408 164.566C167.115 167.616 169.339 169.96 172.7 169.985C175.404 169.985 178.007 168.095 178.664 166.154C179.094 164.844 178.917 163.104 178.613 161.693C176.743 153.627 175.758 144.553 175.227 129.632L175.151 129.657Z" fill="currentColor"></path>
            <path d="M53.1696 52.5547C57.8447 37.6583 63.935 23.4425 71.1877 9.78125L44.4259 38.3389C27.9494 83.0279 23.4765 129.91 31.3104 178.934H44.2996C37.249 136.211 40.1299 94.1183 53.1443 52.5547H53.1696Z" fill="currentColor"></path>
            <path d="M105.658 33.7011C97.1666 50.0846 90.5962 67.1738 85.997 84.9688H85.9464C85.3905 87.0608 83.6721 94.7484 83.4952 96.0591C81.6504 106.116 80.8923 115.518 80.6396 121.693C80.4374 126.709 79.7298 132.506 86.5529 132.884C92.3146 133.212 92.8706 128.07 93.2497 123.407C94.3616 109.267 97.0403 94.6224 101.26 79.1211C104.445 69.3162 108.311 59.4862 112.809 49.1772C115.538 43.38 118.672 36.9778 121.806 30.3488L112.253 20.5439C110.131 24.9549 107.856 29.3154 105.607 33.6507L105.658 33.7011Z" fill="currentColor"></path>
            <path d="M4.62511 177.346C4.72619 177.925 4.85254 178.934 4.85254 178.934H17.8417C17.8417 178.934 17.4627 176.363 17.2605 175.052C11.7515 140.344 12.0294 105.788 19.737 71.4078C20.3688 68.61 21.5818 62.7119 21.5818 62.7119L4.19551 80.9102C-1.81894 113.526 -1.1619 144.402 4.59984 177.321L4.62511 177.346Z" fill="currentColor"></path>
          </svg>
        </div>
      </div>

      <div class="split-form_layout grid md:grid-cols-2 gap-u-8 items-top z-20 relative">

        {{-- Content Column (Left) --}}
        <div class="content-column flex flex-col items-top order-1">
          @if ($formImage)
          <x-visual :visual="[
              'media_type' => 'image',
              'image' => $formImage,
              'aspect_ratio' => $imageAspectRatio,
              'stretch_to_content' => false,
            ]" />
          @endif
        </div>

        {{-- Form Column (Right) --}}
        <div class="form-column flex flex-col gap-u-6 items-top order-2">
          <div class="content-wrapper u-margin-trim text-left u-max-width-70ch mb-0">
            <h2 class="u-text-style-h2 u-margin-bottom-text">
              {!! $formHeading !!}
            </h2>

            <div class="prose text-left u-text-style-main u-margin-bottom-text">
              {!! $formParagraph !!}
            </div>
          </div>

          @if(function_exists('gravity_form'))
          <div class="w-full">
            {!! gravity_form($gravityFormId, false, false, false, null, true, 0, false) !!}
          </div>
          @else
          <div class="w-full p-u-4 bg-gray-100 rounded-small text-center">
            <p class="text-gray-600">Gravity Forms plugin is not active. Please install and activate Gravity Forms.</p>
          </div>
          @endif
        </div>

      </div>
    </div>
  </section>
  @endif

  {{-- Flexible Content Sections --}}
  @if(have_rows('content_blocks'))
    @while(have_rows('content_blocks'))
      @php(the_row())
      @includeFirst([
        'flexible.' . get_row_layout(),
        'flexible.default'
      ])
    @endwhile
  @endif

</article>