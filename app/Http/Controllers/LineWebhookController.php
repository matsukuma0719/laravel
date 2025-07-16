<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\LineMessageService;
use App\Models\Customer;
use App\Models\Menu;
use Illuminate\Support\Str;

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
        if (!$event) {
            return response()->json(['message' => 'No event data'], 400);
        }

        $type = $event['type'] ?? null;
        $userId = $event['source']['userId'] ?? null;
        $replyToken = $event['replyToken'] ?? null;
        $text = $event['message']['text'] ?? null;

        if ($type === 'follow') {
            if (!$replyToken) return response()->json(['message' => 'Missing replyToken'], 400);
            $profile = $this->line->getProfile($userId);
            $name = $profile['displayName'] ?? '未取得';

            Customer::firstOrCreate(
                ['user_id' => $userId],
                ['customer_id' => Str::uuid(), 'name' => $name]
            );

            $this->line->sendQuickReply($replyToken, ['📖メニューから選ぶ', '📅日付から選ぶ']);
            return response()->json(['message' => 'Follow handled']);
        }

        if ($text === '予約') {
            $this->line->sendQuickReply($replyToken, ['📖メニューから選ぶ', '📅日付から選ぶ']);
            return response()->json(['message' => 'Quick reply for reservation sent']);
        }

        if ($text === '📖メニューから選ぶ') {
            $menus = Menu::all();
            $this->line->sendMenuFlex($replyToken, $menus);
            return response()->json(['message' => 'Menu list sent']);
        }

        return response()->json(['message' => 'Unhandled message'], 200);
    }
}
