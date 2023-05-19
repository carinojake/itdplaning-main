@props([
    'link' => null,
    'type' => 'button',
    'icon' => null
])

@if($link)
    <a href="{{$link}}" {{ $attributes->merge(['class' => 'btn text-white']) }}>
        @if($icon)
        <svg class="icon me-2">
            <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#".$icon) }}"></use>
        </svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{$type}}" {{ $attributes->merge(['class' => 'btn text-white']) }}>
        @if($icon)
        <svg class="icon me-2">
            <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#".$icon) }}"></use>
        </svg>
        @endif
        {{ $slot }}
    </button>
@endif
