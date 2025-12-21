{{-- resources/views/sections/header.blade.php --}}
@php
use App\View\Composers\DropdownWalker;
use App\View\Composers\MobileWalker;

// Get Header Theme
$headerTheme = get_field('header_theme', 'option') ?? 'solid-dark';

// Get CTA settings from Theme Options
$showDesktopCta = get_field('show_desktop_cta', 'option') ?? true;
$desktopCtaText = get_field('desktop_cta_text', 'option') ?: 'Get Started';
$desktopCtaUrl = get_field('desktop_cta_url', 'option') ?: home_url('/contact');
$desktopCtaStyle = get_field('desktop_cta_style', 'option') ?: 'primary';
$desktopCtaNewTab = get_field('desktop_cta_new_tab', 'option');

$showMobileCta = get_field('show_mobile_cta', 'option') ?? true;
$mobileCtaText = get_field('mobile_cta_text', 'option') ?: 'Get Started';
$mobileCtaUrl = get_field('mobile_cta_url', 'option') ?: home_url('/contact');
$mobileCtaNewTab = get_field('mobile_cta_new_tab', 'option');

// Build CTA classes based on style
$desktopCtaClasses = match($desktopCtaStyle) {
'secondary' => 'button button--secondary button--small',
'link' => 'button button--link button--small',
default => 'button button--primary button--small',
};
@endphp

<header class="navigation navigation--{{ $headerTheme }} sticky top-0 z-50 w-full isolate">
  <nav aria-label="Global" class="mx-auto flex u-container max-w-container-main items-center gap-u-6 justify-between py-u-3 min-h-[2.75rem]">

    {{-- Logo Section --}}
    <div class="flex">
      <a href="{{ home_url('/') }}" class="-m-1.5 p-1.5">
        <span class="sr-only">{{ get_bloginfo('name') }}</span>

        @php
        // Logo fields are named by WHERE they're used, not their color:
        // - logo_light = Logo FOR light backgrounds (dark colored logo)
        // - logo_dark = Logo FOR dark backgrounds (light colored logo)
        $logoForLightBg = get_field('logo_light', 'option');
        $logoForDarkBg = get_field('logo_dark', 'option');

        // Determine which logo to show based on header theme
        $isLightHeader = in_array($headerTheme, ['solid-light', 'blur-light']);
        $selectedLogo = $isLightHeader ? $logoForLightBg : $logoForDarkBg;

        // Fallback to the other logo if selected one doesn't exist
        if (!$selectedLogo && $isLightHeader && $logoForDarkBg) {
        $selectedLogo = $logoForDarkBg;
        } elseif (!$selectedLogo && !$isLightHeader && $logoForLightBg) {
        $selectedLogo = $logoForLightBg;
        }
        @endphp

        @if($selectedLogo)
        <img
          src="{{ $selectedLogo['url'] }}"
          alt="{{ $selectedLogo['alt'] ?: get_bloginfo('name') }}"
          class="h-12 w-auto" />
        @elseif(has_custom_logo())
        {!! get_custom_logo() !!}
        @else
        <span class="u-text-style-h6">
          {{ get_bloginfo('name') }}
        </span>
        @endif
      </a>
    </div>

    {{-- Mobile Menu Button --}}
    <div class="flex lg:hidden">
      <button
        type="button"
        command="show-modal"
        commandfor="mobile-menu"
        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-[var(--theme-text)] hover:bg-[var(--theme-text)]/5">
        <span class="sr-only">Open main menu</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6" aria-hidden="true">
          <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>

    {{-- Desktop Navigation with Dropdowns using el-popover-group --}}
    <el-popover-group class="hidden lg:flex lg:gap-x-4">
      @if (has_nav_menu('primary_navigation'))
      {!! wp_nav_menu([
      'theme_location' => 'primary_navigation',
      'container' => false,
      'fallback_cb' => false,
      'items_wrap' => '%3$s',
      'walker' => new DropdownWalker()
      ]) !!}
      @else
      {{-- Simple fallback without dropdowns for now --}}
      <a href="{{ home_url('/') }}" class="text-sm/6 font-semibold text-[var(--theme-text)] hover:text-[var(--color-primary)] transition-colors duration-200">
        Home
      </a>
      <a href="{{ home_url('/about') }}" class="text-sm/6 font-semibold text-[var(--theme-text)] hover:text-[var(--color-primary)] transition-colors duration-200">
        About
      </a>
      <a href="{{ home_url('/services') }}" class="text-sm/6 font-semibold text-[var(--theme-text)] hover:text-[var(--color-primary)] transition-colors duration-200">
        Services
      </a>
      <a href="{{ home_url('/contact') }}" class="text-sm/6 font-semibold text-[var(--theme-text)] hover:text-[var(--color-primary)] transition-colors duration-200">
        Contact
      </a>
      @endif
    </el-popover-group>

    {{-- CTA Section --}}
    @if($showDesktopCta)
    <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-u-3 items-center ">
      @php
      $showBelgiumLink = get_field('show_belgium_link', 'option');
      $belgiumUrl = get_field('belgium_url', 'option');
      @endphp

      @if($showBelgiumLink && $belgiumUrl)
      {{-- Belgium Language Switcher --}}
      <a href="{{ $belgiumUrl }}"
        class="flex items-center gap-2 px-3 py-3 rounded text-sm text-[var(--theme-text)]/70 hover:text-[var(--theme-text)] hover:bg-[var(--theme-text)]/5 transition-colors"
        target="_blank" rel="noopener noreferrer">
        <span class="u-text-style-small leading-none">🇧🇪</span>
        <span class="u-text-style-small font-medium leading-none">Belgique</span>
      </a>
      @endif

      {{-- Desktop CTA Button --}}
      <a href="{{ $desktopCtaUrl }}"
        class="{{ $desktopCtaClasses }}"
        @if($desktopCtaNewTab) target="_blank" rel="noopener noreferrer" @endif>
        {{ $desktopCtaText }}
        @if($desktopCtaStyle === 'link')
        <span aria-hidden="true">&rarr;</span>
        @endif
      </a>
    </div>
    @endif
  </nav>

  {{-- Mobile Menu using el-dialog --}}
  <el-dialog>
    <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
      <div tabindex="0" class="fixed inset-0 focus:outline-none">
        <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-[var(--theme-bg)] p-6 sm:max-w-sm sm:ring-1 sm:ring-[var(--theme-border)]">

          {{-- Mobile Header --}}
          <div class="flex items-center justify-between">
            <a href="{{ home_url('/') }}" class="-m-1.5 p-1.5">
              <span class="sr-only">{{ get_bloginfo('name') }}</span>

              @if($selectedLogo)
              <img
                src="{{ $selectedLogo['url'] }}"
                alt="{{ $selectedLogo['alt'] ?: get_bloginfo('name') }}"
                class="h-8 w-auto" />
              @elseif(has_custom_logo())
              {!! get_custom_logo() !!}
              @else
              <span class="text-xl font-bold text-[var(--theme-text)]">
                {{ get_bloginfo('name') }}
              </span>
              @endif
            </a>

            <button
              type="button"
              command="close"
              commandfor="mobile-menu"
              class="-m-2.5 rounded-md p-2.5 text-[var(--theme-text)]/60 hover:bg-[var(--theme-bg-hover)]">
              <span class="sr-only">Close menu</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6" aria-hidden="true">
                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>

          {{-- Mobile Navigation with Accordion --}}
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10 dark:divide-white/10">
              <div class="space-y-1 py-6">
                @if (has_nav_menu('primary_navigation'))
                {!! wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container' => false,
                'fallback_cb' => false,
                'items_wrap' => '%3$s',
                'walker' => new MobileWalker()
                ]) !!}
                @else
                <a href="{{ home_url('/') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-[var(--theme-text)] hover:bg-[var(--theme-bg-hover)]">Home</a>
                <a href="{{ home_url('/about') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-[var(--theme-text)] hover:bg-[var(--theme-bg-hover)]">About</a>
                <a href="{{ home_url('/services') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-[var(--theme-text)] hover:bg-[var(--theme-bg-hover)]">Services</a>
                <a href="{{ home_url('/contact') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-[var(--theme-text)] hover:bg-[var(--theme-bg-hover)]">Contact</a>
                @endif
              </div>

              @if($showMobileCta)
              <div class="py-6 flex flex-col gap-u-4">
                @if($showBelgiumLink && $belgiumUrl)
                {{-- Belgium Language Switcher --}}
                <a href="{{ $belgiumUrl }}"
                  class="flex items-center gap-2 rounded text-sm text-[var(--theme-text)]/70 hover:text-[var(--theme-text)] transition-colors"
                  target="_blank" rel="noopener noreferrer">
                  <span class="u-text-style-small leading-none">🇧🇪</span>
                  <span class="u-text-style-small font-medium leading-none">Belgique</span>
                </a>
                @endif
                {{-- Mobile CTA Button --}}
                <a href="{{ $mobileCtaUrl }}"
                  class="button button--primary button--small"
                  @if($mobileCtaNewTab) target="_blank" rel="noopener noreferrer" @endif>
                  {{ $mobileCtaText }}
                </a>
              </div>
              @endif
            </div>
          </div>
        </el-dialog-panel>
      </div>
    </dialog>
  </el-dialog>
</header>