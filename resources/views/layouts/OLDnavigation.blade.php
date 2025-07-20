{{-- resources/views/layouts/sidebar.blade.php などとして保存 --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900">
<div class="flex min-h-screen">

    <!-- サイドバー -->
    <nav class="w-56 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col">
        <div class="p-6 flex items-center">
            <a href="{{ route('dashboard') }}">
                {{-- ロゴBladeコンポーネント --}}
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>
        <ul class="flex-1 space-y-2 px-4 mt-4">
            <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">
                    {{ __('予約') }}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                    {{ __('顧客') }}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">
                    {{ __('勤務スタッフ') }}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('work_shifts.index')" :active="request()->routeIs('work_shifts.*')">
                    {{ __('勤務シフト') }}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('menus.index')" :active="request()->routeIs('menus.*')">
                    {{ __('メニュー') }}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('line.index')" :active="request()->routeIs('line.*')">
                    {{ __('LINE') }}
                </x-nav-link>
            </li>
        </ul>
        <!-- 下部にユーザー名・ログアウト -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-600">
            <div class="mb-2 text-sm text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-gray-500 hover:text-red-600">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </nav>

    <!-- メインコンテンツ -->
    <div class="flex-1 bg-gray-50 dark:bg-gray-900 min-h-screen">
        @yield('content')
    </div>
</div>
</body>
</html>
