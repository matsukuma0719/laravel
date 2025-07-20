<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
// モデルがまだ無ければ作成してください（下に案あり）
use App\Models\LineSetting;
use App\Models\RichMenu;



class LineSettingController extends Controller
{
    // 設定画面の表示
    public function show()
    {
        // 設定が1件しかない想定（1テーブル1行方式）
        $setting = LineSetting::first();
        return view('line.richmenu.setting', compact('setting'));
    }

    // 設定保存
    public function save(Request $request)
    {
        $data = $request->validate([
            'channel_name' => 'required|string|max:255',
            'channel_access_token' => 'required|string',
        ]);

        $setting = LineSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            LineSetting::create($data);
        }

        return redirect()->back()->with('success', 'チャネル設定を保存しました');
    }

    public function store(Request $request)
    {
        // ① DB保存
        $data = $request->all();
        $richMenu = RichMenu::create($data);

        // ② LineSettingからアクセストークン取得
        $setting = \App\Models\LineSetting::first();
        $accessToken = $setting->channel_access_token ?? null;
        if (!$accessToken) {
            return redirect()->back()->withErrors('アクセストークンが未設定です');
        }

        // ③ LINE APIにPOST
        $menuPayload = [
            'size' => [ 'width' => 2500, 'height' => 1686 ],
            'selected' => true,
            'name' => $richMenu->title,
            'chatBarText' => $setting->chatbar_text ?? 'メニュー',
            'areas' => [
                // ここに $richMenu->areas の値をいい感じに変換してセット
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post('https://api.line.me/v2/bot/richmenu', $menuPayload);

        if ($response->failed()) {
            return redirect()->back()->withErrors('LINEリッチメニューAPIエラー：' . $response->body());
        }

        // ④ richMenuIdを保存
        $richMenu->richmenu_id = $response->json('richMenuId');
        $richMenu->save();

        // 画像アップロードは後続で
        // $image = ...;
        // Http::withToken($accessToken)
        //     ->withHeaders(['Content-Type' => 'image/png'])
        //     ->post('https://api.line.me/v2/bot/richmenu/' . $richMenu->richmenu_id . '/content', $image);

        return redirect()->route('richmenu.index')->with('success', 'リッチメニューを適用しました');
    }

}
