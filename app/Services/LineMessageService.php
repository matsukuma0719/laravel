<?php

namespace App\Services;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\QuickReplyMessageBuilder;     
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;      // ← ❷
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use Illuminate\Support\Facades\Log;

class LineMessageService
{
    /** @var LINEBot */
    protected $bot;

    public function __construct()
    {
        $httpClient = new CurlHTTPClient(config('services.line.channel_access_token'));

        $this->bot = new LINEBot($httpClient, [
            'channelSecret' => config('services.line.channel_secret'),
        ]);
    }

    /**
     * ユーザープロフィール取得
     */
    public function getProfile(string $userId): array
    {
        $res = $this->bot->getProfile($userId);

        if ($res->isSucceeded()) {
            return $res->getJSONDecodedBody(); // ['displayName'=>…]
        }

        Log::error("LINEプロフィール取得失敗 userId={$userId}");
        return [];
    }

    /**
     * テキスト返信
     */
    public function sendText(string $replyToken, string $text): void
    {
        $msg = new TextMessageBuilder($text);
        $this->bot->replyMessage($replyToken, $msg);
    }

    /**
     * クイックリプライ返信
     */
    public function sendQuickReply(string $replyToken, array $options): void
    {
        $items = [];

        foreach ($options as $label) {
            // ボタン生成
            $action   = new MessageTemplateActionBuilder($label, $label);
            $items[] = new \LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder($action);

        }

        // QuickReplyMessageBuilder にボタン配列を渡す
        $quickReply = new QuickReplyMessageBuilder($items);

        // TextMessageBuilder の第 2 引数に QuickReply を渡す
        $textMsg = new TextMessageBuilder(
            'ご希望の項目を選択してください:',
            $quickReply
        );

        $this->bot->replyMessage($replyToken, $textMsg);
    }

    /* ======================= ここから下に Flex 用メソッドを後で追加 =======================
       public function sendMenuFlex(string $replyToken, $menus) { … }
       public function sendEmployeeFlex(string $replyToken, $employees) { … }
       public function sendTimeSlotFlex(string $replyToken, $slots) { … }
       public function getAvailableTimeSlots(int $empId, string $date, int $duration) { … }
    ====================================================================== */
}

