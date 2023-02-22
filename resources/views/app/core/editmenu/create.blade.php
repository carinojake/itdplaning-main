<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('coreuiforms.menu.create_menu_element') }}</h4>
              </div>
              <div class="card-body">
                @if (Session::has('message'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                <form action="{{ route('admin.menu.store') }}" method="POST">
                  @csrf
                  <table class="table table-striped table-bordered datatable">
                    <tbody>
                      <tr>
                        <th>
                          {{ __('coreuiforms.menu.menu') }}
                        </th>
                        <td>
                          <select class="form-select" name="menu" id="menu">
                            @foreach ($menulist as $menu1)
                              <option value="{{ $menu1->id }}">{{ $menu1->name }}</option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          {{ __('coreuiforms.menu.user_roles') }}
                        </th>
                        <td>
                          <table class="table">
                            @foreach ($roles as $role)
                              <tr>
                                <td>
                                  <input type="checkbox" name="role[]" value="{{ $role }}" class="form-checkbox" />
                                </td>
                                <td>
                                  {{ $role }}
                                </td>
                              </tr>
                            @endforeach
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          {{ __('coreuiforms.menu.translations') }}
                        </th>
                        <td>
                          <table class="table">
                            @foreach ($langs as $lang)
                              <tr>
                                <td>
                                  {{ $lang->name }}
                                </td>
                                <td>
                                  <input class="form-control" type="text" name="lang_{{ $lang->short_name }}" placeholder="Name {{ $lang->name }}" required />
                                </td>
                              </tr>
                            @endforeach
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          {{ __('coreuiforms.menu.type') }}
                        </th>
                        <td>
                          <select class="form-select" name="type" id="type">
                            <option value="link">Link</option>
                            <option value="title">Title</option>
                            <option value="dropdown">Dropdown</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <th>
                          {{ __('coreuiforms.menu.other') }}:
                        </th>
                        <td>
                          <div id="div-href">
                            {{ __('coreuiforms.menu.href') }}:
                            <input type="text" name="href" class="form-control" placeholder="href" />
                          </div>
                          <br><br>
                          <div id="div-dropdown-parent">
                            {{ __('coreuiforms.menu.dropdown_parent') }}:
                            <select class="form-select" name="parent" id="parent">

                            </select>
                          </div>
                          <br><br>
                          <div id="div-icon">
                            {{ __('coreuiforms.menu.icon') }} - {{ __('coreuiforms.menu.find_icon_class_in') }}:
                            <a href="https://coreui.io/docs/icons/icons-list/#coreui-icons-free-502-icons" target="_blank">
                              {{ __('coreuiforms.menu.coreui_icons_docs') }}
                            </a>
                            <br>
                            <input class="form-control" name="icon" type="text" placeholder="CoreUI Icon class - example: cil-bell">
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <button class="btn btn-primary text-white" type="submit">{{ __('coreuiforms.save') }}</button>
                  <a class="btn btn-secondary text-dark" href="{{ route('admin.menu.index') }}">{{ __('coreuiforms.return') }}</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </x-slot:content>
  <x-slot:javascript>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/menu-create.js') }}"></script>
  </x-slot:javascript>
</x-app-layout>
