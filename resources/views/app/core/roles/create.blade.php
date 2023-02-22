<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('coreuiforms.roles.create_new_role') }}</h4>
              </div>
              <div class="card-body">
                @if (Session::has('message'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.roles.store') }}">
                  @csrf
                  <table class="table table-bordered datatable">
                    <tbody>
                      <tr>
                        <th>
                          {{ __('coreuiforms.roles.name') }}
                        </th>
                        <td>
                          <input class="form-control" name="name" type="text" />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <button class="btn btn-primary text-white" type="submit">{{ __('coreuiforms.save') }}</button>
                  <a class="btn btn-secondary text-dark" href="{{ route('admin.roles.index') }}">{{ __('coreuiforms.return') }}</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
