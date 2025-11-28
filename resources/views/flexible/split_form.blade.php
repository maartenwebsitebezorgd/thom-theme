@php
$contentBlock = get_sub_field('content_block');
$showContactPerson = get_sub_field('show_contact_person') ?? false;
$contactPersonId = get_sub_field('contact_person');
$gravityFormId = get_sub_field('gravity_form');
$formTitle = get_sub_field('form_title') ?? false;
$formDescription = get_sub_field('form_description') ?? false;
$styleSettings = get_sub_field('style_settings');

// Get contact person data
$contactName = '';
$jobTitle = '';
$headshot = null;

if ($showContactPerson && $contactPersonId) {
$contactName = get_the_title($contactPersonId);
$jobTitle = get_field('job_title', $contactPersonId);
$headshot = get_field('headshot', $contactPersonId);
}

// Layout settings
$contentLayout = get_sub_field('content_layout') ?? 'form-right';
$verticalAlignment = get_sub_field('vertical_alignment') ?? 'items-center';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-8';
$columnWidth = get_sub_field('column_width') ?? '1:1';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';

// Determine column order using CSS order classes
$contentOrder = $contentLayout === 'form-right' ? 'order-1' : 'order-2';
$formOrder = $contentLayout === 'form-right' ? 'order-2' : 'order-1';

// Determine grid column classes based on ratio
$gridCols = 'md:grid-cols-2'; // default 50/50
if ($columnWidth === '1:2') {
    $gridCols = 'md:grid-cols-3';
    $contentColSpan = 'md:col-span-1';
    $formColSpan = 'md:col-span-2';
} elseif ($columnWidth === '2:1') {
    $gridCols = 'md:grid-cols-3';
    $contentColSpan = 'md:col-span-2';
    $formColSpan = 'md:col-span-1';
} else {
    $contentColSpan = '';
    $formColSpan = '';
}
@endphp

<section data-theme="{{ $theme }}" class="u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container">
    <div class="split-form_layout grid {{ $gridCols }} {{ $gapSize }} {{ $verticalAlignment }}">

      {{-- Content Column --}}
      <div class="content-column flex flex-col {{ $verticalAlignment }} {{ $contentOrder }} {{ $contentColSpan }}">
        <div class="content-wrapper">
          <x-content-wrapper :content="$contentBlock" />
        </div>

        @if ($showContactPerson && $contactPersonId)
        <div class="contact-person-card mt-u-6 flex flex-col gap-u-4 items-start">
          @if ($headshot)
          <div class="contact-photo shrink-0 aspect-square w-full overflow-hidden">
            <img
              src="{{ $headshot['sizes']['auto'] ?? $headshot['url'] }}"
              alt="{{ $headshot['alt'] ?: $contactName }}"
              class="w-full h-full object-cover"
              loading="lazy" />
          </div>
          @endif

          <div class="contact-info">
            @if ($contactName)
            <p class="contact-name u-text-style-h5 mb-u-3">{{ $contactName }}</p>
            @endif

            @if ($jobTitle)
            <p class="contact-role u-text-style-main text-[var(--theme-text)]/60">{{ $jobTitle }}</p>
            @endif
          </div>
        </div>
        @endif
      </div>

      {{-- Form Column --}}
      <div class="form-column flex {{ $verticalAlignment }} {{ $formOrder }} {{ $formColSpan }}">
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

    </div>
  </div>
</section>