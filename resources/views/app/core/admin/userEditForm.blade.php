<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
            <div class="card">
              <div class="card-header">
                <h4> {{ __('coreuiforms.edit') }}: {{ $user->name }} </h4>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route("admin.users.update", $user->id) }}">
                  @csrf
                  @method('PUT')
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="cil-user icon icon-xl"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('coreuiforms.users.firstname') }}" name="firstname" value="{{ $user->firstname }}" required autofocus>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="cil-user icon icon-xl"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('coreuiforms.users.lastname') }}" name="lastname" value="{{ $user->lastname }}" required autofocus>
                  </div>
                  {{-- <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="cil-user icon icon-xl"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('coreuiforms.users.username') }}" name="name" value="{{ $user->name }}" required autofocus>
                  </div> --}}
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="cil-at icon icon-xl"></i>
                      </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('coreuiforms.users.email') }}" name="email" value="{{ $user->email }}" required>
                  </div>
                  <button class="btn btn-success" type="submit">{{ __('coreuiforms.save') }}</button>
                  <a href="{{ route('admin.users.index') }}" class="btn btn-primary">{{ __('coreuiforms.return') }}</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
