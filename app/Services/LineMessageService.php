<?php

namespace App\Services;

use GuzzleHttp\Client;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\QuickReply;
use LINE\Clients\MessagingApi\Model\QuickReplyItem;
use LINE\Clients\MessagingApi\Model\MessageAction;
use Nyholm\Psr7\Factory\Psr17Factory;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineMessageService
{
    protected MessagingApiApi $client;

    public function getUserProfile(string $userId): array
    {
        try {
            $response = $this->client->get("/v2/bot/profile/{$userId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('services.line.channel_access_token'),
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('ユーザープロフィール取得エラー: ' . $e->getMessage());
            return [];
        }
    }


public function __construct()
{
    $config = Configuration::getDefaultConfiguration()
        ->setAccessToken(config('services.line.channel_access_token'));

    $this->client = new Client(); // GuzzleHttp\Client
    $this->messagingApi = new MessagingApiApi($this->client, $config);
}

    public function sendText(string $replyToken, string $text): void
    {
        $message = new TextMessage([
            'type' => 'text',
            'text' => $text
        ]);

        $request = new ReplyMessageRequest([
            'replyToken' => $replyToken,
            'messages' => [$message]
        ]);

        $this->client->replyMessage($request);
    }

    public function sendQuickReply(string $replyToken, array $options): void
    {
        $items = [];

        foreach ($options as $label) {
            $action = new MessageAction([
                'label' => $label,
                'text' => $label
            ]);

            $items[] = new QuickReplyItem([
                'action' => $action
            ]);
        }

        $quickReply = new QuickReply(['items' => $items]);

        $message = new TextMessage([
            'type' => 'text',
            'text' => 'ご希望の項目を選択してください',
            'quickReply' => $quickReply
        ]);

        $request = new ReplyMessageRequest([
            'replyToken' => $replyToken,
            'messages' => [$message]
        ]);

        $this->client->replyMessage($request);
    }

    // Flexメッセージ送信用のメソッドなども今後追加可能
}
