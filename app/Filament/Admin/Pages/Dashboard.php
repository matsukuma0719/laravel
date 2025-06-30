<?php

namespace App\Filament\Admin\Pages;

use App\Models\Reservation;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Dashboard extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.admin.pages.dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'ダッシボード';

    /**
     * 本日分の予約を取得
     */
    protected function getTableQuery(): Builder
    {
        return Reservation::query()
            ->whereDate('date', Carbon::today())
            ->with(['customer', 'menu', 'employee'])
            ->orderBy('start_time');
    }

    /**
     * 表示するカラム定義
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('date')->label('日付'),
            TextColumn::make('start_time')->label('開始時刻'),
            TextColumn::make('end_time')->label('終了時刻'),
            TextColumn::make('customer.name')->label('顧客名'),
            TextColumn::make('menu.menu_name')->label('メニュー'),
            TextColumn::make('employee.name')->label('担当者'),
        ];
    }

    /**
     * カード形式のグリッド設定（任意）
     */
    protected function getTableContentGrid(): ?array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 3,
        ];
    }

    /**
     * データがない場合の表示
     */
    protected function getTableEmptyStateHeading(): ?string
    {
        return '本日の予約はありません';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'このテーブルには本日分の予約が表示されます。';
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-calendar';
    }
}
