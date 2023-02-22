<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Users Management</h2>
            </div>
            <div class="pull-right">
              <a class="btn btn-success" href="{{ route('admin.users.create') }}"> Create New User</a>
            </div>
          </div>
        </div>


        @if ($message = Session::get('success'))
          <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
          </div>
        @endif


        <table class="table table-bordered">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th width="300px">Action</th>
          </tr>
          @foreach ($users as $user)
            <tr>
              <td>{{ $user->firstname }} {{ $user->lastname }}<br>{{ empty($user->department) ? '' : Helper::Department($user->department) }}</td>
              <td>{{ $user->email }}</td>
              <td>
                @if (!empty($user->getRoleNames()))
                  @foreach ($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                  @endforeach
                @endif
              </td>
              <td>
                <a class="btn btn-info" href="{{ route('admin.users.show', $user->id) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                @if ($you->id !== $user->id)
                  <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">{{ __('coreuiforms.delete') }}</button>
                  </form>
                @endif
              </td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
