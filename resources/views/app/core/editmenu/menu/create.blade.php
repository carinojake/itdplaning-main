<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header"><h4>{{ __('coreuiforms.menu.create_menu') }}</h4></div>
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif
                    <form action="{{ route('admin.menu.menu.store') }}" method="POST">
                        @csrf
                        <table class="table table-striped table-bordered datatable">
                            <tbody>
                                <tr>
                                    <th>
                                    {{ __('coreuiforms.menu.name') }}
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" name="name" placeholder="{{ __('coreuiforms.menu.name') }}"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary text-white" type="submit">{{ __('coreuiforms.save') }}</button>
                        <a class="btn btn-secondary text-dark" href="{{ route('admin.menu.menu.index') }}">{{ __('coreuiforms.return') }}</a>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>