<article @php(post_class())>
  <header>
    <h2 class="entry-title text-red-500">
      <a href="{{ get_permalink() }}">
        {!! $title !!}
      </a>
    </h2>

    @include('partials.entry-meta')
  </header>

  <div class="entry-summary">
    @php(the_excerpt())
  </div>
</article>
