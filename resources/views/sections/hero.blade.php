<section class="hero bg-gray-900 text-white py-20">
  <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto text-center">
      <h1 class="text-5xl md:text-6xl font-bold mb-6">
        {{ $title ?? 'Default Hero Title' }}
      </h1>
      <p class="text-xl md:text-2xl mb-8 text-gray-300">
        {{ $subtitle ?? 'Default subtitle text goes here' }}
      </p>
      @if($button ?? true)
        <a href="{{ $buttonUrl ?? '#' }}" 
           class="inline-block bg-blue-600 hover:bg-blue-700 px-8 py-4 rounded-lg text-lg font-semibold transition">
          {{ $buttonText ?? 'Get Started' }}
        </a>
      @endif
    </div>
  </div>
</section>