<?php

namespace App\Services;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\QuickReplyBuilder;
use LINE\LINEBot\MessageBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonsTemplate;
use Illuminate\Support\Facades\Log;

class LineMessageService
{
    protected $bot;

    public function __construct()
    {
        $channelToken = config('services.line.channel_access_token');
        $channelSecret = config('services.line.channel_secret');

        $httpClient = new CurlHTTPClient($channelToken);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);
    }

    public function getProfile($userId)
    {
        $response = $this->bot->getProfile($userId);
        if (!$response->isSucceeded()) return [];

        return json_decode($response->getRawBody(), true);
    }

    public function sendText($replyToken, $text)
    {
        $message = new TextMessageBuilder($text);
        $this->bot->replyMessage($replyToken, $message);
    }

    public function sendQuickReply($replyToken, $options)
    {
        $buttons = [];
        foreach ($options as $label) {
            $action = new MessageTemplateActionBuilder($label, $label);
            $buttons[] = new QuickReplyButtonBuilder($action);
        }

        $quickReply = new QuickReplyBuilder($buttons);
        $message = new TextMessageBuilder("メニューを選択してください", $quickReply);

        $this->bot->replyMessage($replyToken, $message);
    }

    // Flex Message用などの他関数も同様にここへ…
}
