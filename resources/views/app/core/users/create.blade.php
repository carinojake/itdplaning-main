<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              <h2>Create New User</h2>
            </div>
            <div class="pull-right">
              <a class="btn btn-primary" href="{{ route('admin.users.index') }}"> Back</a>
            </div>
          </div>
        </div>


        @if (count($errors) > 0)
          <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif



        {!! Form::open(['route' => 'admin.users.store', 'method' => 'POST']) !!}
        <div class="row">
          {{-- <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div> --}}
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>First name:</strong>
              {!! Form::text('firstname', null, ['placeholder' => 'First name', 'class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Last name:</strong>
              {!! Form::text('lastname', null, ['placeholder' => 'Last name', 'class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Email:</strong>
              {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Password:</strong>
              {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Confirm Password:</strong>
              {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>หน่วยงาน:</strong>
              {!! Form::select('department', Helper::Department(), null, ['class' => 'form-control']) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Role:</strong>
              {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        {!! Form::close() !!}


      </div>
    </div>
  </x-slot:content>
</x-app-layout>
