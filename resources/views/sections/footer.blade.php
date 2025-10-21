@php
use App\View\Composers\FooterWalker;

$logoLight = get_field('logo_light', 'option');
$logoDark = get_field('logo_dark', 'option');
$copyrightText = get_field('copyright_text', 'option');
$descriptionText = get_field('footer_text', 'option');
@endphp

<footer data-theme="grey" class="u-section pt-section-main pb-section-small">
  <div class="u-container">
    <div class="xl:grid xl:grid-cols-3 xl:gap-8">
      <div class="space-y-8">
        <a href="{{ home_url('/') }}" class="-m-1.5 p-1.5">
          <span class="sr-only">{{ get_bloginfo('name') }}</span>

          @if($logoLight || $logoDark)
          {{-- Show theme-appropriate logo (prefer light logo for grey/light backgrounds) --}}
          @if($logoLight)
          <img
            src="{{ $logoLight['url'] }}"
            alt="{{ $logoLight['alt'] ?: get_bloginfo('name') }}"
            class="h-8 w-auto" />
          @elseif($logoDark)
          <img
            src="{{ $logoDark['url'] }}"
            alt="{{ $logoDark['alt'] ?: get_bloginfo('name') }}"
            class="h-8 w-auto" />
          @endif
          @elseif(has_custom_logo())
          {!! get_custom_logo() !!}
          @else
          <span class="u-text-style-h6">
            {{ get_bloginfo('name') }}
          </span>
          @endif
        </a>
        <div class="text-style-small text-balance prose text-[var(--theme-text)]/70">{!!$descriptionText !!}</div>
        @include('components.socials-list', ['location' => 'footer'])
      </div>
      @php
      // Get footer menu locations
      $footerMenus = [
      'footer_1',
      'footer_2',
      'footer_3',
      'footer_4',
      ];

      // Check which columns have menus assigned
      $activeColumns = [];
      foreach ($footerMenus as $location) {
      if (has_nav_menu($location)) {
      $activeColumns[] = $location;
      }
      }
      @endphp

      @if(!empty($activeColumns))
      <div class="group/footer-menu mt-16 grid grid-cols-2 lg:grid-cols-4 gap-u-6 xl:col-span-2 xl:mt-0">
        @foreach($activeColumns as $location)
        <div class="">
          @php
          $menu = wp_get_nav_menu_object(get_nav_menu_locations()[$location]);
          $menuName = $menu ? $menu->name : '';
          @endphp

          @if($menuName)
          <h3 class="text-sm/6 font-semibold text-[var(--theme-text)]">{{ $menuName }}</h3>
          @endif

          <ul role="list" class="mt-6 space-y-4">
            {!! wp_nav_menu([
            'theme_location' => $location,
            'container' => false,
            'items_wrap' => '%3$s',
            'fallback_cb' => false,
            'walker' => new FooterWalker(),
            ]) !!}
          </ul>
        </div>
        @endforeach
      </div>
      @endif
    </div>
    <div class="mt-16 border-t border-gray-900/10 pt-8 sm:mt-20 lg:mt-24">
      @php
      $currentYear = date('Y');
      $copyrightDisplay = $copyrightText ?: '© ' . $currentYear . ' ' . get_bloginfo('name') . '. All rights reserved.';
      // Replace both {{year}} and {year} placeholders
      $copyrightDisplay = str_replace(['{{year}}', '{year}', '{{YEAR}}', '{YEAR}'], $currentYear, $copyrightDisplay);
      @endphp
      <p class="text-sm/6 text-gray-600">{!! $copyrightDisplay !!}</p>
    </div>
  </div>
</footer>