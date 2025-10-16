@extends('layouts.app')

@section('content')
  {{-- Archive Header --}}
  <section class="u-background-light pt-section-small pb-section-small">
    <div class="u-container">
      <div class="u-max-width-70ch mx-auto text-center">
        @if (is_home())
          <h1 class="u-text-style-h1 mb-u-3">{{ __('Blog', 'sage') }}</h1>
        @else
          <h1 class="u-text-style-h1 mb-u-3">{{ get_the_archive_title() }}</h1>
        @endif

        @if (get_the_archive_description())
          <div class="u-text-style-main">
            {!! get_the_archive_description() !!}
          </div>
        @endif
      </div>
    </div>
  </section>

  {{-- Posts Grid --}}
  <section class="pt-section-main pb-section-main">
    <div class="u-container">
      @if (! have_posts())
        <div class="u-max-width-70ch mx-auto text-center">
          <p class="u-text-style-medium mb-u-6">
            {!! __('Sorry, no posts were found.', 'sage') !!}
          </p>
          {!! get_search_form(false) !!}
        </div>
      @else
        @php
          // Build articles array from posts
          $articles = [];
          while (have_posts()) {
            the_post();
            $post_id = get_the_ID();
            $thumbnail = get_post_thumbnail_id($post_id);
            $image = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;
            $categories = get_the_category($post_id);
            $category = !empty($categories) ? $categories[0]->name : null;

            $articles[] = [
              'image' => $image ? [
                'url' => $image[0],
                'alt' => get_post_meta($thumbnail, '_wp_attachment_image_alt', true),
                'width' => $image[1] ?? null,
                'height' => $image[2] ?? null,
              ] : null,
              'category' => $category,
              'title' => get_the_title(),
              'excerpt' => get_the_excerpt(),
              'link' => [
                'url' => get_permalink(),
                'title' => 'Read more',
                'target' => '_self',
              ],
              'make_card_clickable' => true,
            ];
          }
        @endphp

        {{-- Posts Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-u-6">
          @foreach ($articles as $article)
            <x-article-simple
              :article="$article"
              image-aspect-ratio="aspect-[3/2]"
              section-theme="light"
              card-theme="inherit" />
          @endforeach
        </div>

        {{-- Pagination --}}
        @if (function_exists('wp_pagenavi'))
          <div class="mt-section-main">
            {!! wp_pagenavi() !!}
          </div>
        @else
          <div class="mt-section-main flex justify-between gap-u-4">
            <div>
              {!! get_previous_posts_link(__('&larr; Newer Posts', 'sage')) !!}
            </div>
            <div>
              {!! get_next_posts_link(__('Older Posts &rarr;', 'sage')) !!}
            </div>
          </div>
        @endif
      @endif
    </div>
  </section>
@endsection
