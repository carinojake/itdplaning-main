<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\MenuLangList;
use Illuminate\Http\Request;
use App\Models\MenusLang;


class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.core.languages.index', ['langs' => MenuLangList::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.core.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'             => 'required|min:1|max:64',
            'shortName'        => 'required|min:1|max:64',
            'is_default'       => 'required|in:true,false'
        ]);
        $menuLang = new MenuLangList();
        $menuLang->name         = $request->input('name');
        $menuLang->short_name   = $request->input('shortName');
        if($request->input('is_default') === 'true'){
            $menuLangList->is_default = true;
        }else{
            $menuLangList->is_default = false;
        }
        $menuLang->save();
        $request->session()->flash('message', 'Successfully created language');
        return redirect()->route('admin.languages.create');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return view('app.core.languages.show', [
            'lang' => MenuLangList::where('id', '=', $id)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('app.core.languages.edit', [
            'lang' => MenuLangList::where('id', '=', $id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuLangList  $menuLangList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name'             => 'required|min:1|max:64',
            'shortName'        => 'required|min:1|max:64',
            'is_default'       => 'required|in:true,false'
        ]);
        $menuLangList = MenuLangList::where('id', '=', $request->input('id'))->first();
        $menuLangList->name = $request->input('name');
        $menuLangList->short_name = $request->input('shortName');
        if($request->input('is_default') === 'true'){
            $menuLangList->is_default = true;
        }else{
            $menuLangList->is_default = false;
        }
        $menuLangList->save();
        $request->session()->flash('message', 'Successfully updated language');
        return redirect()->route('admin.languages.edit', [$request->input('id')]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuLangList  $menuLangList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $menu = MenuLangList::where('id', '=', $id)->first();
        $menusLang = MenusLang::where('lang', '=', $menu->short_name)->first();
        if(!empty($menusLang)){
            $request->session()->flash('message', "Can't delete. Language has one or more assigned tranlsation of menu element");
            $request->session()->flash('back', 'languages.index');
            return view('app.core.shared.universal-info');
        }else{
            $menus = MenuLangList::all();
            if(count($menus) <= 1){
                $request->session()->flash('message', "Can't delete. This is last language on the list");
                $request->session()->flash('back', 'languages.index');
                return view('app.core.shared.universal-info');
            }else{
                if($menu->is_default == true){
                    $request->session()->flash('message', "Can't delete. This is default language");
                    $request->session()->flash('back', 'languages.index');
                    return view('app.core.shared.universal-info');
                }else{
                    $menu->delete();
                    $request->session()->flash('message', 'Successfully deleted language');
                    $request->session()->flash('back', 'languages.index');
                    return view('app.core.shared.universal-info');
                }
            }
        }
    }
}
