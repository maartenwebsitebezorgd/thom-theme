<section data-theme="light" class="e-content u-section pt-section-main pb-section-main">
  <div class="u-container max-w-container-main">
    <div class="prose prose-lg max-w-[80ch] mx-auto u-margin-trim">
      @php(the_content())
    </div>
  </div>
</section>

@if ($pagination())
  <nav class="page-nav u-container max-w-container-main pb-section-small" aria-label="Page">
    {!! $pagination !!}
  </nav>
@endif
