@props([
    'icon' => null,
    'title' => null,
    'toolbar' => null,
    'width' => 12,
])
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-9 text-start">
        <h4>
          <i class="{{ $icon }} me-2"></i> {{ $title }}
        </h4>
      </div>
      <div class="col-3 text-end">
        {{ $toolbar }}
      </div>
    </div>
  </div>
  <div class="card-body">
    {{ $slot }}
  </div>
</div>
