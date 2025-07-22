@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">顧客情報の編集</h2>

    <div class="grid grid-cols-2 gap-8">

        {{-- 左カラム：編集フォーム --}}
        <form method="POST" action="{{ route('customers.update', $customer->customer_id) }}" class="space-y-5">
            @csrf
            @method('PUT')

<div class="relative p-6 border rounded-xl shadow bg-white dark:bg-gray-800">

    <div class="flex gap-6 items-start">
        {{-- 左側：名前とフリガナ（縦並び） --}}
        <div class="flex flex-col gap-3 w-full max-w-md">
            <div>
                <label class="block font-medium text-sm mb-1">氏名（漢字）</label>
                <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                    class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div>
                <label class="block font-medium text-sm mb-1">フリガナ</label>
                <input type="text" name="kana" value="{{ old('kana', $customer->kana) }}"
                    class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue
-300">
            </div>
        </div>

        {{-- 右側：プロフィール画像 --}}
        <div class="flex-shrink-0">
            <img src="{{ $customer->image_url ?? 'https://via.placeholder.com/80' }}"
                alt="プロフィール画像"
                class="w-24 h-24 rounded-full object-cover border shadow">
        </div>
    </div>
        <div class="grid grid-cols-2 gap-4 mt-3 mb-3">
            <div class="flex flex-col">
                <label class="block font-medium text-sm mb-2">性別</label>
                <select name="gender"
                        class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">選択してください</option>
                    <option value="male" {{ old('gender', $customer->gender) === 'male' ? 'selected' : '' }}>男性</option>
                    <option value="female" {{ old('gender', $customer->gender) === 'female' ? 'selected' : '' }}>女性</option>
                    <option value="other" {{ old('gender', $customer->gender) === 'other' ? 'selected' : '' }}>その他</option>
                </select>
            </div>

            <div class="flex flex-col">
                <label class="block font-medium text-sm mb-2">生年月日</label>
                <input type="date" name="birthday" value="{{ old('birthday', $customer->birthday) }}"
                    class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </div>

        {{-- ここから1列ずつ --}}
        <div class="mt-3 mb-3">
            <label class="block font-medium text-sm text-sm mb-2">電話番号</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $customer->phone_number) }}"
                    class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

       <div class="mt-3 mb-3">
            <label class="block font-medium text-sm text-sm mb-2">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                    class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

        <div class="mt-3 mb-3">
            <label class="block font-medium text-sm text-sm mb-2">住所</label>
            <input type="text" name="address" value="{{ old('address', $customer->address) }}"
                    class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-5">
                <label class="block font-medium text-sm mb-2">初回来店日</label>
                <input type="date" name="first_visit" value="{{ old('first_visit', $customer->first_visit) }}"
                        class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div class="mb-5">
                <label class="block font-medium text-sm mb-2">最終来店日</label>
                <input type="date" name="last_visit" value="{{ old('last_visit', $customer->last_visit) }}"
                        class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-5">
                <label class="block font-medium text-sm mb-2">来店回数</label>
                <input type="number" name="visit_count" value="{{ old('visit_count', $customer->visit_count) }}"
                        class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
            <div class="mb-5">
                <label class="block font-medium text-sm mb-2">紹介者</label>
                <input type="text" name="referrer" value="{{ old('referrer', $customer->referrer) }}"
                        class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </div>

       <div class="mb-5">
            <label class="block font-medium text-sm mb-2">備考 / 特記事項</label>
            <textarea name="notes" rows="4"
                        class="w-full px-4 py-2 rounded-xl bg-blue-100 dark:bg-gray-700 border-none focus:outline-none focus:ring-2 focus:ring-blue-300">{{ old('notes', $customer->notes) }}</textarea>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                更新する
            </button>
        </div>
    </div> 
    </form>
        {{-- 右カラム：利用履歴（読み取り専用） --}}
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">直近の利用履歴（3件）</h3>

            @foreach ($customer->reservations->sortByDesc('date')->take(3) as $rsv)
                <div class="border p-4 rounded-lg bg-gray-50 dark:bg-gray-700 space-y-2">
                    <p><strong>実施日:</strong> {{ $rsv->date }}</p>
                    <p><strong>キャンペーン適用:</strong> {{ $rsv->campaign_applied ? '✔' : '—' }}</p>
                    <p><strong>施術メニュー:</strong> {{ $rsv->menu_name }}</p>
                    <p><strong>施術内容:</strong> {{ $rsv->details }}</p>
                    <p><strong>使用薬剤:</strong> {{ $rsv->products }}</p>
                    <p><strong>担当者:</strong> {{ $rsv->emp_name }}</p>
                    <p><strong>希望スタイル:</strong> {{ $rsv->style }}</p>
                    <p><strong>髪質・頭皮:</strong> {{ $rsv->hair_condition }}</p>
                    <p><strong>アレルギー:</strong> {{ $rsv->allergies }}</p>
                    <p><strong>顧客の感想:</strong> {{ $rsv->feedback }}</p>
                    <p><strong>次回提案:</strong> {{ $rsv->next_plan }}</p>
                    <p><strong>備考:</strong> {{ $rsv->memo }}</p>

                    {{-- 画像がある場合 --}}
                    @if (!empty($rsv->images))
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($rsv->images as $img)
                                <img src="{{ $img }}" class="w-24 h-24 object-cover rounded border">
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
