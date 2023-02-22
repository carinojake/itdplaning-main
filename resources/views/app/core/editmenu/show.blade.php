<x-app-layout>
  <x-slot:content>
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4> {{ __('coreuiforms.menu.show_menu_element') }} </h4>
              </div>
              <div class="card-body">
                @if (Session::has('message'))
                  <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif

                <table class="table table-striped table-bordered datatable">
                  <tbody>
                    <tr>
                      <th>
                        {{ __('coreuiforms.menu.menu') }}
                      </th>
                      <td>
                        @foreach ($menulist as $menu1)
                          @if ($menu1->id == $menuElement->menu_id)
                            {{ $menu1->name }}
                          @endif
                        @endforeach
                      </td>
                    </tr>
                    <tr>
                      <th>
                        {{ __('coreuiforms.menu.user_roles') }}
                      </th>
                      <td>
                        <?php
                        $first = true;
                        foreach ($menuroles as $menurole) {
                            if ($first === true) {
                                $first = false;
                            } else {
                                echo ', ';
                            }
                            echo $menurole->role_name;
                        }
                        ?>
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
                                        echo $menuLangs[$i]->name;
                                    }
                                }
                                ?>
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
                        {{ $menuElement->slug }}
                      </td>
                    </tr>
                    <tr>
                      <th>
                        {{ __('coreuiforms.menu.href') }}:
                      </th>
                      <td>
                        {{ $menuElement->href }}
                      </td>
                    </tr>
                    <tr>
                      <th>
                        {{ __('coreuiforms.menu.dropdown_parent') }}:
                      </th>
                      <td>
                        <?php
                        if (isset($menuElement->parent_name)) {
                            echo $menuElement->parent_name;
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th>
                        {{ __('coreuiforms.menu.icon') }}
                      </th>
                      <td>
                        <i class="{{ $menuElement->icon }}"></i>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $menuElement->icon }}
                      </td>
                    </tr>
                  </tbody>
                </table>
                <a class="btn btn-secondary text-dark" href="{{ route('admin.menu.index', ['menu' => $menuElement->menu_id]) }}">{{ __('coreuiforms.return') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-slot:content>
</x-app-layout>
