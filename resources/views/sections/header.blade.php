{{-- resources/views/sections/header.blade.php --}}
@php
  use App\View\Composers\DropdownWalker;
  use App\View\Composers\MobileWalker;
@endphp

<header class="navigation relative isolate z-10 bg-white dark:bg-gray-900">
  <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
    
    {{-- Logo Section --}}
    <div class="flex lg:flex-1">
      <a href="{{ home_url('/') }}" class="-m-1.5 p-1.5">
        <span class="sr-only">{{ get_bloginfo('name') }}</span>
        
        @if(has_custom_logo())
          {!! get_custom_logo() !!}
        @else
          <span class="text-xl font-bold text-gray-900 dark:text-white">
            {{ get_bloginfo('name') }}
          </span>
        @endif
      </a>
    </div>

    {{-- Mobile Menu Button --}}
    <div class="flex lg:hidden">
      <button 
        type="button" 
        id="mobile-menu-button"
        class="mobile-menu-button -m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800"
        aria-expanded="false"
        aria-controls="mobile-menu"
      >
        <span class="sr-only">Open main menu</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6" aria-hidden="true">
          <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>

    {{-- Desktop Navigation with Dropdowns --}}
    <div class="hidden lg:flex lg:gap-x-12">
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
        <a href="{{ home_url('/') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
          Home
        </a>
        <a href="{{ home_url('/about') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
          About
        </a>
        <a href="{{ home_url('/services') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
          Services
        </a>
        <a href="{{ home_url('/contact') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
          Contact
        </a>
      @endif
    </div>

    {{-- CTA Section --}}
    <div class="hidden lg:flex lg:flex-1 lg:justify-end">
      <a href="{{ home_url('/contact') }}" 
         class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-200">
        Get Started
      </a>
    </div>
  </nav>

  {{-- Mobile Menu --}}
  <div class="lg:hidden hidden" id="mobile-menu">
    <div class="fixed inset-0 z-50">
      <div class="mobile-panel fixed inset-y-0 right-0 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10 dark:bg-gray-900 dark:sm:ring-gray-100/10">
        
        {{-- Mobile Header --}}
        <div class="flex items-center justify-between">
          <a href="{{ home_url('/') }}" class="-m-1.5 p-1.5">
            <span class="sr-only">{{ get_bloginfo('name') }}</span>
            @if(has_custom_logo())
              {!! get_custom_logo() !!}
            @else
              <span class="text-xl font-bold text-gray-900 dark:text-white">
                {{ get_bloginfo('name') }}
              </span>
            @endif
          </a>
          
          <button 
            type="button" 
            id="mobile-menu-close"
            class="mobile-menu-button -m-2.5 rounded-md p-2.5 text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800"
          >
            <span class="sr-only">Close menu</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6" aria-hidden="true">
              <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>

        {{-- Mobile Navigation with Accordion --}}
        <div class="mt-6 flow-root">
          <div class="-my-6 divide-y divide-gray-500/10 dark:divide-white/10">
            <div class="space-y-2 py-6">
              @if (has_nav_menu('primary_navigation'))
                {!! wp_nav_menu([
                  'theme_location' => 'primary_navigation',
                  'container' => false,
                  'fallback_cb' => false,
                  'items_wrap' => '%3$s',
                  'walker' => new MobileWalker()
                ]) !!}
              @else
                <a href="{{ home_url('/') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Home</a>
                <a href="{{ home_url('/about') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">About</a>
                <a href="{{ home_url('/services') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Services</a>
                <a href="{{ home_url('/contact') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Contact</a>
              @endif
            </div>
            
            <div class="py-6">
              <a href="{{ home_url('/contact') }}" 
                 class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-indigo-600 hover:bg-indigo-50 dark:text-indigo-400 dark:hover:bg-indigo-900/20">
                Get Started &rarr;
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>