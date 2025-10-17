@props([
  'label' => 'Sort by',
  'options' => [],
])

{{--
  Dropdown Filter Component
  TODO: Implement dropdown filtering functionality
  Example usage: Can be used for sorting (newest, oldest), date ranges, etc.
--}}

<div class="dropdown-filter">
  <label class="block text-sm font-medium text-gray-700 mb-u-2">
    {{ $label }}
  </label>
  <select class="w-full px-u-4 py-u-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary transition-colors">
    <option value="">{{ __('Select...', 'sage') }}</option>
    @foreach($options as $value => $optionLabel)
      <option value="{{ $value }}">{{ $optionLabel }}</option>
    @endforeach
  </select>
</div>
