@props([
    'link' => null,
    'type' => 'button',
    'icon' => null,
    'preventDouble' => false,
    'validationClass' => '',
    'class' => ''
])

@if($link)
    <a href="{{ $link }}" {{ $attributes->merge(['class' => "btn $class text-white " . $validationClass]) }}>
        @if($icon)
            <svg class="icon me-2">
                <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#" . $icon) }}"></use>
            </svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => "btn $class text-white " . $validationClass]) }}
        @if($preventDouble == true && $validationClass == '' )
        onclick="this.form.classList.add('was-validated'); if(this.form.checkValidity()) { this.disabled=true; setTimeout(() => this.disabled = false, 5000);this.form.submit(); }"
      {{--   @elseif($preventDouble == true  && $validationClass != '' )
        onclick="this.form.classList.add('was-validated'); if(this.form.checkValidity()){ this.disabled = true ; setTimeout(() => this.disabled = false, 2000; this.form.submit(); }"
 --}}

        @endif

    >
        @if($icon)
            <svg class="icon me-2">
                <use xlink:href="{{ asset('vendors/@coreui/icons/sprites/free.svg#' . $icon) }}"></use>
            </svg>
        @endif
        {{ $slot }}
    </button>
@endif

