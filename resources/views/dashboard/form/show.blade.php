@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.bread.show_bread') }} "{{ $form->name }}"</h4></div>
            <div class="card-body">           
                <div class="row">
                    <div class="col-6">
                            <a 
                                href="{{ route('bread.index') }}"
                                class="btn btn-primary mb-3"
                            >
                            {{ __('coreuiforms.return') }}
                            </a>
                        <table class="table">
                          <tr>
                            <td>
                              {{ __('coreuiforms.bread.form_name') }}
                            </td>
                            <td>
                                {{ $form->name }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              {{ __('coreuiforms.bread.table_name_db') }}
                            </td>
                            <td>
                                {{ $form->table_name }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              {{ __('coreuiforms.bread.pagination') }}
                            </td>
                            <td>
                                {{ $form->pagination }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              {{ __('coreuiforms.bread.enable_show') }}
                            </td>
                            <td>
                                {{ $form->read }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              {{ __('coreuiforms.bread.enable_edit') }}
                            </td>
                            <td>
                              {{ $form->edit }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              {{ __('coreuiforms.bread.enable_add') }}
                            </td>
                            <td>
                              {{ $form->add }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                            {{ __('coreuiforms.bread.enable_delete') }}
                            </td>
                            <td>
                              {{ $form->delete }}
                            </td>
                          </tr>
                        </table>
                        @foreach($formFields as $field)
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $field->name }}</h5>
                                    <p>{{ __('coreuiforms.bread.field_type') }}:  <strong>{{ $field->type }}</strong></p>
                                    <p>{{ __('coreuiforms.bread.relation_table') }}: <strong>{{ $field->relation_table }}</strong></p>
                                    <p>{{ __('coreuiforms.bread.relation_column') }}: <strong>{{ $field->relation_column }}</strong></p>
                                    <p>Browse:      {{ $field->browse }}</p>
                                    <p>Read:        {{ $field->read }}</p>
                                    <p>Edit:        {{ $field->edit }}</p>
                                    <p>Add:         {{ $field->add }}</p>
                                </div>
                            </div>
                        @endforeach
                            <a 
                                href="{{ route('bread.index') }}"
                                class="btn btn-primary"
                            >
                              {{ __('coreuiforms.return') }}
                            </a>
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