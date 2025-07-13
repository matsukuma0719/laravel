<?php

namespace App\Services;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\MessageBuilder\QuickReplyBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

class LineMessageService
{
    protected $bot;

    public function __construct()
    {
        $httpClient = new CurlHTTPClient(config('services.line.channel_access_token'));
        $this->bot = new LINEBot($httpClient, [
            'channelSecret' => config('services.line.channel_secret')
        ]);
    }

    public function sendText(string $replyToken, string $text): void
    {
        $message = new TextMessageBuilder($text);
        $this->bot->replyMessage($replyToken, $message);
    }

    public function sendQuickReply(string $replyToken, array $options): void
    {
        $buttons = [];

        foreach ($options as $label) {
            $action = new MessageTemplateActionBuilder($label, $label);
            $buttons[] = new QuickReplyButtonBuilder($action);
        }

        $quickReply = new QuickReplyMessageBuilder('ご希望の項目を選択してください:', $buttons);
        $this->bot->replyMessage($replyToken, $quickReply);
    }
}
