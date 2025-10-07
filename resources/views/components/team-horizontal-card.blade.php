@props([
'card' => [],
'sectionBgColor' => null,
'sectionTheme' => 'inherit',
'cardTheme' => 'light',
'cardBgColor' => 'auto',
])

@php
$teamMemberId = $card['team_member'] ?? null;
$customHeading = $card['custom_heading'] ?? null;
$button = $card['button'] ?? null;

// Auto theme: Use opposite of section theme (light <-> dark)
  if ($cardTheme === 'auto') {
  $cardTheme = match($sectionTheme) {
  'light' => 'dark',
  'dark' => 'light',
  default => 'inherit',
  };
  }

  // Auto background: Use opposite of section background
  if ($cardBgColor === 'auto') {
  $cardBgColor = match($sectionBgColor) {
  'u-background-1' => 'u-background-2',
  'u-background-2' => 'u-background-1',
  default => 'u-background-1',
  };
  }

  // Get team member data
  $teamMember = null;
  if ($teamMemberId) {
  $post = get_post($teamMemberId);
  if ($post) {
  $headshot = get_field('headshot', $teamMemberId);
  $jobTitle = get_field('job_title', $teamMemberId);
  $email = get_field('email', $teamMemberId);
  $phone = get_field('phone', $teamMemberId);

  $teamMember = [
  'name' => $post->post_title,
  'headshot' => $headshot,
  'job_title' => $jobTitle,
  'email' => $email,
  'phone' => $phone,
  ];
  }
  }

  $buttonUrl = $button['url'] ?? null;
  $buttonTarget = $button['target'] ?? '_self';
  $buttonTitle = $button['title'] ?? 'Contact';
  @endphp

  @if($teamMember)
  <div class="team-horizontal-card {{ $cardBgColor }} px-u-6 py-u-6 lg:px-u-8 lg:py-u-8" data-theme="{{ $cardTheme }}">
    <div class="team-horizontal-card-inner flex flex-col lg:flex-row gap-u-6 lg:gap-u-8 items-start">

      {{-- Left side: Heading and button --}}
      <div class="team-horizontal-card-content flex-1 flex flex-col justify-between gap-u-6">
        @if($customHeading)
        <div class="team-horizontal-card-heading">
          <h2 class="u-text-style-h4 flex items-start gap-u-3">
            <span class="text-[var(--theme-text)]/50 shrink-0">📝</span>
            <span>{{ $customHeading }}</span>
          </h2>
        </div>
        @endif

        @if($button)
        <div class="team-horizontal-card-button lg:self-start">
          <a
            href="{{ $buttonUrl }}"
            target="{{ $buttonTarget }}"
            @if($buttonTarget==='_blank' ) rel="noopener noreferrer" @endif
            class="button button--primary">
            {{ $buttonTitle }}
          </a>
        </div>
        @endif
      </div>

      {{-- Right side: Team member info --}}
      <div class="team-horizontal-card-member flex flex-row gap-u-4 items-stretch">
        @if($teamMember['headshot'])
        <div class="team-horizontal-card-avatar size-u-12 rounded-full overflow-hidden shrink-0">
          <img
            src="{{ $teamMember['headshot']['url'] }}"
            alt="{{ $teamMember['headshot']['alt'] ?: $teamMember['name'] }}"
            class="w-full h-full object-cover"
            loading="lazy">
        </div>
        @endif

        <div class="team-horizontal-card-info flex flex-1 flex-col gap-u-1">
          <h3 class="u-text-style-h5">{{ $teamMember['name'] }}</h3>

          @if($teamMember['job_title'])
          <p class="u-text-style-small text-[var(--theme-text)]/70">{{ $teamMember['job_title'] }}</p>
          @endif

          @if($teamMember['phone'])
          <p class="u-text-style-small mt-u-2">
            <a href="tel:{{ str_replace(' ', '', $teamMember['phone']) }}" class="hover:underline">
              {{ $teamMember['phone'] }}
            </a>
          </p>
          @endif

          @if($teamMember['email'])
          <p class="u-text-style-small">
            <a href="mailto:{{ $teamMember['email'] }}" class="hover:underline">
              {{ $teamMember['email'] }}
            </a>
          </p>
          @endif
        </div>
      </div>

    </div>
  </div>
  @endif