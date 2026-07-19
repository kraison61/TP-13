@props(['name'])

@php($icon = \App\Support\BootstrapIcons::resolveKey($name))

<svg viewBox="{{ \App\Support\BootstrapIcons::viewBox($icon) }}" aria-hidden="true" {{ $attributes->class('icon') }}><use href="#icon-{{ $icon }}"/></svg>
