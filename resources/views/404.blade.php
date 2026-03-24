@extends('layouts.app')

@section('content')

@php
$recentPosts = get_posts([
  'post_type'      => 'post',
  'posts_per_page' => 3,
  'orderby'        => 'date',
  'order'          => 'DESC',
]);

$homeUrl    = home_url('/');
$contactUrl = get_permalink(get_page_by_path('contact'));
@endphp

{{-- 404 Hero --}}
<section data-theme="grey" class="u-section pt-section-main pb-section-main">
  <div class="u-container max-w-container-main">
    <div class="text-center u-margin-trim mx-auto" style="max-width: 48rem;">

      <p class="u-text-style-tagline mb-u-5">404</p>

      <h1 class="u-text-style-h1 u-margin-bottom-text">
        {{ __('Pagina niet gevonden', 'sage') }}
      </h1>

      <p class="u-text-style-main u-margin-bottom-text">
        {{ __('De pagina die je zoekt bestaat niet meer, is verplaatst of het adres klopt niet. Gebruik de zoekbalk of ga terug naar de homepage.', 'sage') }}
      </p>

      <div class="mt-u-6 flex flex-wrap gap-4 justify-center">
        <a href="{{ $homeUrl }}" class="button button--primary">
          {{ __('Naar de homepage', 'sage') }}
        </a>
        @if ($contactUrl)
        <a href="{{ $contactUrl }}" class="button button--secondary">
          {{ __('Neem contact op', 'sage') }}
        </a>
        @endif
      </div>

    </div>
  </div>
</section>

{{-- Search --}}
<section class="u-section pt-section-small pb-section-small">
  <div class="u-container max-w-container-main">
    <div class="mx-auto" style="max-width: 36rem;">
      <p class="u-text-style-tagline mb-u-5 text-center">{{ __('Zoeken', 'sage') }}</p>
      {!! get_search_form(false) !!}
    </div>
  </div>
</section>

{{-- Recent posts --}}
@if ($recentPosts)
<section data-theme="light" class="u-section pt-section-main pb-section-main">
  <div class="u-container max-w-container-main">

    <div class="mb-u-6 u-margin-trim">
      <p class="u-text-style-tagline mb-u-5">{{ __('Misschien interessant', 'sage') }}</p>
      <h2 class="u-text-style-h2">{{ __('Recente artikelen', 'sage') }}</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-u-4">
      @foreach ($recentPosts as $post)
      @php
        $thumbnail  = get_post_thumbnail_id($post->ID);
        $image      = $thumbnail ? wp_get_attachment_image_src($thumbnail, 'large') : null;
        $categories = get_the_category($post->ID);
        $category   = !empty($categories) ? $categories[0]->name : null;
        $article = [
          'image'             => $image ? ['url' => $image[0], 'alt' => get_post_meta($thumbnail, '_wp_attachment_image_alt', true)] : null,
          'category'          => $category,
          'title'             => $post->post_title,
          'excerpt'           => get_the_excerpt($post),
          'link'              => ['url' => get_permalink($post->ID), 'title' => __('Lees meer', 'sage'), 'target' => '_self'],
          'make_card_clickable' => true,
        ];
      @endphp
      <div>
        <x-article-simple :article="$article" image-aspect-ratio="aspect-[3/2]" section-theme="light" />
      </div>
      @endforeach
    </div>

  </div>
</section>
@endif

@endsection
