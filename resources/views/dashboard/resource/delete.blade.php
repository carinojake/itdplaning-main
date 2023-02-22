@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.delete') }} {{ $formName }}</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <form method="POST" action="{{ route('resource.destroy', ['table' => $table, 'resource' => $id ]) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="marker" value="true">
                            <p>{{ __('coreuiforms.are_you_sure') }} </p>
                            <button
                                type="submit"
                                class="btn btn-danger mt-3"
                            >
                                {{ __('coreuiforms.delete') }} 
                            </button>
                            <a 
                                href="{{ route('resource.index', $table) }}"
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