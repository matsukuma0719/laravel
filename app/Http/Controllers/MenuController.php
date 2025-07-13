<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all(); // または paginate(12) など
        return view('menus.index', compact('menus'));
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menus.show', compact('menu'));
    }

}
