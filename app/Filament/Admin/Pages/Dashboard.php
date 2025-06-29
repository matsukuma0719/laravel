<?php

namespace App\Filament\Admin\Pages;

use App\Models\Reservation;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class Dashboard extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.admin.pages.dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'ダッシュボード';

    protected function getTableQuery(): Builder
    {
        return Reservation::query()
            ->with(['customer', 'menu', 'employee']) // リレーション事前ロード
            ->orderBy('date')
            ->orderBy('start_time');
    }

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
}
