@props(['id' => null])
<table {{ $attributes->merge(['class' => 'table align-items-center mb-0']) }} id={{ $id }}>
    <thead>
        {{ $header }}
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
