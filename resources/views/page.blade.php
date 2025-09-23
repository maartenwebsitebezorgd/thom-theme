{{-- resources/views/page.blade.php --}}
@extends('layouts.app')

@section('content')
  @if(have_rows('content_blocks'))
    @while(have_rows('content_blocks'))
      @php(the_row())
      @includeFirst([
        'flexible.' . get_row_layout(),
        'flexible.default'
      ])
    @endwhile
  @else
    @include('partials.content-page')
  @endif
@endsection