<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('coreuiforms.roles.show_role') }}</h4>
              </div>
              <div class="card-body">
                <table class="table table-striped table-bordered datatable">
                  <thead>
                    <tr>
                      <th>{{ __('coreuiforms.roles.name') }}</th>
                      <th>{{ __('coreuiforms.roles.created_at') }}</th>
                      <th>{{ __('coreuiforms.roles.updated_at') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        {{ $role->name }}
                      </td>
                      <td>
                        {{ $role->created_at }}
                      </td>
                      <td>
                        {{ $role->updated_at }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <a class="btn btn-secondary text-dark" href="{{ route('admin.roles.index') }}">{{ __('coreuiforms.return') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
