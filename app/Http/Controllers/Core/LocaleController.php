<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;


class LocaleController extends Controller
{
    public function locale(Request $request)
    {
        //App::setLocale($locale);
        session()->put('locale', $request->input('locale'));
        return redirect()->back();
    }
}
