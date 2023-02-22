@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.bread.edit_bread') }}</h4></div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                        </div>
                    </div>
                @endif 
                <form method="POST" action="{{ route('bread.update', $form->id) }}">           
                    <div class="row">
                        <div class="col-6">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>{{ __('coreuiforms.bread.form_name') }}</label>
                                <input 
                                    type="text"
                                    name="name"
                                    placeholder="{{ __('coreuiforms.bread.form_name') }}"
                                    class="form-control"
                                    value="{{ $form->name }}"
                                    request
                                >
                            </div>
                            <div class="form-group">
                                <label>{{ __('coreuiforms.bread.pagination') }}</label>
                                <input 
                                    type="number"
                                    name="pagination"
                                    placeholder="{{ __('coreuiforms.bread.pagination') }}"
                                    class="form-control"
                                    value="{{ $form->pagination }}"
                                    required
                                >
                            </div>
                            <div class="form-check checkbox mt-3">
                              <input class="form-check-input" type="checkbox" value="true" name="read" 
                                @if( $form->read == 1 )
                                    checked
                                @endif
                              >
                              <label class="form-check-label">{{ __('coreuiforms.bread.enable_show') }}</label>
                            </div>
                            <div class="form-check checkbox">
                              <input class="form-check-input" type="checkbox" value="true" name="edit" 
                                @if( $form->edit == 1 )
                                    checked
                                @endif
                              >
                              <label class="form-check-label">{{ __('coreuiforms.bread.enable_edit') }}</label>
                            </div>
                            <div class="form-check checkbox">
                              <input class="form-check-input" type="checkbox" value="true" name="add" 
                                @if( $form->add == 1 )
                                    checked
                                @endif
                              >
                              <label class="form-check-label">{{ __('coreuiforms.bread.enable_add') }}</label>
                            </div>
                            <div class="form-check checkbox mb-3">
                              <input class="form-check-input" type="checkbox" value="true" name="delete" 
                                @if( $form->delete == 1 )
                                    checked
                                @endif
                              >
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
                                            <?php
                                                $flag = false;
                                                foreach($formRoles as $formRole){
                                                    if($formRole == $role){
                                                        $flag = true;
                                                        break;
                                                    }
                                                }
                                                if($flag === true){
                                                    echo '<input class="form-check-input" type="checkbox" value="true" name="_role_' . $role . '" checked>';
                                                    echo '<label class="form-check-label">' . $role . '</label>';
                                                }else{
                                                    echo '<input class="form-check-input" type="checkbox" value="true" name="_role_' . $role . '">';
                                                    echo '<label class="form-check-label">' . $role . '</label>';
                                                }
                                            ?>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            @foreach($formFields as $field)
                                    <div class="card bg-light mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $field->column_name }}</h5>
                                            <label>{{ __('coreuiforms.bread.visible_name') }}</label>
                                            <input 
                                                class="form-control" 
                                                name="{{ $field->id }}_name" 
                                                type="text" 
                                                value="{{ $field->name }}" 
                                                placeholder="{{ __('coreuiforms.bread.visible_name') }}"
                                            >
                                            <label>{{ __('coreuiforms.bread.field_type') }}</label>
                                            <select class="form-control" name="{{ $field->id }}_field_type">
                                                @foreach($options as $option)
                                                    @if($option['value'] == $field->type)
                                                        <option value="{{ $option['value'] }}" selected>{{ $option['name'] }}</option>
                                                    @else
                                                        <option value="{{ $option['value'] }}">{{ $option['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label>{{ __('coreuiforms.bread.relation_table') }}</label>
                                            <input 
                                                class="form-control" 
                                                name="{{ $field->id }}_relation_table" 
                                                type="text" 
                                                placeholder="{{ __('coreuiforms.bread.relation_table') }}"
                                                value="{{ $field->relation_table }}"
                                            >
                                            <label>{{ __('coreuiforms.bread.relation_column') }}</label>
                                            <input 
                                                class="form-control" 
                                                name="{{ $field->id }}_relation_column" 
                                                type="text" 
                                                placeholder="{{ __('coreuiforms.bread.relation_column') }}"
                                                value="{{ $field->relation_column }}"
                                            >
                                            <div class="form-check checkbox">
                                                @if($field->browse == 1)
                                                    <input checked class="form-check-input" name="{{ $field->id }}_browse" type="checkbox" value="true">
                                                @else
                                                    <input class="form-check-input" name="{{ $field->id }}_browse" type="checkbox" value="true">
                                                @endif
                                                <label class="form-check-label">Browse</label>
                                            </div>
                                            <div class="form-check checkbox">
                                                @if($field->read == 1)
                                                    <input checked class="form-check-input" name="{{ $field->id }}_read" type="checkbox" value="true">
                                                @else
                                                    <input class="form-check-input" name="{{ $field->id }}_read" type="checkbox" value="true">
                                                @endif
                                                <label class="form-check-label">Read</label>
                                            </div>
                                            <div class="form-check checkbox">
                                                @if($field->edit == 1)
                                                    <input checked class="form-check-input" name="{{ $field->id }}_edit" type="checkbox" value="true">
                                                @else
                                                    <input class="form-check-input" name="{{ $field->id }}_edit" type="checkbox" value="true">
                                                @endif
                                                <label class="form-check-label">Edit</label>
                                            </div>
                                            <div class="form-check checkbox">
                                                @if($field->add == 1)
                                                    <input checked class="form-check-input" name="{{ $field->id }}_add" type="checkbox" value="true">
                                                @else
                                                    <input class="form-check-input" name="{{ $field->id }}_add" type="checkbox" value="true">
                                                @endif
                                                <label class="form-check-label">Add</label>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                {{ __('coreuiforms.save') }}
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