{{-- resources/views/flexible/hero.blade.php --}}
@php
  $title = get_sub_field('title');
  $subtitle = get_sub_field('subtitle');
  $background = get_sub_field('background_image');
  $textColor = get_sub_field('text_color') ?: 'white';
  $height = get_sub_field('height') ?: 'min-h-screen';
@endphp

<section class="hero relative {{ $height }} flex items-center justify-center overflow-hidden @if($background) bg-cover bg-center @else bg-gray-900 @endif"
         @if($background) style="background-image: url('{{ $background['sizes']['large'] ?? $background['url'] }}')" @endif>
  
  {{-- Background overlay for better text readability --}}
  @if($background)
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
  @endif
  
  {{-- Hero content --}}
  <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center text-{{ $textColor }}">
      
      @if($title)
        <h1 class="h1 mb-6">
          {!! $title !!}
        </h1>
      @endif
      
      @if($subtitle)
        <div class="text-lg sm:text-xl md:text-2xl leading-relaxed max-w-4xl mx-auto opacity-90">
          {!! nl2br(e($subtitle)) !!}
        </div>
      @endif
      
    </div>
  </div>
  
  {{-- Optional: Scroll indicator --}}
  <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-{{ $textColor }} opacity-60">
    <div class="animate-bounce">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
      </svg>
    </div>
  </div>
  
</section>