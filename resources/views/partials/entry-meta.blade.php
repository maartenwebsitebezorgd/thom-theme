@php
$readTime = get_field('read_time');
if (!$readTime && is_single()) {
$content = get_the_content();
$wordCount = str_word_count(strip_tags($content));
$readTime = max(1, ceil($wordCount / 200));
}
@endphp

<div class="post-meta flex flex-wrap items-center justify-center gap-u-2 u-text-style-small text-[var(--theme-text)]/70">
  <time class="dt-published" datetime="{{ get_post_time('c', true) }}" itemprop="datePublished">
    {{ get_the_date() }}
  </time>

  <span aria-hidden="true">•</span>

  <span class="author-meta">
    <span>{{ __('By', 'sage') }}</span>
    <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" class="p-author h-card" itemprop="author" itemscope itemtype="https://schema.org/Person">
      <span itemprop="name">{{ get_the_author() }}</span>
    </a>
  </span>

  @if($readTime && is_single())
  <span aria-hidden="true">•</span>
  <span class="read-time">
    {{ $readTime }} {{ $readTime === 1 ? __('minute read', 'sage') : __('minutes read', 'sage') }}
  </span>
  @endif
</div>