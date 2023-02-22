@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                      <h4> {{ __('coreuiforms.notes.note') }}: {{ $note->title }} </h4>
                    </div>
                    <div class="card-body">
                        <h4>{{ __('coreuiforms.notes.author') }}:</h4>
                        <p> {{ $note->user->name }}</p>
                        <h4>{{ __('coreuiforms.notes.title') }}:</h4>
                        <p> {{ $note->title }}</p>
                        <h4>{{ __('coreuiforms.notes.content') }}:</h4> 
                        <p>{{ $note->content }}</p>
                        <h4>{{ __('coreuiforms.notes.applies_to_date') }}:</h4> 
                        <p>{{ $note->applies_to_date }}</p>
                        <h4> {{ __('coreuiforms.notes.status') }}: </h4>
                        <p>
                            <span class="{{ $note->status->class }}">
                              {{ $note->status->name }}
                            </span>
                        </p>
                        <h4>{{ __('coreuiforms.notes.note_type') }}:</h4>
                        <p>{{ $note->note_type }}</p>
                        <a href="{{ route('notes.index') }}" class="btn btn-primary">{{ __('coreuiforms.return') }}</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection