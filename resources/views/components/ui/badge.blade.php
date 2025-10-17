@props([
  'variant' => 'default', // default, primary, active, outline
  'size' => 'md', // sm, md, lg
  'href' => null, // if provided, renders as <a>, otherwise <span>
  'active' => false, // shorthand for active variant
])

@php
// Determine variant
$badgeVariant = $active ? 'active' : $variant;

// Build CSS classes using badge.css
$classes = 'badge badge-' . $badgeVariant . ' badge-' . $size;

// Add any additional classes from attributes
if ($attributes->get('class')) {
  $classes .= ' ' . $attributes->get('class');
}
@endphp

@if($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </a>
@else
  <span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </span>
@endif
