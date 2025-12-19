@php
/**
 * Author Card Component
 * Displays team member author information with photo, bio, and contact details
 *
 * @param int $teamMemberAuthorId - ID of the team member post
 * @param string $contentTheme - Theme for the section (default: 'light')
 * @param string $contentMaxWidth - Max width class for content (default: 'max-w-[80ch]')
 */

// Get author data
$authorName = get_the_title($teamMemberAuthorId);
$authorJobTitle = get_field('job_title', $teamMemberAuthorId);
$authorHeadshot = get_field('headshot', $teamMemberAuthorId);
$authorBio = get_the_excerpt($teamMemberAuthorId);
$authorEmail = get_field('email', $teamMemberAuthorId);
$authorPhone = get_field('phone', $teamMemberAuthorId);
$authorSocialLinks = get_field('social_links', $teamMemberAuthorId);
$authorPermalink = get_permalink($teamMemberAuthorId);
@endphp

<section data-theme="{{ $contentTheme }}" class="u-section pt-section-tiny pb-section-main">
  <div class="u-container max-w-container-main">
    <div class="{{ $contentMaxWidth }} mx-auto pt-u-5 border-t border-neutral-300">
      <h3 class="u-text-style-h5 mb-u-5">Geschreven door</h3>

      <div class="author-card flex flex-col md:flex-row gap-u-5 items-start">
        @if($authorHeadshot)
        <a href="{{ $authorPermalink }}" class="author-photo shrink-0 group">
          <div class="aspect-square w-u-8 overflow-hidden rounded-full border-1 border-[var(--theme-accent)] transition-transform group-hover:scale-105">
            <img
              src="{{ $authorHeadshot['sizes']['medium'] ?? $authorHeadshot['url'] }}"
              alt="{{ $authorHeadshot['alt'] ?: $authorName }}"
              class="w-full h-full object-cover"
              loading="lazy" />
          </div>
        </a>
        @endif

        <div class="author-info flex-1 u-margin-trim">
          <a href="{{ $authorPermalink }}" class="hover:text-[var(--theme-accent)] transition-colors">
            <h4 class="u-text-style-h6 mb-u-3">{{ $authorName }}</h4>
          </a>

          @if($authorJobTitle)
          <p class="u-text-style-main text-[var(--theme-text)]/60 mb-u-4">{{ $authorJobTitle }}</p>
          @endif

          {{-- Contact Information --}}
          @if($authorEmail || $authorPhone || ($authorSocialLinks && is_array($authorSocialLinks) && count($authorSocialLinks) > 0))
          <div class="space-y-3">
            {{-- Email: Direct mailto link --}}
            @if($authorEmail)
            <a href="mailto:{{ $authorEmail }}" class="block text-[var(--theme-text)]/60 hover:text-[var(--theme-text)] u-text-style-small transition-colors">
              {{ $authorEmail }}
            </a>
            @endif

            {{-- Phone: Direct tel link --}}
            @if($authorPhone)
            <a href="tel:{{ $authorPhone }}" class="block text-[var(--theme-text)]/60 hover:text-[var(--theme-text)] u-text-style-small transition-colors">
              {{ $authorPhone }}
            </a>
            @endif

            {{-- Social Links: External platform links --}}
            @if($authorSocialLinks && is_array($authorSocialLinks) && count($authorSocialLinks) > 0)
            <div class="flex gap-u-2 mt-u-2">
              @foreach($authorSocialLinks as $social)
              @if(is_array($social) && !empty($social['url']))
              <a
                href="{{ $social['url'] }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center w-u-4 h-u-4 rounded-full bg-[var(--theme-text)]/10 hover:bg-[var(--theme-accent)] hover:text-white transition-colors"
                aria-label="{{ $social['platform'] ?? 'Social link' }}">
                @if($social['platform'] === 'facebook')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                @elseif($social['platform'] === 'instagram')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
                @elseif($social['platform'] === 'linkedin')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                </svg>
                @elseif($social['platform'] === 'twitter')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                </svg>
                @elseif($social['platform'] === 'tiktok')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                </svg>
                @elseif($social['platform'] === 'threads')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 6.504 3.616 8.914 3.589 12c.027 3.086.718 5.496 2.057 7.164 1.43 1.781 3.631 2.695 6.54 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.3-1.634-1.75-.192 1.352-.622 2.446-1.284 3.272-.886 1.102-2.14 1.704-3.73 1.79-1.202.065-2.361-.218-3.259-.801-1.063-.689-1.685-1.74-1.752-2.964-.065-1.19.408-2.285 1.33-3.082.88-.76 2.119-1.207 3.583-1.291a13.853 13.853 0 0 1 3.02.142l-.126.742a13.08 13.08 0 0 0-2.858-.13c-1.268.07-2.309.436-3.02 1.061-.687.606-1.031 1.4-.974 2.24.05.867.506 1.606 1.28 2.08.688.424 1.592.635 2.545.592 1.279-.057 2.283-.555 2.99-1.482.65-.85 1.031-1.998 1.135-3.419l.017-.204c0-.027.006-.054.008-.082l.156-.003c.11-.008.22-.016.332-.022.11-.006.22-.011.332-.015l.149-.001c1.398 0 2.531.363 3.367 1.081.845.724 1.341 1.767 1.475 3.106.135 1.339-.225 2.573-.995 3.573-1.021 1.324-2.552 2.024-4.559 2.08l-.007.001z" />
                </svg>
                @else
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 0C5.372 0 0 5.373 0 12s5.372 12 12 12 12-5.373 12-12S18.628 0 12 0zm5.696 9.344c-.013 4.826-3.403 6.797-7.154 6.797-1.421 0-2.742-.416-3.854-1.127 1.324.156 2.646-.211 3.696-1.03-.915-.016-1.688-.621-1.954-1.451.131.025.264.038.401.038.195 0 .384-.027.563-.075-.956-.192-1.676-.981-1.676-1.992v-.025c.282.157.605.251.947.262-.56-.375-.93-.994-.93-1.704 0-.375.101-.726.277-1.029.954 1.17 2.38 1.94 3.987 2.02-.083-.355-.127-.725-.127-1.106 0-1.152.934-2.085 2.086-2.085.6 0 1.142.253 1.522.658.475-.094.921-.268 1.324-.507-.156.486-.487.894-.918 1.151.421-.051.823-.163 1.196-.33-.279.418-.632.786-1.04 1.08z" />
                </svg>
                @endif
              </a>
              @endif
              @endforeach
            </div>
            @endif
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
