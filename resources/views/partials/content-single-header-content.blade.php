{{-- This partial contains the header content (categories, title, intro, meta) for single posts --}}

@if($showCategories && !empty($categories))
<div class="post-categories mb-u-5 flex flex-wrap gap-u-2 {{ $headerAlignment === 'text-center' ? 'justify-center' : '' }}">
  @foreach($categories as $category)
  <a href="{{ get_category_link($category->term_id) }}"
    rel="category tag"
    class="u-text-style-small bg-primary/10 text-primary rounded-full hover:bg-primary/20 transition-colors">
    {!! $category->name !!}
  </a>
  @endforeach
</div>
@endif

<h1 class="p-name u-text-style-h1 u-margin-bottom-text" itemprop="headline">
  {!! $title !!}
</h1>

@if($introduction)
<div class="post-introduction u-text-style-medium u-margin-bottom-text prose prose-lg max-w-none" itemprop="description">
  {!! $introduction !!}
</div>
@elseif(has_excerpt())
<p class="post-excerpt u-text-style-medium u-margin-bottom-text" itemprop="description">
  {{ get_the_excerpt() }}
</p>
@endif

<div class="post-meta flex flex-wrap items-center gap-u-2 text-[var(--theme-text)]/70 {{ $headerAlignment === 'text-center' ? 'justify-center' : '' }}">
  @if($showDate)
  <time class="dt-published" datetime="{{ get_post_time('c', true) }}" itemprop="datePublished">
    {{ get_the_date() }}
  </time>
  @endif

  @if($showDate && ($showAuthor || $showReadTime))
  <span aria-hidden="true">•</span>
  @endif

  @if($showAuthor)
  <span class="author-meta">
    <span>{{ __('Door', 'sage') }}</span>
    @php
    // Use team member author if available, otherwise fall back to WordPress user
    if (isset($teamMemberAuthors) && is_array($teamMemberAuthors) && count($teamMemberAuthors) > 0) {
        $authorName = get_the_title($teamMemberAuthors[0]);
        $authorUrl = get_permalink($teamMemberAuthors[0]);
    } else {
        $authorName = get_the_author();
        $authorUrl = get_author_posts_url(get_the_author_meta('ID'));
    }
    @endphp
    <a href="{{ $authorUrl }}" class="p-author h-card" itemprop="author" itemscope itemtype="https://schema.org/Person">
      <span itemprop="name">{{ $authorName }}</span>
    </a>
  </span>
  @endif

  @if($showAuthor && $showReadTime)
  <span aria-hidden="true">•</span>
  @endif

  @if($showReadTime && $readTime)
  <span class="read-time">
    {{ $readTime }} {{ $readTime === 1 ? __('min leestijd', 'sage') : __('min leestijd', 'sage') }}
  </span>
  @endif
</div>