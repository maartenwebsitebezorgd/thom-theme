@php
$contentBlock = get_sub_field('content_block');
$gravityFormId = get_sub_field('gravity_form');
$formTitle = get_sub_field('form_title') ?? false;
$formDescription = get_sub_field('form_description') ?? false;
$styleSettings = get_sub_field('style_settings');

// Layout settings
$contentLayout = get_sub_field('content_layout') ?? 'form-right';
$verticalAlignment = get_sub_field('vertical_alignment') ?? 'items-center';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-8';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';

// Determine column order
$formRight = $contentLayout === 'form-right';
@endphp

<section data-theme="{{ $theme }}" class="u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container">
    <div class="split-form_layout grid md:grid-cols-2 {{ $gapSize }} {{ $verticalAlignment }}">

      @if ($formRight)
      {{-- Content Left, Form Right Layout --}}
      <div class="content-column flex {{ $verticalAlignment }}">
        <x-content-wrapper :content="$contentBlock" />
      </div>
      <div class="form-column flex {{ $verticalAlignment }}">
        @if($gravityFormId && function_exists('gravity_form'))
          <div class="w-full">
            {!! gravity_form($gravityFormId, $formTitle, $formDescription, false, null, true, 0, false) !!}
          </div>
        @elseif($gravityFormId)
          <div class="w-full p-u-4 bg-gray-100 rounded-small text-center">
            <p class="text-gray-600">Gravity Forms plugin is not active. Please install and activate Gravity Forms.</p>
          </div>
        @else
          <div class="w-full p-u-4 bg-gray-100 rounded-small text-center">
            <p class="text-gray-600">Please select a Gravity Form in the page builder.</p>
          </div>
        @endif
      </div>
      @else
      {{-- Content Right, Form Left Layout --}}
      <div class="form-column order-first md:order-first flex {{ $verticalAlignment }}">
        @if($gravityFormId && function_exists('gravity_form'))
          <div class="w-full">
            {!! gravity_form($gravityFormId, $formTitle, $formDescription, false, null, true, 0, false) !!}
          </div>
        @elseif($gravityFormId)
          <div class="w-full p-u-4 bg-gray-100 rounded-small text-center">
            <p class="text-gray-600">Gravity Forms plugin is not active. Please install and activate Gravity Forms.</p>
          </div>
        @else
          <div class="w-full p-u-4 bg-gray-100 rounded-small text-center">
            <p class="text-gray-600">Please select a Gravity Form in the page builder.</p>
          </div>
        @endif
      </div>
      <div class="content-column order-last md:order-last flex {{ $verticalAlignment }}">
        <x-content-wrapper :content="$contentBlock" />
      </div>
      @endif

    </div>
  </div>
</section>
