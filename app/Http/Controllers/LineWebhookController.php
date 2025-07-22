<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str; // ←必須

class LineWebhookController extends Controller
{
    public function webhook(Request $request)
    {
        $events = $request->input('events', []);
        foreach ($events as $event) {
            switch ($event['type']) {
                case 'follow':
                    $this->handleFollow($event);
                    break;
                // 今後追加する場合
                // case 'message':
                //     $this->handleMessage($event);
                //     break;
                // case 'unfollow':
                //     $this->handleUnfollow($event);
                //     break;
            }
        }
        return response()->json(['status' => 'ok']);
    }

    // followイベントの個別処理
   private function handleFollow($event)
    {
        $userId = $event['source']['userId'] ?? null;
        $timestamp = $event['timestamp'] ?? now()->timestamp * 1000;
        $profile = $event['profile'] ?? [];

        if ($userId) {
            $exists = Customer::where('user_id', $userId)->exists();
            if (!$exists) {
                $customerId = (string) Str::uuid(); // ←ここでUUID生成

                // Customer作成
                $customer = Customer::create([
                    'customer_id' => $customerId,
                    'user_id'     => $userId,
                    'name'        => $profile['displayName'] ?? null,
                    'created_at'  => \Carbon\Carbon::createFromTimestampMs($timestamp),
                ]);

                // CustomerProfileも同時に作成（必要なら）
                \App\Models\CustomerProfile::create([
                    'customer_id'        => $customerId,
                    'gender'             => $profile['gender'] ?? null,
                    'birthday'           => $profile['birthday'] ?? null,
                    'phone_number'       => $profile['phone_number'] ?? null,
                    'address'            => $profile['address'] ?? null,
                    'mail_address'       => $profile['mail_address'] ?? null,
                    'first_visit_date'   => $profile['first_visit_date'] ?? null,
                    'last_visit_date'    => $profile['last_visit_date'] ?? null,
                    'numeber_visit_store'=> $profile['numeber_visit_store'] ?? null,
                    'memo'               => $profile['memo'] ?? null,
                ]);
            }
        }
    }

}
