@php
$contentBlock = get_sub_field('content_block');
$teamMemberId = get_sub_field('team_member');
$styleSettings = get_sub_field('style_settings');

// Layout settings
$contentLayout = get_sub_field('content_layout') ?? 'member-right';
$verticalAlignment = get_sub_field('vertical_alignment') ?? 'justify-center';
$gapSize = get_sub_field('gap_size') ?? 'gap-u-8';
$memberNameTextStyle = get_sub_field('member_name_text_style') ?? 'u-text-style-h4';
$imageAspectRatio = get_sub_field('image_aspect_ratio') ?? 'aspect-[5/4]';
$contentWrapTheme = get_sub_field('content_wrap_theme') ?? 'light';
$wrapperMaxWidth = get_sub_field('wrapper_max_width') ?? 'max-w-full';

// Style settings
$theme = $styleSettings['theme'] ?? 'inherit';
$paddingTop = $styleSettings['padding_top'] ?? 'pt-section-main';
$paddingBottom = $styleSettings['padding_bottom'] ?? 'pb-section-main';
$containerSize = $styleSettings['container_size'] ?? 'max-w-container-main';

// Determine column order using flexbox order classes
$imageOrder = $contentLayout === 'member-left' ? 'order-1' : 'order-2';
$contentOrder = $contentLayout === 'member-left' ? 'order-2' : 'order-1';

// Get team member data
$memberName = '';
$jobTitle = '';
$headshot = null;
$email = '';
$phone = '';

if ($teamMemberId) {
$memberName = get_the_title($teamMemberId);
$jobTitle = get_field('job_title', $teamMemberId);
$headshot = get_field('headshot', $teamMemberId);
$email = get_field('email', $teamMemberId);
$phone = get_field('phone', $teamMemberId);
}
@endphp

<section data-theme="{{ $theme }}" class="u-section {{ $paddingTop }} {{ $paddingBottom }}">
  <div class="u-container {{ $containerSize }}">
    <div data-theme="{{ $contentWrapTheme }}" class="team-contact-cta_content-wrap {{ $wrapperMaxWidth }} mx-auto p-u-5 border border-main overflow-hidden">
      <div class="team-contact-cta_layout flex flex-wrap {{ $gapSize }} {{ $verticalAlignment }}">

        {{-- Image Column --}}
        <div class="image-column flex {{ $verticalAlignment }} {{ $imageOrder }} flex-1 basis-[24rem]">
          @if ($headshot)
          <div class="team-member-headshot w-full {{ $imageAspectRatio }} overflow-hidden">
            <img
              src="{{ $headshot['url'] }}"
              alt="{{ $headshot['alt'] ?: $memberName }}"
              class="w-full h-full object-cover"
              loading="lazy" />
          </div>
          @endif
        </div>

        {{-- Content Column --}}
        <div class="content-column flex flex-col {{ $verticalAlignment }} {{ $contentOrder }} flex-1 basis-[24rem]">
          <div class="content-wrapper">
            <x-content-wrapper :content="$contentBlock" />

            @if ($memberName || $jobTitle || $email || $phone)
            <div class="team-member-info mt-u-6">
              @if ($memberName)
              <h3 class="team-member-name {{ $memberNameTextStyle }} mb-u-3">{{ $memberName }}</h3>
              @endif

              @if ($jobTitle)
              <p class="team-member-role u-text-style-main text-[var(--theme-text)]/60">{{ $jobTitle }}</p>
              @endif

              @if ($email || $phone)
              <ul class="team-member-contact flex flex-col gap-u-3 mt-u-4">
                @if ($email)
                <li class="flex items-center gap-u-2">
                  <span class="contact-icon size-u-4 shrink-0 flex items-center justify-center" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                      <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                      <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                    </svg>
                  </span>
                  <a href="mailto:{{ $email }}" class="contact-link u-text-style-main hover:!underline underline-offset-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-current rounded transition-all">
                    {{ $email }}
                  </a>
                </li>
                @endif

                @if ($phone)
                <li class="flex items-center gap-u-2">
                  <span class="contact-icon size-u-4 shrink-0 flex items-center justify-center" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                      <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                    </svg>
                  </span>
                  <a href="tel:{{ $phone }}" class="contact-link u-text-style-main hover:underline underline-offset-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-current rounded transition-all">
                    {{ $phone }}
                  </a>
                </li>
                @endif
              </ul>
              @endif
            </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</section>