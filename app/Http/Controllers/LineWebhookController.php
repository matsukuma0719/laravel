<?php

namespace App\Http\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\LineMessageService;
use App\Models\Menu;
use App\Models\Employee;
use App\Models\EmployeeMenu;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\WorkShift;
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
        if ($type === 'follow') {
            $profile = $this->line->getUserProfile($userId);
            $displayName = $profile['displayName'] ?? '未取得';

            Customer::firstOrCreate(
                ['user_id' => $userId],
                [
                    'customer_id' => Str::uuid(),
                    'name' => $displayName,
                ]
            );

            $this->line->sendQuickReply($replyToken, ['📖メニューから選ぶ', '📅日付から選ぶ']);
            return;
        }


        if ($text === '予約') {
            $this->line->sendQuickReply($replyToken, ['📖メニューから選ぶ', '📅日付から選ぶ']);
            return;
        }

        if ($text === '📖メニューから選ぶ') {
            $menus = Menu::all();
            $this->line->sendMenuFlex($replyToken, $menus);
            return;
        }

        // 例：「カットを選択」
        if (preg_match('/(.+)を選択/', $text, $matches)) {
            $menuName = $matches[1];
            $menu = Menu::where('menu_name', $menuName)->first();
            if (!$menu) {
                $this->line->sendText($replyToken, '選択されたメニューが見つかりませんでした。');
                return;
            }

            // menu_id 保存
            Cache::put("menu_{$userId}", $menu->id, 300);

            $employeeIds = EmployeeMenu::where('menu_id', $menu->id)->pluck('employee_id');
            $employees = Employee::whereIn('id', $employeeIds)->get();
            $this->line->sendEmployeeFlex($replyToken, $employees);
            return;
        }

        // 例：「田中太郎を指名」
        if (preg_match('/(.+)を指名/', $text, $matches)) {
            $employeeName = $matches[1];
            $employee = Employee::where('name', $employeeName)->first();
            if (!$employee) {
                $this->line->sendText($replyToken, '担当者が見つかりませんでした。');
                return;
            }

            $menuId = Cache::get("menu_{$userId}");
            $menu = Menu::find($menuId);
            if (!$menu) {
                $this->line->sendText($replyToken, 'メニュー情報が見つかりません。');
                return;
            }

            // employee_id 保存
            Cache::put("employee_{$userId}", $employee->id, 300);

            $date = now()->toDateString();
            $slots = $this->line->getAvailableTimeSlots($employee->id, $date, $menu->duration);
            if (count($slots) === 0) {
                $this->line->sendText($replyToken, '本日の予約枠はありません。');
                return;
            }

            $this->line->sendTimeSlotFlex($replyToken, $slots);
            return;
        }

        // 例：「10:30を選択」
        if (preg_match('/(\d{1,2}:\d{2})を選択/', $text, $matches)) {
            $startTime = $matches[1];
            $menuId = Cache::get("menu_{$userId}");
            $employeeId = Cache::get("employee_{$userId}");

            $menu = Menu::find($menuId);
            $employee = Employee::find($employeeId);
            $customer = Customer::where('user_id', $userId)->first();

            if (!$menu || !$employee || !$customer) {
                $this->line->sendText($replyToken, '予約情報が不完全です。');
                return;
            }

            $start = Carbon::parse($startTime);
            $end = $start->copy()->addMinutes($menu->duration);

            Reservation::create([
                'id' => Str::uuid(),
                'emp_name' => $employee->name,
                'date' => now()->toDateString(),
                'start_time' => $start->format('H:i'),
                'end_time' => $end->format('H:i'),
                'menu_name' => $menu->menu_name,
                'uuid' => $customer->uuid,
                'user_id' => $userId,
                'customer_name' => $customer->name ?? '未登録',
                'created_at' => now(),
            ]);

            $msg = "✅ご予約が完了しました！\n"
                 . "日付：" . now()->format('Y/m/d') . "\n"
                 . "時間：" . $start->format('H:i') . "\n"
                 . "メニュー：" . $menu->menu_name . "\n"
                 . "担当者：" . $employee->name . "\n"
                 . "ご来店お待ちしております。";

            $this->line->sendText($replyToken, $msg);

            // 状態クリア（任意）
            Cache::forget("menu_{$userId}");
            Cache::forget("employee_{$userId}");

            return;
        }
    }
}
