<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use App\Services\EditMenuViewService;
use App\Models\Menurole;
use App\Http\Menus\GetSidebarMenu;
use App\Models\Menulist;
use App\Models\MenuLangList;
use App\Models\Menus;
use App\Models\MenusLang;
use Illuminate\Validation\Rule;
use App\Services\RolesService;

class MenuElementController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('admin');
  }

  public function index(Request $request)
  {
    if ($request->has('menu')) {
      $menuId = $request->input('menu');
    } else {
      $menuId = Menulist::first();
      if (empty($menuId)) {
        $menuId = 1;
      } else {
        $menuId = $menuId->id;
      }
    }
    $getSidebarMenu = new GetSidebarMenu();
    return view('app.core.editmenu.index', array(
      'menulist'      => Menulist::all(),
      'role'          => 'admin',
      'roles'         => RolesService::get(),
      'menuToEdit'    => $getSidebarMenu->getAll('en', $menuId),
      'thisMenu'      => $menuId,
    ));
  }

  public function moveUp(Request $request)
  {
    $element = Menus::where('id', '=', $request->input('id'))->first();
    $switchElement = Menus::where('menu_id', '=', $element->menu_id)
      ->where('sequence', '<', $element->sequence)
      ->orderBy('sequence', 'desc')->first();
    if (!empty($switchElement)) {
      $temp = $element->sequence;
      $element->sequence = $switchElement->sequence;
      $switchElement->sequence = $temp;
      $element->save();
      $switchElement->save();
    }
    return redirect()->route('admin.menu.index', ['menu' => $element->menu_id]);
  }

  public function moveDown(Request $request)
  {
    $element = Menus::where('id', '=', $request->input('id'))->first();
    $switchElement = Menus::where('menu_id', '=', $element->menu_id)
      ->where('sequence', '>', $element->sequence)
      ->orderBy('sequence', 'asc')->first();
    if (!empty($switchElement)) {
      $temp = $element->sequence;
      $element->sequence = $switchElement->sequence;
      $switchElement->sequence = $temp;
      $element->save();
      $switchElement->save();
    }
    return redirect()->route('admin.menu.index', ['menu' => $element->menu_id]);
  }

  public function getParents(Request $request)
  {
    $menuId = $request->input('menu');
    $result = Menus::join('menus_lang', 'menus.id', '=', 'menus_lang.menus_id')
      ->select('menus.*', 'menus_lang.name as name')
      ->where('menus.menu_id', '=', $menuId)
      ->where('menus_lang.lang', '=', 'en')
      ->where('menus.slug', '=', 'dropdown')
      ->orderBy('menus.sequence', 'asc')->get();
    return response()->json(
      $result
    );
  }

  public function create()
  {
    return view('app.core.editmenu.create', [
      'roles'    => RolesService::get(),
      'menulist' => Menulist::all(),
      'langs'    => MenuLangList::all()
    ]);
  }

  public function getValidateArray($langs)
  {
    $result = [
      'menu' => 'required|numeric',
      'role' => 'required|array',
      'type' => [
        'required',
        Rule::in(['link', 'title', 'dropdown']),
      ],
    ];
    foreach ($langs as $lang) {
      $result['lang_' . $lang->short_name] = 'required|min:1|max:64';
    }
    return $result;
  }

  public function getLastSequence($menuId)
  {
    $result = Menus::select('menus.sequence')
      ->where('menus.menu_id', '=', $menuId)
      ->orderBy('menus.sequence', 'desc')->first();
    return (int)$result['sequence'];
  }

  public function store(Request $request)
  {
    $langs = MenuLangList::all();
    $validatedData = $request->validate($this->getValidateArray($langs));
    $menus = new Menus();
    $menus->slug = $request->input('type');
    $menus->menu_id = $request->input('menu');
    if (strlen($request->input('icon')) > 0) {
      $menus->icon = $request->input('icon');
    }
    if (strlen($request->input('href')) > 0) {
      $menus->href = $request->input('href');
    }
    if ($request->input('type') !== 'title' && $request->input('parent') !== 'none') {
      $menus->parent_id = $request->input('parent');
    }
    $menus->sequence = $this->getLastSequence($request->input('menu')) + 1;
    $menus->save();
    foreach ($request->input('role') as $role) {
      $menuRole = new Menurole();
      $menuRole->role_name = $role;
      $menuRole->menus_id = $menus->id;
      $menuRole->save();
    }
    foreach ($langs as $lang) {
      $menusLang = new MenusLang();
      $menusLang->name = $request->input('lang_' . $lang->short_name);
      $menusLang->lang = $lang->short_name;
      $menusLang->menus_id = $menus->id;
      $menusLang->save();
    }
    $request->session()->flash('message', 'Successfully created menu element');
    return redirect()->route('admin.menu.create');
  }

  public function edit(Request $request)
  {
    return view('app.core.editmenu.edit', [
      'roles'    => RolesService::get(),
      'menulist' => Menulist::all(),
      'langs' => MenuLangList::all(),
      'menuElement' => Menus::where('id', '=', $request->input('id'))->first(),
      'menuLangs' => MenusLang::where('menus_id', '=', $request->input('id'))->get(),
      'menuroles' => Menurole::where('menus_id', '=', $request->input('id'))->get()
    ]);
  }

  public function update(Request $request)
  {
    $langs = MenuLangList::all();
    $validatedData = $request->validate($this->getValidateArray($langs));
    $menus = Menus::where('id', '=', $request->input('id'))->first();
    $menus->slug = $request->input('type');
    $menus->menu_id = $request->input('menu');
    $menus->icon = $request->input('icon');
    $menus->href = $request->input('href');
    if ($request->input('type') === 'title' || $request->input('parent') === 'none') {
      $menus->parent_id = NULL;
    } else {
      if ($request->input('parent') === $request->input('id')) { //can't be self parent
        $menus->parent_id = NULL;
      } else {
        $menus->parent_id = $request->input('parent');
      }
    }
    $menus->save();
    Menurole::where('menus_id', '=', $request->input('id'))->delete();
    foreach ($request->input('role') as $role) {
      $menuRole = new Menurole();
      $menuRole->role_name = $role;
      $menuRole->menus_id = $request->input('id');
      $menuRole->save();
    }
    MenusLang::where('menus_id', '=', $request->input('id'))->delete();
    foreach ($langs as $lang) {
      $menusLang = new MenusLang();
      $menusLang->name = $request->input('lang_' . $lang->short_name);
      $menusLang->lang = $lang->short_name;
      $menusLang->menus_id = $menus->id;
      $menusLang->save();
    }
    $request->session()->flash('message', 'Successfully update menu element');
    return redirect()->route('admin.menu.edit', ['id' => $request->input('id')]);
  }

  public function show(Request $request)
  {
    $menuElement = Menus::join('menus as mparent', 'menus.parent_id', '=', 'mparent.id')
      ->join('menus_lang', 'mparent.id', '=', 'menus_lang.menus_id')
      ->select('menus.*', 'menus_lang.name as parent_name')
      ->where('menus_lang.lang', '=', 'en')
      ->where('menus.id', '=', $request->input('id'))->first();
    if (empty($menuElement)) {
      $menuElement = Menus::where('id', '=', $request->input('id'))->first();
    }
    return view('app.core.editmenu.show', [
      'menulist' => Menulist::all(),
      'langs' => MenuLangList::all(),
      'menuElement' => $menuElement,
      'menuLangs' => MenusLang::where('menus_id', '=', $request->input('id'))->get(),
      'menuroles' => Menurole::where('menus_id', '=', $request->input('id'))->get()
    ]);
  }

  public function delete(Request $request)
  {
    $menus = Menus::where('id', '=', $request->input('id'))->first();
    $menuId = $menus->menu_id;
    $menus->delete();
    Menurole::where('menus_id', '=', $request->input('id'))->delete();
    MenusLang::where('menus_id', '=', $request->input('id'))->delete();
    $request->session()->flash('message', 'Successfully deleted menu element');
    $request->session()->flash('back', 'menu.index');
    $request->session()->flash('backParams', ['menu' => $menuId]);
    return view('app.core.shared.universal-info');
  }
}
