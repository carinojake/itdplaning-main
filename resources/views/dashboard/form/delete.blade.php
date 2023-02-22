@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.bread.delete_bread') }} "{{ $formName }}"</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <form method="POST" action="{{ route('bread.destroy', $id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="marker" value="true">
                            <p>{{ __('coreuiforms.are_you_sure') }}</p>
                            <button
                                type="submit"
                                class="btn btn-danger mt-3"
                            >
                              {{ __('coreuiforms.delete') }}
                            </button>
                            <a 
                                href="{{ route('bread.index') }}"
                                class="btn btn-primary mt-3"
                            >
                              {{ __('coreuiforms.return') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')


@endsection