<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('coreuiforms.menu.menu_list') }}</h4>
              </div>
              <div class="card-body">
                <div class="row mb-3 ml-3">
                  <a class="btn btn-lg btn-primary text-white" href="{{ route('admin.menu.menu.create') }}">{{ __('coreuiforms.menu.add_new_menu') }}</a>
                </div>
                <table class="table table-striped table-bordered datatable">
                  <thead>
                    <tr>
                      <th>{{ __('coreuiforms.menu.name') }}</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($menulist as $menu1)
                      <tr>
                        <td>
                          {{ $menu1->name }}
                        </td>
                        <td>
                          <a class="btn btn-primary text-white" href="{{ route('admin.menu.index', ['menu' => $menu1->id]) }}">{{ __('coreuiforms.view') }}</a>
                        </td>
                        <td>
                          <a class="btn btn-primary text-white" href="{{ route('admin.menu.menu.edit', ['id' => $menu1->id]) }}">{{ __('coreuiforms.edit') }}</a>
                        </td>
                        <td>
                          <a class="btn btn-danger text-white" href="{{ route('admin.menu.menu.delete', ['id' => $menu1->id]) }}">{{ __('coreuiforms.delete') }}</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
