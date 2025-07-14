<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\LineMessageService;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Employee;
use App\Models\EmployeeMenu;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class LineWebhookController extends Controller
{
    protected $line;

    public function __construct(LineMessageService $lineMessageService)
    {
        $this->line = $lineMessageService;
    }

    public function handle(Request $request)
    {
        Log::debug('LINE Webhook受信：', $request->all());

        $event = $request->input('events')[0] ?? null;
        if (!$event) return;

        $type = $event['type'] ?? null;
        $userId = $event['source']['userId'] ?? null;
        $replyToken = $event['replyToken'] ?? null;
        $text = $event['message']['text'] ?? null;

        // フォロー時
        if ($type === 'follow') {
            if (!$replyToken) return;
            $profile = $this->line->getProfile($userId);
            $name = $profile['displayName'] ?? '未取得';
            Customer::firstOrCreate(
                ['user_id' => $userId],
                ['customer_id' => Str::uuid(), 'name' => $name]
            );
            $this->line->sendQuickReply($replyToken, ['📖メニューから選ぶ', '📅日付から選ぶ']);
            return;
        }

        // 「予約」のクイックリプライ
        if ($text === '予約') {
            $this->line->sendQuickReply($replyToken, ['📖メニューから選ぶ', '📅日付から選ぶ']);
            return;
        }

        // メニュー選択
        if ($text === '📖メニューから選ぶ') {
            $menus = Menu::all();
            $this->line->sendMenuFlex($replyToken, $menus);
            return;
        }

        // 以降は同様にメニュー→スタッフ→時間選択の処理
    }
}
