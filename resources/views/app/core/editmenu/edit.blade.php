<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>{{ __('coreuiforms.menu.edit_menu_element') }}</h4>
              </div>
              <div class="card-body">
                @if (Session::has('message'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <form action="{{ route('admin.menu.update') }}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $menuElement->id }}" id="menuElementId" />
                  <table class="table table-striped table-bordered datatable">
                    <tbody>
                      <tr>
                        <th>
                          {{ __('coreuiforms.menu.menu') }}
                        </th>
                        <td>
                          <select class="form-select" name="menu" id="menu">
                            @foreach ($menulist as $menu1)
                              @if ($menu1->id == $menuElement->menu_id)
                                <option value="{{ $menu1->id }}" selected>{{ $menu1->name }}</option>
                              @else
                                <option value="{{ $menu1->id }}">{{ $menu1->name }}</option>
                              @endif
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
                                  <?php
                                  $temp = false;
                                  foreach ($menuroles as $menurole) {
                                      if ($role == $menurole->role_name) {
                                          $temp = true;
                                      }
                                  }
                                  if ($temp === true) {
                                      echo '<input checked type="checkbox" name="role[]" value="' . $role . '" class="form-checkbox"/>';
                                  } else {
                                      echo '<input type="checkbox" name="role[]" value="' . $role . '" class="form-checkbox"/>';
                                  }
                                  ?>
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
                                  <?php
                                  $temp = false;
                                  $menuLangId = null;
                                  for ($i = 0; $i < count($menuLangs); $i++) {
                                      if ($lang->short_name == $menuLangs[$i]->lang) {
                                          $temp = true;
                                          $menuLangId = $i;
                                      }
                                  }
                                  ?>
                                  @if ($temp === true)
                                    <input class="form-control" type="text" name="lang_{{ $lang->short_name }}" placeholder="Name {{ $lang->name }}" value="{{ $menuLangs[$menuLangId]->name }}"
                                      required />
                                  @else
                                    <input class="form-control" type="text" name="lang_{{ $lang->short_name }}" placeholder="Name {{ $lang->name }}" required />
                                  @endif
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
                            @if ($menuElement->slug === 'link')
                              <option value="link" selected>Link</option>
                            @else
                              <option value="link">Link</option>
                            @endif
                            @if ($menuElement->slug === 'title')
                              <option value="title" selected>Title</option>
                            @else
                              <option value="title">Title</option>
                            @endif
                            @if ($menuElement->slug === 'dropdown')
                              <option value="dropdown" selected>Dropdown</option>
                            @else
                              <option value="dropdown">Dropdown</option>
                            @endif
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
                            <input type="text" name="href" class="form-control" placeholder="href" value="{{ $menuElement->href }}" />
                          </div>
                          <br><br>
                          <div id="div-dropdown-parent">
                            {{ __('coreuiforms.menu.dropdown_parent') }}:
                            <input type="hidden" id="parentId" value="{{ $menuElement->parent_id }}" />
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
                            <input class="form-control" name="icon" type="text" placeholder="CoreUI Icon class - example: cil-bell" value="{{ $menuElement->icon }}">
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <button class="btn btn-primary text-white" type="submit">{{ __('coreuiforms.save') }}</button>
                  <a class="btn btn-secondary text-dark" href="{{ route('admin.menu.index', ['menu' => $menuElement->menu_id]) }}">{{ __('coreuiforms.return') }}</a>
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
    <script src="{{ asset('js/menu-edit.js') }}"></script>
  </x-slot:javascript>
</x-app-layout>
