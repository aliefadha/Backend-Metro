@props(['maxWidth' => null])
<td
    {{ $attributes->merge([
        'class' => 'text-xs mb-0',
        'style' => $maxWidth
            ? "max-width: $maxWidth; word-wrap: break-word; word-break: break-word; white-space: normal;"
            : '',
    ]) }}">
    {{ $slot }}
</td>
