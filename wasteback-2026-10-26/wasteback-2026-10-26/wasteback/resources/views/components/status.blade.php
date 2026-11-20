@props(['value'])
<span class="status status-{{ $value }}">{{ str_replace('_', ' ', $value) }}</span>
