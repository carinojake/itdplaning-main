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
                <table class="table table-bordered datatable">
                  <tbody>
                    <tr>
                      <th>
                        Name
                      </th>
                      <td>
                        {{ $lang->name }}
                      </td>
                    </tr>
                    <tr>
                      <th>
                        Short name
                      </th>
                      <td>
                        {{ $lang->short_name }}
                      </td>
                    </tr>
                    <tr>
                      <th>
                        Is default
                      </th>
                      <td>
                        <?php
                        if ($lang->is_default == true) {
                            echo 'YES';
                        } else {
                            echo 'NO';
                        }
                        ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <a class="btn btn-primary text-white" href="{{ route('admin.languages.index') }}">Return</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
