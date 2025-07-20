<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\RichMenu;


class RichMenuController extends Controller
{
    //index.bladeテーブル
    public function index()
    {
        $menus = \App\Models\RichMenu::all();
        return view('line.richmenu.index', compact('menus'));
    }

    // 新規作成フォーム表示
    public function create()
    {
        return view('line.richmenu.create');
    }

    // フォーム送信（保存）
  // use Illuminate\Support\Facades\Storage;
public function store(Request $request)
{
    // 1. titleのみ必須、画像は手動で後でチェック
    $validated = $request->validate([
        'title' => 'required|string|max:255',
    ]);

    $imageUrl = null;

    // cropped_image (Base64) がある場合
    if ($request->filled('cropped_image') && strpos($request->cropped_image, 'data:image/png;base64,') === 0) {
        $data = $request->cropped_image;
        $data = preg_replace('/^data:image\/png;base64,/', '', $data);
        $data = str_replace(' ', '+', $data);
        $imageData = base64_decode($data);

        // ファイル名生成
        $filename = uniqid() . '.png';
        $path = 'public/richmenu_images/' . $filename;

        // 保存
        Storage::put($path, $imageData);

        $imageUrl = Storage::url($path);
        \Log::info('cropped_imageで保存', ['path' => $path]);
    }
    // 通常のアップロード画像（file）もあれば
    elseif ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = $file->store('public/richmenu_images');
        $imageUrl = Storage::url($path);
        \Log::info('imageファイルで保存', ['path' => $path]);
    } else {
        \Log::error('画像がPOSTされていません');
        return back()->with('error', '画像ファイルが選択されていません');
    }

    // DB保存
    $richmenu = new RichMenu();
    $richmenu->title = $validated['title'];
    $richmenu->image_path = $imageUrl;
    // 他のカラムも必要に応じて
    $richmenu->save();

    return redirect()->route('richmenu.index')->with('success', 'リッチメニューを登録しました');
}

public function apply($id)
{
    \Log::info('RichMenu apply called', ['id' => $id]);

    $richMenu = \App\Models\RichMenu::findOrFail($id);
    $setting = \App\Models\LineSetting::first();

    if (!$setting || !$setting->channel_access_token) {
        return back()->withErrors('アクセストークン未設定');
    }

    // areasをAPI用に変換
    $apiAreas = [];
    foreach ($richMenu->areas ?? [] as $area) {
        $apiAreas[] = [
            'bounds' => [
                'x' => intval($area['x'] ?? 0),
                'y' => intval($area['y'] ?? 0),
                'width' => intval($area['w'] ?? 0),
                'height' => intval($area['h'] ?? 0),
            ],
            'action' => [
                'type' => $area['type'] ?? 'message',
                'text' => $area['text'] ?? '',
            ],
        ];
    }

    $payload = [
        'size' => ['width' => 2500, 'height' => 1686],
        'selected' => true,
        'name' => $richMenu->title,
        'chatBarText' => $setting->chatbar_text ?? 'メニュー',
        'areas' => $apiAreas,
    ];

    \Log::info('LINE API payload', $payload);

    // リッチメニュー本体の登録
    $response = \Illuminate\Support\Facades\Http::withToken($setting->channel_access_token)
        ->post('https://api.line.me/v2/bot/richmenu', $payload);

    \Log::info('LINE API response', [
        'status' => $response->status(),
        'body' => $response->body()
    ]);

    if ($response->failed()) {
        return back()->withErrors('LINE APIエラー: ' . $response->body());
    }

    $richMenuId = $response->json('richMenuId');
    $richMenu->richmenu_id = $richMenuId;
    $richMenu->save();

    // 画像アップロード
    if ($richMenu->image_path) {
        // image_pathが '/storage/richmenu_images/xxx.png' の場合の対応
        $webPath = $richMenu->image_path;

        if (strpos($webPath, '/storage/') === 0) {
            // '/storage/'を除去して物理パスに
            $relativePath = str_replace('/storage/', '', $webPath);
            $imagePath = storage_path('app/public/' . $relativePath);
        } elseif (strpos($webPath, 'public/') === 0) {
            // 'public/'始まりの場合
            $imagePath = storage_path('app/' . $webPath);
        } else {
            // それ以外（絶対パスなど）はそのまま
            $imagePath = $webPath;
        }

        // ファイルが存在しない場合はエラー
        if (!file_exists($imagePath)) {
            \Log::error('画像ファイルが見つかりません: ' . $imagePath);
            return back()->withErrors('画像ファイルが見つかりません: ' . $imagePath);
        }

        $imageContent = file_get_contents($imagePath);

        $imgRes = \Illuminate\Support\Facades\Http::withToken($setting->channel_access_token)
            ->withHeaders(['Content-Type' => 'image/png'])
            ->put(
                "https://api.line.me/v2/bot/richmenu/{$richMenuId}/content",
                $imageContent
            );

        \Log::info('LINE API image upload', [
            'status' => $imgRes->status(),
            'body' => $imgRes->body()
        ]);

        if ($imgRes->failed()) {
            return back()->withErrors('画像アップロードエラー: ' . $imgRes->body());
        }
    }

    return back()->with('success', 'リッチメニューをLINEに適用しました');
}


    
    public function edit($id)
{
    $menu = \App\Models\RichMenu::findOrFail($id);
    return view('line.richmenu.edit', compact('menu'));
}

public function update(Request $request, $id)
{
    $menu = \App\Models\RichMenu::findOrFail($id);
    // バリデーション＆更新処理
    $menu->update($request->all());
    return redirect()->route('richmenu.index')->with('success', '編集内容を保存しました');
}




}
