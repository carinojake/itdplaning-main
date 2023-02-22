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

                <form method="POST" action="{{ route('bread.store') }}">
                    @csrf
                    <input name="marker" value="createForm" type="hidden">
                    <input type="hidden" name="model" value="{{ $model }}"> 

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('coreuiforms.bread.form_name') }}</label>
                                <input 
                                    type="text"
                                    name="name"
                                    placeholder="Form name"
                                    class="form-control"
                                    required
                                >
                            </div>
                            <div class="form-group">
                                <label>{{ __('coreuiforms.bread.pagination') }}</label>
                                <input 
                                    type="number"
                                    name="pagination"
                                    placeholder="Records on one page of table"
                                    class="form-control"
                                    value="10"
                                    required
                                >
                            </div>
                            <div class="form-check checkbox mt-3">
                              <input class="form-check-input" type="checkbox" value="true" name="read" checked>
                              <label class="form-check-label">{{ __('coreuiforms.bread.enable_show') }}</label>
                            </div>
                            <div class="form-check checkbox">
                              <input class="form-check-input" type="checkbox" value="true" name="edit" checked>
                              <label class="form-check-label">{{ __('coreuiforms.bread.enable_edit') }}</label>
                            </div>
                            <div class="form-check checkbox">
                              <input class="form-check-input" type="checkbox" value="true" name="add" checked>
                              <label class="form-check-label">{{ __('coreuiforms.bread.enable_add') }}</label>
                            </div>
                            <div class="form-check checkbox mb-3">
                              <input class="form-check-input" type="checkbox" value="true" name="delete" checked>
                              <label class="form-check-label">{{ __('coreuiforms.bread.enable_delete') }}</label>
                            </div>
                    
                    </div>
                    <div class="col-6">
                        <div class="card border-primary">
                            <div class="card-header">
                                <h4>{{ __('coreuiforms.bread.assign_to_roles') }}:</h4>
                            </div>
                            <div class="card-body">
                                @foreach($roles as $role)
                                    <div class="form-check checkbox mt-3">
                                        <input class="form-check-input" type="checkbox" value="true" name="_role_{{ $role }}" checked>
                                        <label class="form-check-label">{{ $role }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                            @foreach($columns as $column)
                                @if($column != 'id')
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $column }}</h5>
                                            <label>{{ __('coreuiforms.bread.visible_name') }}</label>
                                            <input 
                                                class="form-control" 
                                                name="{{ $column }}_name" 
                                                type="text" 
                                                value="{{ $column }}" 
                                                placeholder="{{ __('coreuiforms.bread.visible_name') }}"
                                            >
                                            <label>{{ __('coreuiforms.bread.field_type') }}</label>
                                            <select class="form-control" name="{{ $column }}_field_type">
                                                @foreach($options as $option)
                                                    <option value="{{ $option['value'] }}">{{ $option['name'] }}</option>
                                                @endforeach
                                            </select>
                                            <label>{{ __('coreuiforms.bread.relation_table') }}</label>
                                            <input 
                                                class="form-control" 
                                                name="{{ $column }}_relation_table" 
                                                type="text" 
                                                placeholder="{{ __('coreuiforms.bread.relation_table') }}"
                                            >
                                            <label>{{ __('coreuiforms.bread.relation_column') }}</label>
                                            <input 
                                                class="form-control" 
                                                name="{{ $column }}_relation_column" 
                                                type="text" 
                                                placeholder="{{ __('coreuiforms.bread.relation_column') }}"
                                            >
                                            <div class="form-check checkbox">
                                                <input class="form-check-input" name="{{ $column }}_browse" type="checkbox" value="true">
                                                <label class="form-check-label">Browse</label>
                                            </div>
                                            <div class="form-check checkbox">
                                                <input class="form-check-input" name="{{ $column }}_read" type="checkbox" value="true">
                                                <label class="form-check-label">Read</label>
                                            </div>
                                            <div class="form-check checkbox">
                                                <input class="form-check-input" name="{{ $column }}_edit" type="checkbox" value="true">
                                                <label class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check checkbox">
                                                <input class="form-check-input" name="{{ $column }}_add" type="checkbox" value="true">
                                                <label class="form-check-label">Add</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                {{ __('coreuiforms.save') }}
                            </button>
                            <a 
                                href="{{ route('bread.create') }}"
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