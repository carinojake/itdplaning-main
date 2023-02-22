@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.bread.create_bread') }}</h4></div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                        </div>
                    </div>
                @endif            
                <div class="row">
                    <div class="col-6">
                        <form method="POST" action="{{ route('bread.store') }}">
                            @csrf
                            <input name="marker" value="selectModel" type="hidden">
                            <div class="form-group">
                                <label>{{ __('coreuiforms.bread.table_name_db') }}</label>
                                <input 
                                    type="text"
                                    placeholder="Table name"
                                    name="model"
                                    class="form-control"
                                >
                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                            {{ __('coreuiforms.select') }}
                            </button>
                            <a 
                                href="{{ route('bread.index') }}"
                                class="btn btn-primary"
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