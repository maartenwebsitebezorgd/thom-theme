<!doctype html>
<html {!! language_attributes() !!}>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  {{-- SEO Meta Tags - Will not output if Yoast/Rank Math/AIOSEO is active --}}
  @php
    \App\Helpers\SEO::outputMetaTags();
  @endphp

  {{-- Dynamic Favicons from Theme Options --}}
  @php
    $favicon_ico = get_field('favicon_ico', 'option');
    $favicon_16 = get_field('favicon_16', 'option');
    $favicon_32 = get_field('favicon_32', 'option');
    $apple_touch = get_field('apple_touch_icon', 'option');
    $android_192 = get_field('android_chrome_192', 'option');
    $android_512 = get_field('android_chrome_512', 'option');
    $theme_color = get_field('theme_color', 'option') ?: '#ffffff';
  @endphp

  @if($favicon_ico && isset($favicon_ico['url']))
    <link rel="icon" type="image/x-icon" href="{{ $favicon_ico['url'] }}">
  @else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  @endif

  @if($favicon_16 && isset($favicon_16['url']))
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon_16['url'] }}">
  @else
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  @endif

  @if($favicon_32 && isset($favicon_32['url']))
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $favicon_32['url'] }}">
  @else
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  @endif

  @if($apple_touch && isset($apple_touch['url']))
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $apple_touch['url'] }}">
  @else
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
  @endif

  <link rel="manifest" href="{{ asset('site.webmanifest') }}">
  <meta name="theme-color" content="{{ $theme_color }}">

  <?php do_action('get_header'); ?>
  <?php wp_head(); ?>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body {!! body_class() !!}>
  <?php wp_body_open(); ?>

  <div id="app">
    <a class="sr-only focus:not-sr-only" href="#main">
      {{ __('Skip to content', 'sage') }}
    </a>

    @include('sections.header')

    <main id="main" class="main overflow-hidden">
      @yield('content')
    </main>

    @hasSection('sidebar')
    <aside class="sidebar">
      @yield('sidebar')
    </aside>
    @endif

    @include('sections.footer')
  </div>

  <?php do_action('get_footer'); ?>
  <?php wp_footer(); ?>
</body>

</html>