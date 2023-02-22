<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-6 col-md-5 col-lg-4 col-xl-12">
            <div class="card">
                <div class="card-header">
                  <h4>{{ __('coreuiforms.users.user') }} {{ $user->name }}</h4>
                </div>
                <div class="card-body">
                    <h4>{{ __('coreuiforms.users.username') }}: {{ $user->name }}</h4>
                    <h4>{{ __('coreuiforms.users.email') }}: {{ $user->email }}</h4>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">{{ __('coreuiforms.return') }}</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>