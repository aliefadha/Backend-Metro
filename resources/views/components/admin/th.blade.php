@props(['rowspan' => null, 'colspan' => null, 'maxWidth' => null])
<th {{ $attributes->merge(['class' => 'text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7', 'style' => "max-width: $maxWidth;"]) }}
    rowspan="{{ $rowspan }}" colspan="{{ $colspan }}">
    {{ $slot }}
</th>
