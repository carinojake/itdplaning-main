<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('coreuiforms.users.users') }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm table-striped">
                    <thead>
                      <tr>
                        <th>{{ __('coreuiforms.users.username') }}</th>
                        <th>{{ __('coreuiforms.users.email') }}</th>
                        <th>{{ __('coreuiforms.users.roles') }}</th>
                        <th>{{ __('coreuiforms.users.email_verified_at') }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                        <tr>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->menuroles }}</td>
                          <td>{{ $user->email_verified_at }}</td>
                          <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-block btn-primary">{{ __('coreuiforms.view') }}</a>
                          </td>
                          <td>
                            <a href="{{ route('admin.users.edit', $user->id ) }}" class="btn btn-block btn-primary">{{ __('coreuiforms.edit') }}</a>
                          </td>
                          <td>
                            @if( $you->id !== $user->id )
                            <form action="{{ route('admin.users.destroy', $user->id ) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-block btn-danger">{{ __('coreuiforms.delete') }}</button>
                            </form>
                            @endif
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