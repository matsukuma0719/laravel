<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RichMenuController extends Controller
{
    // 新規作成フォーム表示
    public function create()
    {
        return view('line.richmenu.create');
    }

    // フォーム送信（保存）
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:4096', // 4MBまで
        ]);

        // 画像アップロード処理
        $imagePath = $request->file('image')->store('richmenus', 'public');

        // データ保存例（DB保存する場合はここでModelを使う）
        // 今回は一旦セッションフラッシュのみ
        session()->flash('success', 'リッチメニューを仮保存しました。');

        return redirect()->route('richmenu.create')
                         ->with('image_path', $imagePath)
                         ->with('title', $validated['title']);
    }
}
