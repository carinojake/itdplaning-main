<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>Language</h4>
              </div>
              <div class="card-body">
                @if (Session::has('message'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                <form method="POST" action="{{ route('admin.languages.update', $lang->id) }}">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="id" value="{{ $lang->id }}" />
                  <table class="table table-bordered datatable">
                    <tbody>
                      <tr>
                        <th>
                          Name
                        </th>
                        <td>
                          <input class="form-control" name="name" value="{{ $lang->name }}" type="text" />
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Short name
                        </th>
                        <td>
                          <input type="text" name="shortName" value="{{ $lang->short_name }}" class="form-control" />
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Is default
                        </th>
                        <td>
                          <select class="form-select" name="is_default">
                            @if ($lang->is_default == true)
                              <option value="false">Regular language</option>
                              <option value="true" selected>Default language</option>
                            @else
                              <option value="false" selected>Regular language</option>
                              <option value="true">Default language</option>
                            @endif
                          </select>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <button class="btn btn-primary text-white" type="submit">Save</button>
                  <a class="btn btn-secondary text-dark" href="{{ route('admin.languages.index') }}">Return</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
