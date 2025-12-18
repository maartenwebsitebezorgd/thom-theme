{{-- This partial contains the header content (categories, title, intro, meta) for single cases --}}

@if($showCategories && !empty($categories))
<div class="case-categories mb-u-5 flex flex-wrap gap-u-2 {{ $headerAlignment === 'text-center' ? 'justify-center' : '' }}">
  @foreach($categories as $category)
  <a href="{{ get_term_link($category) }}"
    rel="category tag"
    class="u-text-style-small bg-primary/10 text-primary rounded-full hover:bg-primary/20 transition-colors">
    {{ $category->name }}
  </a>
  @endforeach
</div>
@endif

<h1 class="p-name u-text-style-h1 u-margin-bottom-text" itemprop="headline">
  {!! $title !!}
</h1>

@if($introduction)
<div class="case-introduction u-text-style-medium u-margin-bottom-text prose prose-lg max-w-none" itemprop="description">
  {!! $introduction !!}
</div>
@elseif(has_excerpt())
<p class="case-excerpt u-text-style-medium u-margin-bottom-text" itemprop="description">
  {{ get_the_excerpt() }}
</p>
@endif

<div class="case-meta flex flex-wrap items-center gap-u-2 text-[var(--theme-text)]/70 {{ $headerAlignment === 'text-center' ? 'justify-center' : '' }}">
  @if($showDate)
  <time class="dt-published" datetime="{{ get_post_time('c', true) }}" itemprop="datePublished">
    {{ get_the_date() }}
  </time>
  @endif

  @if($showDate && $showAuthor && $teamMembers)
  <span aria-hidden="true">•</span>
  @endif

  @if($showAuthor && $teamMembers && is_array($teamMembers) && count($teamMembers) > 0)
  <span class="author-meta">
    <span>{{ __('Door', 'sage') }}</span>
    @foreach($teamMembers as $index => $member)
      @if($index > 0)<span>, </span>@endif
      <a href="{{ get_permalink($member->ID) }}" class="p-author h-card" itemprop="author" itemscope itemtype="https://schema.org/Person">
        <span itemprop="name">{{ get_the_title($member->ID) }}</span>
      </a>
    @endforeach
  </span>
  @endif
</div>
