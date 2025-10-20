@php
$logoLight = get_field('logo_light', 'option');
$logoDark = get_field('logo_dark', 'option');
$copyrightText = get_field('copyright_text', 'option');
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
        <p class="text-sm/6 text-balance text-gray-600">Making the world a better place through constructing elegant hierarchies.</p>
        @include('components.socials-list', ['location' => 'footer'])
      </div>
      <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
        <div class="md:grid md:grid-cols-2 md:gap-8">
          <div>
            <h3 class="text-sm/6 font-semibold text-gray-900">Solutions</h3>
            <ul role="list" class="mt-6 space-y-4">
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Marketing</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Analytics</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Automation</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Commerce</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Insights</a>
              </li>
            </ul>
          </div>
          <div class="mt-10 md:mt-0">
            <h3 class="text-sm/6 font-semibold text-gray-900">Support</h3>
            <ul role="list" class="mt-6 space-y-4">
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Submit ticket</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Documentation</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Guides</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="md:grid md:grid-cols-2 md:gap-8">
          <div>
            <h3 class="text-sm/6 font-semibold text-gray-900">Company</h3>
            <ul role="list" class="mt-6 space-y-4">
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">About</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Blog</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Jobs</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Press</a>
              </li>
            </ul>
          </div>
          <div class="mt-10 md:mt-0">
            <h3 class="text-sm/6 font-semibold text-gray-900">Legal</h3>
            <ul role="list" class="mt-6 space-y-4">
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Terms of service</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">Privacy policy</a>
              </li>
              <li>
                <a href="#" class="text-sm/6 text-gray-600 hover:text-gray-900">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
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