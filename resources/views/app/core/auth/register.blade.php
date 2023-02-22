<x-guest-layout>
  <!-- Validation Errors -->
  <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card mb-4 mx-4">
        <div class="card-body p-4">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>Register</h1>
            <p class="text-medium-emphasis">Create your account</p>
            <x-input-group placeholder="Firstname" id="firstname" type="text" name="firstname" :value="old('firstname')" icon="vendors/@coreui/icons/sprites/free.svg#cil-user" required autofocus/>
            <x-input-group placeholder="Lastname" id="lastname" type="text" name="lastname" :value="old('lastname')" icon="vendors/@coreui/icons/sprites/free.svg#cil-user" required autofocus/>
            <x-input-group placeholder="Email" id="email" type="text" name="email" :value="old('email')" icon="vendors/@coreui/icons/sprites/free.svg#cil-envelope-open" required/>
            <x-input-group placeholder="Password" id="password" type="password" name="password" icon="vendors/@coreui/icons/sprites/free.svg#cil-lock-locked" required/>
            <x-input-group placeholder="Confirm password" id="password_confirmation" type="password" name="password_confirmation" icon="vendors/@coreui/icons/sprites/free.svg#cil-lock-locked" required/>
            <x-button class="btn-block btn-success text-white">
              {{ __('Create Account') }}
            </x-button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
